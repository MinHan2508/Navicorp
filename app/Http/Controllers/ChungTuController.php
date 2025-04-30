<?php

namespace App\Http\Controllers;

use App\Models\{ChungTu, LoaiChungTu, TrangThaiChungTu, DoiTac, HuongChungTu, LichSuChungTu, QuyTrinhXuLyChungTu};

use App\Models\User;
use App\Models\PhongBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Auth};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThongBaoXuLyChungTu;



class ChungTuController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $vaiTro = $user->vaiTro->ma_vai_tro ?? '';
        $idPhongBan = $user->id_phongban;



        $query = ChungTu::with(['loaiChungTu', 'nguoiTao.phongBan', 'nguoiGuiDoiTac', 'trangThai', 'huong']);

        // Lọc theo trạng thái theo tab động
        if ($request->has('filter')) {

            $filter = $request->filter;
            $idTaoMoi = TrangThaiChungTu::where('ma_trang_thai', 'TAO_MOI')->value('id');
            $idDuyetCapPhong = TrangThaiChungTu::where('ma_trang_thai', 'DA_DUYET_CAP_PHONG')->value('id');
            $idDaDuyet = TrangThaiChungTu::where('ma_trang_thai', 'DA_DUYET')->value('id');
            $idKySo = TrangThaiChungTu::where('ma_trang_thai', 'DA_KY_SO')->value('id');
            $idDaGui = TrangThaiChungTu::where('ma_trang_thai', 'DA_GUI')->value('id');
            $idTuChoi = TrangThaiChungTu::where('ma_trang_thai', 'TU_CHOI')->value('id');




            switch ($filter) {
                case 'tao_moi':
                    $query->where('id_trang_thai_hien_tai', $idTaoMoi)
                        ->where('id_nguoi_tao', auth()->id());
                    break;

                case 'cho_truong_phong':
                    if (in_array($vaiTro, ['truongphong', 'pho_phong'])) {
                        $query->where('id_trang_thai_hien_tai', $idTaoMoi)
                            ->whereHas('nguoiTao', fn($q) => $q->where('id_phongban', $idPhongBan));
                    } else {
                        // Người không có quyền trưởng/phó phòng => không thấy gì
                        $query->whereRaw('1 = 0');
                    }
                    break;

                case 'cho_lanh_dao':
                    if (in_array($vaiTro, ['giamdoc', 'pho_giam_doc'])) {
                        $query->where('id_trang_thai_hien_tai', $idDuyetCapPhong);
                    } else {
                        // Người không có vai trò lãnh đạo => không thấy gì
                        $query->whereRaw('1 = 0');
                    }
                    break;


                case 'cho_ky_so':
                    // Chỉ hiển thị nếu người dùng có quyền ký số
                    $query->when(
                        $user->coQuyen('ky_so'),
                        fn($q) => $q->where('id_trang_thai_hien_tai', $idDaDuyet),
                        fn($q) => $q->whereRaw('1 = 0') // Không có quyền => không thấy gì
                    );
                    break;





                case 'da_duyet':
                    if (in_array($vaiTro, ['admin', 'giamdoc', 'pho_giamdoc'])) {
                        $query->where('id_trang_thai_hien_tai', $idDaDuyet);
                    } else {
                        // Các vai trò khác vẫn được xem chứng từ đã duyệt của mình/phòng mình
                        $query->where('id_trang_thai_hien_tai', $idDaDuyet)
                            ->where(function ($q) use ($user, $idPhongBan, $vaiTro) {
                                $q->where('id_nguoi_tao', $user->id);

                                if (in_array($vaiTro, ['truongphong', 'pho_phong']) && $idPhongBan) {
                                    $q->orWhereHas('nguoiTao', function ($subQ) use ($idPhongBan) {
                                        $subQ->where('id_phongban', $idPhongBan);
                                    });
                                }
                            });
                    }
                    break;

                case 'tu_choi':
                    $query->where('id_trang_thai_hien_tai', $idTuChoi)
                        ->where(function ($q) use ($user, $idPhongBan, $vaiTro) {
                            $q->where('id_nguoi_tao', $user->id);

                            if (in_array($vaiTro, ['truongphong', 'pho_phong'])) {
                                // Trưởng/phó phòng xem chứng từ từ chối của phòng mình
                                $q->orWhereHas('nguoiTao', fn($subQ) => $subQ->where('id_phongban', $idPhongBan));
                            }

                            if (in_array($vaiTro, ['pho_giam_doc', 'giamdoc'])) {
                                // Giám đốc/phó giám đốc thấy tất cả chứng từ bị từ chối
                                $q->orWhereRaw('1 = 1');
                            }
                        });
                    break;

                case 'da_gui':
                    $query->where('id_trang_thai_hien_tai', $idDaGui);
                    break;
            }
        }
        // ✅ Lọc theo Hướng chứng từ
        if ($request->filled('huong')) {
            $query->whereHas('huong', function ($q) use ($request) {
                $q->where('ten_huong_chung_tu', 'like', '%' . $request->huong . '%');
            });
        }

        // Lọc theo Mã chứng từ
        if ($request->filled('ma_chung_tu')) {
            $query->where('ma_chung_tu', 'like', '%' . $request->ma_chung_tu . '%');
        }

        // Lọc theo Tiêu đề
        if ($request->filled('tieu_de')) {
            $query->where('tieu_de', 'like', '%' . $request->tieu_de . '%');
        }

        // Lọc theo Số hiệu
        if ($request->filled('so_hieu')) {
            $query->where('so_hieu', 'like', '%' . $request->so_hieu . '%');
        }

        // Lọc theo tên loại chứng từ
        if ($request->filled('loai')) {
            $query->whereHas('loaiChungTu', function ($q) use ($request) {
                $q->where('ten_loai_chung_tu', 'like', '%' . $request->loai . '%');
            });
        }

        // ✅ Trạng thái
        if ($request->filled('id_trang_thai')) {
            $query->where('id_trang_thai_hien_tai', $request->id_trang_thai);
        }

        // ✅ Người tạo
        if ($request->filled('id_nguoi_tao')) {
            $keyword = $request->id_nguoi_tao;
            $query->whereHas('nguoiTao', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }


        // ✅ Phòng ban
        if ($request->filled('id_phong_ban')) {
            $query->whereHas('nguoiTao', function ($q) use ($request) {
                $q->where('id_phongban', $request->id_phong_ban);
            });
        }

        // ✅ Ngày tạo (từ - đến)
        if ($request->filled('tu_ngay')) {
            $query->whereDate('created_at', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->whereDate('created_at', '<=', $request->den_ngay);
        }



        // $chungTus = $query->orderByDesc('created_at')->get();

        // Cuối cùng:
        $perPage = $request->input('per_page', 10); // mặc định 10
        $chungTus = $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();

        $loaiChungTus = LoaiChungTu::all();
        $huongChungTus = HuongChungTu::all();

        $nguoiTaos = User::all();
        $trangThais = TrangThaiChungTu::all();
        $phongBans = PhongBan::all();
        $loaiChungTus = LoaiChungTu::all(); // lấy danh sách loại chứng từ


        return view('chungtu.index', compact('chungTus', 'nguoiTaos', 'trangThais', 'phongBans', 'loaiChungTus', 'huongChungTus'));


        // Nếu không phải admin/giamdoc/pho_giamdoc => lọc theo quyền người dùng




    }
    public function indexDi(Request $request)
    {
        $user = auth()->user();
        $query = ChungTu::with(['loaiChungTu', 'trangThai', 'huong', 'nguoiTao.phongBan', 'nguoiGuiDoiTac'])
            ->whereHas('huong', function ($q) {
                $q->where('ma_huong_chung_tu', 'DI');
            });

        $this->applyFilters($request, $query);

        $chungTus = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('chungtu.index', [
            'chungTus' => $chungTus,
            'nguoiTaos' => User::all(),
            'trangThais' => TrangThaiChungTu::all(),
            'phongBans' => PhongBan::all(),
            'loaiChungTus' => LoaiChungTu::all(),
            'huongChungTus' => HuongChungTu::all(),
        ]);
    }

    public function indexNoiBo(Request $request)
    {
        $user = auth()->user();
        $query = ChungTu::with(['loaiChungTu', 'trangThai', 'huong', 'nguoiTao.phongBan', 'nguoiGuiDoiTac'])
            ->whereHas('huong', function ($q) {
                $q->where('ma_huong_chung_tu', 'NOI_BO');
            });

        $this->applyFilters($request, $query);

        $chungTus = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('chungtu.index', [
            'chungTus' => $chungTus,
            'nguoiTaos' => User::all(),
            'trangThais' => TrangThaiChungTu::all(),
            'phongBans' => PhongBan::all(),
            'loaiChungTus' => LoaiChungTu::all(),
            'huongChungTus' => HuongChungTu::all(),
        ]);
    }

    public function indexDen(Request $request)
    {
        $user = auth()->user();
        $query = ChungTu::with(['loaiChungTu', 'trangThai', 'huong', 'nguoiTao.phongBan', 'nguoiGuiDoiTac'])
            ->whereHas('huong', function ($q) {
                $q->where('ma_huong_chung_tu', 'DEN_LUU_TRU');
            });

        $this->applyFilters($request, $query);

        $chungTus = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('chungtu.index', [
            'chungTus' => $chungTus,
            'nguoiTaos' => User::all(),
            'trangThais' => TrangThaiChungTu::all(),
            'phongBans' => PhongBan::all(),
            'loaiChungTus' => LoaiChungTu::all(),
            'huongChungTus' => HuongChungTu::all(),
        ]);
    }
    private function applyFilters(Request $request, &$query)
    {
        if ($request->filled('ma_chung_tu')) {
            $query->where('ma_chung_tu', 'like', '%' . $request->ma_chung_tu . '%');
        }

        if ($request->filled('tieu_de')) {
            $query->where('tieu_de', 'like', '%' . $request->tieu_de . '%');
        }

        if ($request->filled('so_hieu')) {
            $query->where('so_hieu', 'like', '%' . $request->so_hieu . '%');
        }

        if ($request->filled('loai')) {
            $query->whereHas('loaiChungTu', function ($q) use ($request) {
                $q->where('ten_loai_chung_tu', 'like', '%' . $request->loai . '%');
            });
        }

        if ($request->filled('huong')) {
            $query->whereHas('huong', function ($q) use ($request) {
                $q->where('ten_huong_chung_tu', 'like', '%' . $request->huong . '%');
            });
        }

        if ($request->filled('id_trang_thai')) {
            $query->where('id_trang_thai_hien_tai', $request->id_trang_thai);
        }

        if ($request->filled('id_nguoi_tao')) {
            $query->whereHas('nguoiTao', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->id_nguoi_tao . '%')
                    ->orWhere('email', 'like', '%' . $request->id_nguoi_tao . '%');
            });
        }

        if ($request->filled('id_phong_ban')) {
            $query->whereHas('nguoiTao', function ($q) use ($request) {
                $q->where('id_phongban', $request->id_phong_ban);
            });
        }

        if ($request->filled('tu_ngay')) {
            $query->whereDate('created_at', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->whereDate('created_at', '<=', $request->den_ngay);
        }
    }


    public function create()
    {
        return view('chungtu.create', [
            'loaiChungTus' => LoaiChungTu::all(),
            'trangThaiChungTus' => TrangThaiChungTu::all(),
            'doiTacs' => DoiTac::all(),
            'huongChungTus' => HuongChungTu::all(),
        ]);
    }
    public function createDi()
    {
        return view('chungtu.create_di', [
            'loaiChungTus' => LoaiChungTu::all(),
            'doiTacs' => DoiTac::all(),
            'huongMacDinh' => HuongChungTu::where('ma_huong_chung_tu', 'DI')->first()?->id,
            'tenHuong' => HuongChungTu::where('ma_huong_chung_tu', 'DI')->first()?->ten_huong_chung_tu,
            'chungTu' => new ChungTu()
        ]);
    }

    public function createNoiBo()
    {
        return view('chungtu.create_noi_bo', [
            'loaiChungTus' => LoaiChungTu::all(),
            'doiTacs' => DoiTac::all(),
            'huongMacDinh' => HuongChungTu::where('ma_huong_chung_tu', 'like', 'NOI_BO%')->first()?->id,
            'tenHuong' => HuongChungTu::where('ma_huong_chung_tu', 'like', 'NOI_BO%')->first()?->ten_huong_chung_tu,
            'chungTu' => new ChungTu()
        ]);
    }

    public function createDen()
    {
        return view('chungtu.create_den', [
            'loaiChungTus' => LoaiChungTu::all(),
            'doiTacs' => DoiTac::all(),
            'huongMacDinh' => HuongChungTu::where('ma_huong_chung_tu', 'like', 'DEN%')->first()?->id,
            'tenHuong' => HuongChungTu::where('ma_huong_chung_tu', 'like', 'DEN%')->first()?->ten_huong_chung_tu,
            'chungTu' => new ChungTu()
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_chung_tu' => 'required|string|unique:chung_tus',
            'tieu_de' => 'required|string',
            'so_hieu' => 'nullable|string',
            'duong_dan' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            'trich_yeu' => 'nullable|string',
            'noi_ban_hanh' => 'nullable|string',
            'ngay_ban_hanh' => 'nullable|date',
            'id_nguoi_gui_doi_tac' => 'nullable|exists:doi_tacs,id',
            'ngay_hieu_luc' => 'nullable|date',
            'ngay_het_hieu_luc' => 'nullable|date',
            'ky_so' => 'nullable|boolean',
            'ghi_chu' => 'nullable|string',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'id_huong' => 'required|exists:huong_chung_tus,id',
        ]);

        $validated['id_nguoi_tao'] = auth()->id();
        $validated['id_trang_thai_hien_tai'] = 1;

        if ($request->hasFile('duong_dan')) {
            $file = $request->file('duong_dan');
            $now = now();
            $maLoai = LoaiChungTu::find($validated['id_loai_chung_tu'])->ma_loai_chung_tu;
            $path = "chungtu/{$maLoai}/{$now->year}/{$now->format('m')}";
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($path, $fileName, 'local');
            $validated['duong_dan'] = $fileName;
        }

        $chungTu = ChungTu::create($validated);

        LichSuChungTu::create([
            'id_chung_tu' => $chungTu->id,
            'id_nguoi_thay_doi' => auth()->id(),
            'id_trang_thai_moi' => $chungTu->id_trang_thai_hien_tai,
            'ghi_chu' => 'Khởi tạo chứng từ',
        ]);

        $this->guiMailNguoiXuLyTiepTheo($chungTu);

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được tạo thành công.');
    }


    public function edit($id)
    {

        $chungTu = ChungTu::with(['nguoiTao', 'trangThai'])->findOrFail($id);

        // Lấy user hiện tại
        $user = auth()->user();

        // Kiểm tra quyền: chỉ người tạo và trạng thái phù hợp mới được sửa
        $trangThaiChoPhep = ['TAO_MOI', 'TU_CHOI'];
        $maTrangThai = optional($chungTu->trangThai)->ma_trang_thai;

        if ($chungTu->id_nguoi_tao !== $user->id || !in_array($maTrangThai, $trangThaiChoPhep)) {
            return redirect()->route('chungtu.index')->with('error', 'Bạn không có quyền chỉnh sửa chứng từ này.');
        }
        $chungTu = ChungTu::findOrFail($id);

        return view('chungtu.edit', [
            'chungTu' => $chungTu,
            'loaiChungTus' => LoaiChungTu::all(),
            'doiTacs' => DoiTac::all(),
            'huongMacDinh' => $chungTu->id_huong,
            'tenHuong' => optional($chungTu->huong)->ten_huong_chung_tu ?? 'Không rõ',
            'huongChungTus' => HuongChungTu::all(),
            'doiTacs' => DoiTac::all(),
        ]);



    }



    public function show($id)
    {
        $chungTu = ChungTu::findOrFail($id);

        //ddems so lượng addax gửi chứng từ
        $daGuiSoLuong = \App\Models\NguoiNhanChungTu::where('id_chung_tu', $chungTu->id)->count();
        // Quy trình xử lý dựa vào trạng thái hiện tại và hướng
        $quyTrinhXuLy = QuyTrinhXuLyChungTu::with(['denTrangThai', 'tuTrangThai', 'huong'])
            ->where('id_tu_trang_thai', $chungTu->id_trang_thai_hien_tai)
            ->where('id_huong', $chungTu->id_huong)
            ->orderBy('thu_tu')
            ->get();

        // Lịch sử xử lý
        $lichSu = LichSuChungTu::with(['nguoiThayDoi', 'trangThaiMoi'])
            ->where('id_chung_tu', $chungTu->id)
            ->orderBy('created_at')
            ->get();

        // Người dùng hiện tại và người tạo chứng từ
        $nguoiDung = auth()->user();
        $nguoiTao = $chungTu->nguoiTao;

        // Kiểm tra người duyệt cấp phòng
        $duocDuyetCapPhong = (
            in_array($nguoiDung->vaiTro->ma_vai_tro, ['truongphong', 'pho_phong']) &&
            $nguoiDung->id_phongban === $nguoiTao->id_phongban
        );

        // 🔥 Thêm dữ liệu cho modal gửi chứng từ
        $users = \App\Models\User::all();
        $phongBans = \App\Models\PhongBan::all();
        $doiTacs = \App\Models\DoiTac::all();

        return view('chungtu.show', compact(
            'chungTu',
            'quyTrinhXuLy',
            'lichSu',
            'duocDuyetCapPhong',
            'nguoiDung',
            'nguoiTao',
            'users',
            'phongBans',
            'doiTacs',
            'daGuiSoLuong',
        ));
    }


    public function update(Request $request, $id)
    {
        $chungTu = ChungTu::findOrFail($id);

        // Trạng thái hệ thống
        $idTuChoi = TrangThaiChungTu::where('ma_trang_thai', 'TU_CHOI')->value('id');
        $idTaoMoi = TrangThaiChungTu::where('ma_trang_thai', 'TAO_MOI')->value('id');

        $validated = $request->validate([
            'ma_chung_tu' => 'required|string|max:255|unique:chung_tus,ma_chung_tu,' . $chungTu->id,
            'tieu_de' => 'required|string|max:255',
            'so_hieu' => 'nullable|string',
            'trich_yeu' => 'nullable|string',
            'noi_ban_hanh' => 'nullable|string',
            'ngay_ban_hanh' => 'nullable|date',
            'ngay_hieu_luc' => 'nullable|date',
            'ngay_het_hieu_luc' => 'nullable|date',
            'ky_so' => 'nullable',
            'ghi_chu' => 'nullable|string',
            'duong_dan' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'id_nguoi_tao' => 'nullable|exists:users,id',
            'id_nguoi_gui_doi_tac' => 'nullable|exists:doi_tacs,id',
            'id_trang_thai_hien_tai' => 'required|exists:trang_thai_chung_tus,id',
            'id_huong' => 'nullable|exists:huong_chung_tus,id',
        ]);

        $validated['ky_so'] = $request->has('ky_so');

        $trangThaiCu = $chungTu->id_trang_thai_hien_tai;

        // Nếu trạng thái là từ chối → chuyển về tạo mới
        if ($trangThaiCu == $idTuChoi) {
            $validated['id_trang_thai_hien_tai'] = $idTaoMoi;

            // Ghi lịch sử chuyển trạng thái
            LichSuChungTu::create([
                'id_chung_tu' => $chungTu->id,
                'id_trang_thai_cu' => $trangThaiCu,
                'id_trang_thai_moi' => $idTaoMoi,
                'id_nguoi_thay_doi' => auth()->id(),
                'ghi_chu' => 'Người tạo cập nhật lại chứng từ sau khi bị từ chối.',
            ]);
        }

        // Nếu có file mới
        if ($request->hasFile('duong_dan')) {
            $oldPath = "chungtu/{$chungTu->loaiChungTu->ma_loai_chung_tu}/{$chungTu->updated_at->year}/{$chungTu->updated_at->format('m')}/{$chungTu->duong_dan}";
            if ($chungTu->duong_dan && Storage::disk('local')->exists($oldPath)) {
                Storage::disk('local')->delete($oldPath);
            }


            $file = $request->file('duong_dan');
            $now = now();
            $maLoai = LoaiChungTu::find($validated['id_loai_chung_tu'])->ma_loai_chung_tu;
            $path = "chungtu/{$maLoai}/{$now->year}/{$now->format('m')}";
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($path, $fileName, 'local');
            $validated['duong_dan'] = $fileName;
        }

        $chungTu->update($validated);

        return redirect()->route('chungtu.index')->with('success', 'Cập nhật chứng từ thành công.');
    }


    public function destroy($id)
    {
        $chungTu = ChungTu::findOrFail($id);

        // Kiểm tra quyền: chỉ người tạo và trạng thái là "TẠO_MỚI" mới được xóa
        $idTaoMoi = \App\Models\TrangThaiChungTu::where('ma_trang_thai', 'TAO_MOI')->value('id');

        if (
            $chungTu->id_nguoi_tao !== auth()->id() ||
            $chungTu->id_trang_thai_hien_tai !== $idTaoMoi
        ) {
            return redirect()->route('chungtu.index')->with('error', 'Bạn không có quyền xóa chứng từ này.');
        }

        // Xóa file nếu có
        if ($chungTu->duong_dan) {
            $maLoai = $chungTu->loaiChungTu->ma_loai_chung_tu ?? 'khac';
            $updated = $chungTu->updated_at ?? now();
            $filePath = "chungtu/{$maLoai}/{$updated->format('Y')}/{$updated->format('m')}/{$chungTu->duong_dan}";

            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
        }

        $chungTu->delete();

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ đã được xóa thành công.');
    }


    public function viewFile($id)
    {
        $chungTu = ChungTu::with('loaiChungTu')->findOrFail($id);
        $maLoai = $chungTu->loaiChungTu->ma_loai_chung_tu ?? 'khac';
        $updated = $chungTu->updated_at ?? now();
        $filePath = "chungtu/{$maLoai}/{$updated->format('Y')}/{$updated->format('m')}/{$chungTu->duong_dan}";

        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'Không tìm thấy file');
        }

        return response()->file(Storage::disk('local')->path($filePath), [
            'Content-Type' => Storage::disk('local')->mimeType($filePath),
            'Content-Disposition' => 'inline; filename="' . $chungTu->duong_dan . '"',
        ]);
    }




    public function xuLyChungTu(Request $request, ChungTu $chungTu)
    {
        $user = auth()->user();
        $idTrangThaiHienTai = $chungTu->id_trang_thai_hien_tai;
        $idHuong = $chungTu->id_huong;
        $trangThaiHienTai = $chungTu->trangThai->ma_trang_thai ?? null;
        $phongBanNguoiTao = $chungTu->nguoiTao->id_phongban ?? null;
        $phongBanNguoiDung = $user->id_phongban ?? null;


        $nguoiNhansQuery = User::query();

        if ($request->has('tu_choi')) {
            if (!$user->coQuyen('tu_choi_chung_tu')) {
                return back()->with('error', 'Bạn không có quyền từ chối chứng từ.');
            }

            if (!in_array($trangThaiHienTai, ['TAO_MOI', 'DA_DUYET_CAP_PHONG'])) {
                return back()->with('error', 'Chỉ từ chối ở trạng thái Tạo mới hoặc Duyệt cấp phòng.');
            }

            $idTuChoi = TrangThaiChungTu::where('ma_trang_thai', 'TU_CHOI')->value('id');
            $chungTu->update(['id_trang_thai_hien_tai' => $idTuChoi]);

            LichSuChungTu::create([
                'id_chung_tu' => $chungTu->id,
                'id_nguoi_thay_doi' => $user->id,
                'id_trang_thai_moi' => $idTuChoi,
                'ghi_chu' => $request->input('ghi_chu') ?? 'Người xử lý đã từ chối chứng từ.',
            ]);

            // 🔥 Gửi email thông báo từ chối
            $this->guiMailThongBaoTuChoi($chungTu);

            return back()->with('error', 'Chứng từ đã bị từ chối.');
        }

        if ($request->has('thu_tu')) {
            $thuTu = $request->input('thu_tu');

            $nextXuLy = QuyTrinhXuLyChungTu::where('id_tu_trang_thai', $idTrangThaiHienTai)
                ->where('id_huong', $idHuong)
                ->where('thu_tu', $thuTu)
                ->first();

            if (!$nextXuLy) {
                return back()->with('error', 'Không tìm thấy bước xử lý tiếp theo.');
            }

            $trangThaiKeTiep = optional($nextXuLy->trangThaiDen)->ma_trang_thai ?? null;

            switch ($trangThaiKeTiep) {
                case 'DA_DUYET_CAP_PHONG':
                    if (!$user->coQuyen('duyet_cap_phong') || $phongBanNguoiTao !== $phongBanNguoiDung) {
                        return back()->with('error', 'Bạn không có quyền duyệt cấp phòng hoặc không cùng phòng ban.');
                    }
                    break;
                case 'DA_DUYET':
                    if (!$user->coQuyen('duyet_lanh_dao') || $trangThaiHienTai !== 'DA_DUYET_CAP_PHONG') {
                        return back()->with('error', 'Chỉ được duyệt lãnh đạo sau khi đã duyệt cấp phòng.');
                    }
                    break;
                case 'KY_SO':
                    if (!$user->coQuyen('ky_so')) {
                        return back()->with('error', 'Bạn không có quyền ký số.');
                    }
                    break;
                case 'DA_GUI':
                    if (!in_array($trangThaiKeTiep, ['DA_GUI', 'DA_BAN_HANH'])) {
                        return back()->with('error', 'Trạng thái kế tiếp không cho phép gửi chứng từ.');
                    }

                    if (!$user->coQuyen('gui_chung_tu') && $user->id !== $chungTu->id_nguoi_tao) {
                        return back()->with('error', 'Bạn không có quyền gửi chứng từ này.');
                    }

                    break;


                case 'DA_BAN_HANH':
                    if (!in_array($trangThaiKeTiep, ['DA_GUI', 'DA_BAN_HANH'])) {
                        return back()->with('error', 'Trạng thái kế tiếp không cho phép gửi chứng từ.');
                    }

                    if (!$user->coQuyen('gui_chung_tu') && $user->id !== $chungTu->id_nguoi_tao) {
                        return back()->with('error', 'Bạn không có quyền gửi chứng từ này.');
                    }

                    break;
            }

            $chungTu->update([
                'id_trang_thai_hien_tai' => $nextXuLy->id_den_trang_thai,
            ]);

            LichSuChungTu::create([
                'id_chung_tu' => $chungTu->id,
                'id_nguoi_thay_doi' => $user->id,
                'id_trang_thai_moi' => $nextXuLy->id_den_trang_thai,
                'ghi_chu' => $request->input('ghi_chu') ?? "Đã thực hiện bước: {$nextXuLy->mo_ta}",
            ]);
            $this->guiMailNguoiXuLyTiepTheo($chungTu);
            // 🔥 Gửi email cho người xử lý bước kế tiếp

            return back()->with('success', "✅ Đã chuyển bước: {$nextXuLy->mo_ta}");
        }

        return back()->with('error', 'Không có hành động nào được chọn.');
    }


    protected function guiMailNguoiXuLyTiepTheo(ChungTu $chungTu)
    {
        try {
            // Load lại quan hệ để chắc chắn có nguoiTao và trangThai
            $chungTu->load(['nguoiTao', 'trangThai']);

            $trangThaiKeTiep = $chungTu->trangThai->ma_trang_thai ?? null;
            $nguoiNhansQuery = User::query();

            switch ($trangThaiKeTiep) {
                case 'TAO_MOI':
                    // Gửi cho trưởng phòng/phó phòng phòng ban người tạo
                    $idPhongBanNguoiTao = $chungTu->nguoiTao->id_phongban ?? null;
                    if ($idPhongBanNguoiTao) {
                        $nguoiNhansQuery->whereHas('vaiTro', function ($q) {
                            $q->whereIn('ma_vai_tro', ['truongphong', 'pho_phong']);
                        })->where('id_phongban', $idPhongBanNguoiTao);
                    } else {
                        \Log::warning('Không xác định được phòng ban người tạo chứng từ.');
                    }
                    break;

                case 'DA_DUYET_CAP_PHONG':
                    // Gửi cho giám đốc/phó giám đốc
                    $nguoiNhansQuery->whereHas('vaiTro', function ($q) {
                        $q->whereIn('ma_vai_tro', ['giamdoc', 'pho_giamdoc']);
                    });
                    break;

                case 'DA_DUYET':
                    // Gửi cho người có quyền ký số
                    $nguoiNhansQuery->whereHas('vaiTro', function ($q) {
                        $q->where('ma_vai_tro', 'giamdoc');
                    })->whereHas('quyenHan', function ($q) {
                        $q->where('ma_quyen', 'ky_so');
                    });
                    break;


                case "DA_BAN_HANH":
                    // Gửi cho người có quyền ban hành chứng từ
                    $nguoiNhansQuery->whereHas('quyenHan', function ($q) {
                        $q->where('ma_quyen', 'ban_hanh_chung_tu');
                    });
                    break;

                case 'KY_SO':
                    // Gửi cho người có quyền gửi chứng từ
                    $nguoiNhansQuery->whereHas('quyenHan', function ($q) {
                        $q->where('ma_quyen', 'gui_chung_tu');
                    });
                    break;

                case 'DA_GUI':
                    // Gửi cho người có quyền lưu trữ
                    $nguoiNhansQuery->whereHas('quyenHan', function ($q) {
                        $q->where('ma_quyen', 'luu_tru_chung_tu');
                    });
                    break;

                default:
                    \Log::info("Không xác định người nhận cho trạng thái kế tiếp: $trangThaiKeTiep");
                    return; // Không gửi mail nếu trạng thái không đúng
            }

            $nguoiNhans = $nguoiNhansQuery->get();

            if ($nguoiNhans->isEmpty()) {
                \Log::warning("Không tìm thấy người nhận phù hợp cho trạng thái: $trangThaiKeTiep");
            } else {

                // $emails = [];

                // foreach ($nguoiNhans as $nguoiNhan) {
                //     if ($nguoiNhan->email) {
                //         $emails[] = $nguoiNhan->email;
                //     }
                // }

                // // Hiển thị danh sách email và dừng chương trình
                // dd($emails);

                foreach ($nguoiNhans as $nguoiNhan) {
                    if ($nguoiNhan->email) {
                        \Mail::to($nguoiNhan->email)->send(new \App\Mail\ThongBaoXuLyChungTu($chungTu, $nguoiNhan));
                    }
                }
            }

        } catch (\Exception $e) {
            \Log::error('Lỗi gửi mail chứng từ: ' . $e->getMessage());
        }
    }




    protected function guiMailThongBaoTuChoi(ChungTu $chungTu)
    {
        try {
            $nguoiTuChoi = auth()->user();
            $nguoiTao = $chungTu->nguoiTao;
            $emails = [];

            if (in_array($nguoiTuChoi->vaiTro->ma_vai_tro, ['truongphong', 'pho_phong'])) {
                // Trưởng phòng từ chối: gửi cho người tạo
                $emails[] = $nguoiTao->email;
            } elseif (in_array($nguoiTuChoi->vaiTro->ma_vai_tro, ['giamdoc', 'pho_giamdoc'])) {
                // Giám đốc từ chối: gửi cho người tạo + trưởng phòng
                $emails[] = $nguoiTao->email;

                $quanLyPhong = User::where('id_phongban', $nguoiTao->id_phongban)
                    ->whereHas('vaiTro', function ($q) {
                        $q->whereIn('ma_vai_tro', ['truongphong', 'pho_phong']);
                    })->pluck('email')->toArray();

                $emails = array_merge($emails, $quanLyPhong);
            }

            foreach (array_unique($emails) as $email) {
                if ($email) {
                    Mail::to($email)->send(new \App\Mail\ThongBaoXuLyChungTu($chungTu, 'bi_tu_choi', $nguoiTuChoi));
                }
            }

        } catch (\Exception $e) {
            \Log::error('Lỗi gửi mail từ chối chứng từ: ' . $e->getMessage());
        }
    }





    public function downloadSigned(ChungTu $chungTu)
    {
        // $filePath = $chungTu->duong_dan; // Ví dụ: 'chungtu/HCNS_CV/2025/04/file.pdf'
        
        $maLoai = $chungTu->loaiChungTu->ma_loai_chung_tu ?? 'khac';
        $updated = $chungTu->updated_at ?? now();
        $filePath = "chungtu/{$maLoai}/{$updated->format('Y')}/{$updated->format('m')}/{$chungTu->duong_dan}";
        if (!$filePath || !Storage::exists($filePath)) {
            abort(404, '❌ File không tồn tại.');
        }

        return Storage::download($filePath, basename($filePath)); // Tự động mở tải
    }

























}

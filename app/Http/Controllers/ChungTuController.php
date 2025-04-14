<?php

namespace App\Http\Controllers;

use App\Models\{ChungTu, LoaiChungTu, TrangThaiChungTu, DoiTac, HuongChungTu, LichSuChungTu, QuyTrinhXuLyChungTu};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Auth};
use Illuminate\Support\Str;

class ChungTuController extends Controller
{
    public function index()
    {
        $chungTus = ChungTu::with(['loaiChungTu', 'nguoiTao.phongBan', 'nguoiGuiDoiTac', 'trangThai', 'huong'])->get();
        return view('chungtu.index', compact('chungTus'));
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

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được tạo thành công.');
    }

    public function show($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        $quyTrinhXuLy = QuyTrinhXuLyChungTu::where('id_tu_trang_thai', $chungTu->id_trang_thai_hien_tai)
            ->where('id_huong', $chungTu->id_huong)
            ->orderBy('thu_tu')->get();

        $lichSu = LichSuChungTu::with('nguoiThayDoi', 'trangThaiMoi')
            ->where('id_chung_tu', $chungTu->id)->orderBy('created_at')->get();

        $nguoiDung = auth()->user();
        $nguoiTao = $chungTu->nguoiTao;

        $duocDuyetCapPhong = (
            in_array($nguoiDung->vaiTro->ma_vai_tro, ['truongphong', 'pho_phong']) &&
            $nguoiDung->id_phongban === $nguoiTao->id_phongban
        );

        return view('chungtu.show', compact('chungTu', 'quyTrinhXuLy', 'lichSu', 'duocDuyetCapPhong'));
    }

    public function update(Request $request, $id)
    {
        $chungTu = ChungTu::findOrFail($id);

        $validated = $request->validate([
            'ma_chung_tu' => 'required|string|max:255|unique:chung_tus,ma_chung_tu,' . $chungTu->id,
            'tieu_de' => 'required|string|max:255',
            'so_hieu' => 'nullable|string',
            'trich_yeu' => 'nullable|string',
            'noi_ban_hanh' => 'nullable|string',
            'ngay_ban_hanh' => 'nullable|date',
            'ngay_hieu_luc' => 'nullable|date',
            'ngay_het_hieu_luc' => 'nullable|date',
            'ky_so' => 'nullable|boolean',
            'ghi_chu' => 'nullable|string',
            'duong_dan' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'id_nguoi_tao' => 'nullable|exists:users,id',
            'id_nguoi_gui_doi_tac' => 'nullable|exists:doi_tacs,id',
            'id_trang_thai_hien_tai' => 'required|exists:trang_thai_chung_tus,id',
            'id_huong' => 'nullable|exists:huong_chung_tus,id',
        ]);

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
        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $chungTu = ChungTu::findOrFail($id);

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
    
        // ===== TỪ CHỐI =====
        if ($request->has('tu_choi')) {
            if (!$user->coQuyen('tu_choi_chung_tu')) {
                return back()->with('error', 'Bạn không có quyền từ chối chứng từ.');
            }
    
            if (!in_array($trangThaiHienTai, ['TAO_MOI', 'DA_DUYET_CAP_PHONG'])) {
                return back()->with('error', 'Chỉ có thể từ chối khi ở trạng thái Tạo mới hoặc Duyệt cấp phòng.');
            }
    
            $idTuChoi = TrangThaiChungTu::where('ma_trang_thai', 'TU_CHOI')->value('id');
    
            $chungTu->update(['id_trang_thai_hien_tai' => $idTuChoi]);
    
            LichSuChungTu::create([
                'id_chung_tu' => $chungTu->id,
                'id_nguoi_thay_doi' => $user->id,
                'id_trang_thai_moi' => $idTuChoi,
                'ghi_chu' => $request->input('ghi_chu') ?? 'Người xử lý đã từ chối chứng từ.',
            ]);
    
            return back()->with('error', 'Chứng từ đã bị từ chối.');
        }
    
        // ===== DUYỆT =====
        if ($request->has('thu_tu')) {
            $thuTu = $request->input('thu_tu');
    
            $nextXuLy = QuyTrinhXuLyChungTu::where('id_tu_trang_thai', $idTrangThaiHienTai)
                ->where('id_huong', $idHuong)
                ->where('thu_tu', $thuTu)
                ->first();
    
            if (!$nextXuLy) {
                return back()->with('error', 'Không tìm thấy bước xử lý tương ứng.');
            }
    
            $trangThaiKeTiep = optional($nextXuLy->trangThaiDen)->ma_trang_thai ?? null;
            $phongBanNguoiTao = $chungTu->nguoiTao->id_phongban ?? null;
            $phongBanNguoiDung = $user->id_phongban ?? null;
    
            if ($trangThaiKeTiep === 'DA_DUYET_CAP_PHONG') {
                if (!$user->coQuyen('duyet_cap_phong') || $phongBanNguoiTao !== $phongBanNguoiDung) {
                    return back()->with('error', 'Bạn không có quyền duyệt cấp phòng cho chứng từ này.');
                }
            }
    
            if ($trangThaiKeTiep === 'DA_DUYET') {
                if (!$user->coQuyen('duyet_lanh_dao')) {
                    return back()->with('error', 'Bạn không có quyền duyệt cấp lãnh đạo.');
                }
                if ($trangThaiHienTai !== 'DA_DUYET_CAP_PHONG') {
                    return back()->with('error', 'Phải duyệt cấp phòng trước khi lên lãnh đạo.');
                }
            }
    
            // Cập nhật trạng thái mới
            $chungTu->update(['id_trang_thai_hien_tai' => $nextXuLy->id_den_trang_thai]);
    
            LichSuChungTu::create([
                'id_chung_tu' => $chungTu->id,
                'id_nguoi_thay_doi' => $user->id,
                'id_trang_thai_moi' => $nextXuLy->id_den_trang_thai,
                'ghi_chu' => $request->input('ghi_chu') ?? "Đã thực hiện bước: {$nextXuLy->mo_ta}",
            ]);
    
            return back()->with('success', "Đã chuyển bước: {$nextXuLy->mo_ta}");
        }
    
        return back()->with('error', 'Không có hành động được chọn.');
    }
    
    

}

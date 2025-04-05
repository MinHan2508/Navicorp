<?php

namespace App\Http\Controllers;

use App\Models\ChungTu;
use App\Models\LoaiChungTu;
use App\Models\TrangThaiChungTu;
use App\Models\DoiTac;
use App\Models\HuongChungTu;
use App\Models\LichSuChungTu;
use App\Models\QuyTrinhXuLyChungTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChungTuController extends Controller
{
    public function index()
    {
        $chungTus = ChungTu::with([
            'loaiChungTu',
            'nguoiTao.phongBan',   //  load phòng ban theo cột id_phongban
            'nguoiGuiDoiTac',
            'trangThai',
            'huong'
        ])->get();
    
       
        return view('chungtu.index', compact('chungTus'));
    }

    public function create()
    {
        
        $loaiChungTus = LoaiChungTu::all();
        $trangThaiChungTus = TrangThaiChungTu::all();
        $doiTacs = DoiTac::all();
        $huongChungTus = HuongChungTu::all();

        return view('chungtu.create', compact('loaiChungTus', 'trangThaiChungTus', 'doiTacs', 'huongChungTus'));
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
        $validated['id_trang_thai_hien_tai'] = 1; // Trạng thái khởi tạo
        // $validated['id_nguoi_gui_doi_tac'] = 1; 

        if ($request->hasFile('duong_dan')) {
            $file = $request->file('duong_dan');
            $now = now();
            $maLoai = LoaiChungTu::find($validated['id_loai_chung_tu'])->ma_loai_chung_tu;
            $path = "chungtu/{$maLoai}/{$now->year}/{$now->format('m')}";
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($path, $fileName, 'local');
            $validated['duong_dan'] = $fileName;
        }



        // dd($validated);
        // ChungTu::create($validated);

        $chungTu = ChungTu::create($validated); // Gán vào biến $chungTu

        \App\Models\LichSuChungTu::create([
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
        ->orderBy('thu_tu')
        ->get();


        $lichSu = \App\Models\LichSuChungTu::with('nguoiThayDoi', 'trangThaiMoi')
        ->where('id_chung_tu', $chungTu->id)
        ->orderBy('created_at', 'asc')
        ->get();

         return view('chungtu.show', compact('chungTu', 'quyTrinhXuLy', 'lichSu'));



    }

    public function edit($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        $loaiChungTus = LoaiChungTu::all();
        $trangThaiChungTus = TrangThaiChungTu::all();
        $doiTacs = DoiTac::all();
        $huongChungTus = HuongChungTu::all();

        return view('chungtu.edit', compact('chungTu', 'loaiChungTus', 'trangThaiChungTus', 'doiTacs', 'huongChungTus'));
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
        } else {
            $validated['duong_dan'] = $chungTu->duong_dan;
        }

        $chungTu->update($validated);

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được cập nhật thành công.');
    }




    public function viewFile($id)
    {
        $chungTu = ChungTu::with('loaiChungTu')->findOrFail($id);

        $maLoai = $chungTu->loaiChungTu->ma_loai_chung_tu ?? 'khac';
        $updated = $chungTu->updated_at ?? now();
        $year = $updated->format('Y');
        $month = $updated->format('m');

        $filePath = "chungtu/{$maLoai}/{$year}/{$month}/{$chungTu->duong_dan}";

        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'Không tìm thấy file');
        }

        return response()->file(Storage::disk('local')->path($filePath), [
            'Content-Type' => Storage::disk('local')->mimeType($filePath),
            'Content-Disposition' => 'inline; filename="' . $chungTu->duong_dan . '"',
        ]);
    }

    public function destroy($id)
    {
        $chungTu = ChungTu::findOrFail($id);

        if ($chungTu->duong_dan) {
            $maLoai = $chungTu->loaiChungTu->ma_loai_chung_tu ?? 'khac';
            $updated = $chungTu->updated_at ?? now();
            $year = $updated->format('Y');
            $month = $updated->format('m');

            $filePath = "chungtu/{$maLoai}/{$year}/{$month}/{$chungTu->duong_dan}";
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
        }

        $chungTu->delete();

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ đã được xóa thành công.');
    }




    // XỬ LÝ CHỨNG TỪ
    public function xuLyChungTu(Request $request, ChungTu $chungTu)
{
    $idTrangThaiHienTai = $chungTu->id_trang_thai_hien_tai;
    $idHuong = $chungTu->id_huong;

    // Xử lý từ chối
    if ($request->has('tu_choi')) {
        $duocTuChoi = in_array($idTrangThaiHienTai, [1, 2]) || (
            $chungTu->trangThai &&
            in_array($chungTu->trangThai->ma_trang_thai, ['DUYET_CAP_PHONG', 'TAO_MOI'])
        );

        if (!$duocTuChoi) {
            return redirect()->back()->with('error', 'Chỉ có thể từ chối khi chứng từ ở trạng thái tạo mới hoặc duyệt cấp phòng.');
        }

        $chungTu->update([
            'id_trang_thai_hien_tai' => 99,
        ]);

        LichSuChungTu::create([
            'id_chung_tu' => $chungTu->id,
            'id_nguoi_thay_doi' => auth()->id(),
            'id_trang_thai_moi' => 99,
            'ghi_chu' => $request->input('ghi_chu') ?? 'Người xử lý đã từ chối chứng từ.',
        ]);

        return redirect()->back()->with('error', 'Chứng từ đã bị từ chối.');
    }

    // Xử lý duyệt theo thu_tu
    if ($request->has('thu_tu')) {
        $thuTu = $request->input('thu_tu');

        $nextXuLy = QuyTrinhXuLyChungTu::where('id_tu_trang_thai', $idTrangThaiHienTai)
            ->where('id_huong', $idHuong)
            ->where('thu_tu', $thuTu)
            ->first();

        if (!$nextXuLy) {
            return redirect()->back()->with('error', 'Không tìm thấy bước xử lý tương ứng.');
        }

        $chungTu->update([
            'id_trang_thai_hien_tai' => $nextXuLy->id_den_trang_thai,
        ]);

        LichSuChungTu::create([
            'id_chung_tu' => $chungTu->id,
            'id_nguoi_thay_doi' => auth()->id(),
            'id_trang_thai_moi' => $nextXuLy->id_den_trang_thai,
            'ghi_chu' => $request->input('ghi_chu') ?? "Đã thực hiện bước: {$nextXuLy->mo_ta}",
        ]);

        return redirect()->back()->with('success', "Đã chuyển bước: {$nextXuLy->mo_ta}");
    }

    return redirect()->back()->with('error', 'Không có hành động được chọn.');
}
   
    
    


    //END XỬ LÝ CHỨNG TỪ






}

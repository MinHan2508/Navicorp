<?php

namespace App\Http\Controllers;

use App\Models\ChungTu;
use App\Models\LoaiChungTu;
use App\Models\TrangThaiChungTu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChungTuController extends Controller
{
    public function index()
    {
        $chungTus = ChungTu::with(['loaiChungTu', 'nguoiTao', 'nguoiGuiDoiTac', 'trangThai'])->get();
        return view('chungtu.index', compact('chungTus'));
    }

    public function create()
    {
        $loaiChungTus = LoaiChungTu::all();
        $trangThaiChungTus = TrangThaiChungTu::all();

        return view('chungtu.create', compact('loaiChungTus', 'trangThaiChungTus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ma_chung_tu' => 'required|string|max:255|unique:chung_tus',
            'tieu_de' => 'required|string|max:255',
            'duong_dan' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            'ghi_chu' => 'nullable|string',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'nguoi_tao_id' => 'nullable|exists:users,id',
            'nguoi_gui_doi_tac_id' => 'nullable|exists:doi_tacs,id',
            'trang_thai_id' => 'required|exists:trang_thai_chung_tus,id',
        ]);

        if ($request->hasFile('duong_dan')) {
            $file = $request->file('duong_dan');
            $now = now();
            $path = LoaiChungTu::find($validatedData['id_loai_chung_tu'])->ma_loai_chung_tu . '/' . $now->year . '/' . $now->format('m');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs($path, $fileName, 'local');
            $validatedData['duong_dan'] = $fileName;
        }

        ChungTu::create($validatedData);

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được tạo thành công.');
    }

    public function show($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        return view('chungtu.show', compact('chungTu'));
    }

    public function edit($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        $loaiChungTus = LoaiChungTu::all();
        $trangThaiChungTus = TrangThaiChungTu::all();

        return view('chungtu.edit', compact('chungTu', 'loaiChungTus', 'trangThaiChungTus'));
    }

    public function update(Request $request, $id)
    {
        $chungTu = ChungTu::findOrFail($id);

        $validatedData = $request->validate([
            'ma_chung_tu' => 'required|string|max:255|unique:chung_tus,ma_chung_tu,' . $chungTu->id,
            'tieu_de' => 'required|string|max:255',
            'duong_dan' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            'ghi_chu' => 'nullable|string',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'nguoi_tao_id' => 'nullable|exists:users,id',
            'nguoi_gui_doi_tac_id' => 'nullable|exists:doi_tacs,id',
            'trang_thai_id' => 'required|exists:trang_thai_chung_tus,id',
        ]);

        if ($request->hasFile('duong_dan')) {
            if ($chungTu->duong_dan && Storage::disk('local')->exists($chungTu->duong_dan)) {
                Storage::disk('local')->delete($chungTu->duong_dan);
            }

            $file = $request->file('duong_dan');
            $now = now();
            $path = LoaiChungTu::find($validatedData['id_loai_chung_tu'])->ma_loai_chung_tu . '/' . $now->year . '/' . $now->format('m');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs($path, $fileName, 'local');
            $validatedData['duong_dan'] = $fileName;
        } else {
            $validatedData['duong_dan'] = $chungTu->duong_dan;
        }

        $chungTu->update($validatedData);

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được cập nhật thành công.');
    }


    // App\Http\Controllers\ChungTuController.php
        ///xem file trục tiếp
     

        public function viewFile($id)
        {
            $chungTu = ChungTu::with('loaiChungTu')->findOrFail($id);

            $maLoai = $chungTu->loaiChungTu->ma_loai_chung_tu ?? 'khac';
            $updated = $chungTu->updated_at ?? now();
            $year = $updated->format('Y');
            $month = $updated->format('m');

            $filePath = "{$maLoai}/{$year}/{$month}/{$chungTu->duong_dan}";

            if (!Storage::disk('local')->exists($filePath)) {
                abort(404, 'Không tìm thấy file');
            }

            $mimeType = Storage::disk('local')->mimeType($filePath);
            $realPath = Storage::disk('local')->path($filePath);

            return response()->file($realPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $chungTu->duong_dan . '"'
            ]);
        }








    public function destroy($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        $chungTu->delete();

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ đã được xóa thành công.');
    }
}

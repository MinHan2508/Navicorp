<?php

namespace App\Http\Controllers;

use App\Models\LichSuChungTu;
use Illuminate\Http\Request;

class LichSuChungTuController extends Controller
{
    public function index()
    {
        $lichSuChungTus = LichSuChungTu::with('nguoiThayDoi', 'chungTu')->get();
        return view('lichsuchungtu.index', compact('lichSuChungTus'));
    }

    public function create()
    {
        return view('lichsuchungtu.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_chung_tu' => 'required|exists:chung_tus,id',
            'id_nguoi_thay_doi' => 'required|exists:users,id',
            'id_trang_thai_moi' => 'required|exists:trang_thai_chung_tus,id',
            'ghi_chu' => 'nullable|string',
        ]);

        LichSuChungTu::create($validatedData);

        return redirect()->route('lichsuchungtu.index')->with('success', 'Lịch sử chứng từ được tạo thành công.');
    }

    public function show(LichSuChungTu $lichSuChungTu)
    {
        return view('lichsuchungtu.show', compact('lichSuChungTu'));
    }

    public function edit(LichSuChungTu $lichSuChungTu)
    {
        return view('lichsuchungtu.edit', compact('lichSuChungTu'));
    }

    public function update(Request $request, LichSuChungTu $lichSuChungTu)
    {
        $validatedData = $request->validate([
            'id_chung_tu' => 'required|exists:chung_tus,id',
            'id_nguoi_thay_doi' => 'required|exists:users,id',
            'id_trang_thai_moi' => 'required|exists:trang_thai_chung_tus,id',
            'ghi_chu' => 'nullable|string',
        ]);

        $lichSuChungTu->update($validatedData);

        return redirect()->route('lichsuchungtu.index')->with('success', 'Lịch sử chứng từ được cập nhật thành công.');
    }

    public function destroy(LichSuChungTu $lichSuChungTu)
    {
        $lichSuChungTu->delete();

        return redirect()->route('lichsuchungtu.index')->with('success', 'Lịch sử chứng từ đã được xóa.');
    }
}

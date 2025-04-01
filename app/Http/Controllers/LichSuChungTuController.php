<?php

namespace App\Http\Controllers;

use App\Models\LichSuChungTu;
use Illuminate\Http\Request;

class LichSuChungTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách lịch sử chứng từ
        $lichSuChungTus = LichSuChungTu::with('nguoiThayDoi', 'chungTu')->get();
        return view('lichsuchungtu.index', compact('lichSuChungTus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo mới lịch sử chứng từ
        return view('lichsuchungtu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'chung_tu_id' => 'required|exists:chung_tus,id',
            'nguoi_thay_doi_id' => 'required|exists:users,id',
            'trang_thai_moi_id' => 'required|exists:trang_thais,id',
            'ghi_chu' => 'nullable|string',
        ]);

        // Tạo mới lịch sử chứng từ
        LichSuChungTu::create($validatedData);

        return redirect()->route('lichsuchungtu.index')->with('success', 'Lịch sử chứng từ được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LichSuChungTu  $lichSuChungTu
     * @return \Illuminate\Http\Response
     */
    public function show(LichSuChungTu $lichSuChungTu)
    {
        // Hiển thị chi tiết lịch sử chứng từ
        return view('lichsuchungtu.show', compact('lichSuChungTu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LichSuChungTu  $lichSuChungTu
     * @return \Illuminate\Http\Response
     */
    public function edit(LichSuChungTu $lichSuChungTu)
    {
        // Hiển thị form chỉnh sửa lịch sử chứng từ
        return view('lichsuchungtu.edit', compact('lichSuChungTu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LichSuChungTu  $lichSuChungTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LichSuChungTu $lichSuChungTu)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'chung_tu_id' => 'required|exists:chung_tus,id',
            'nguoi_thay_doi_id' => 'required|exists:users,id',
            'trang_thai_moi_id' => 'required|exists:trang_thais,id',
            'ghi_chu' => 'nullable|string',
        ]);

        // Cập nhật lịch sử chứng từ
        $lichSuChungTu->update($validatedData);

        return redirect()->route('lichsuchungtu.index')->with('success', 'Lịch sử chứng từ được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LichSuChungTu  $lichSuChungTu
     * @return \Illuminate\Http\Response
     */
    public function destroy(LichSuChungTu $lichSuChungTu)
    {
        // Xóa lịch sử chứng từ
        $lichSuChungTu->delete();

        return redirect()->route('lichsuchungtu.index')->with('success', 'Lịch sử chứng từ đã được xóa.');
    }
}

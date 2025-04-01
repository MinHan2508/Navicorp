<?php

namespace App\Http\Controllers;

use App\Models\LoaiChungTu;
use Illuminate\Http\Request;

class LoaiChungTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách loại chứng từ, sắp xếp theo ngày tạo mới nhất
        $loaichungtus = LoaiChungTu::orderBy('created_at', 'desc')->get();
        return view('loaichungtu.index', compact('loaichungtus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo mới loại chứng từ
        return view('loaichungtu.create');
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
        $request->validate([
            'ma_loai_chung_tu' => 'required|string|max:50|unique:loai_chung_tus',
            'ten_loai_chung_tu' => 'required|string|max:100',
            'ghi_chu' => 'nullable|string',
        ]);

        // Tạo mới loại chứng từ
        LoaiChungTu::create($request->all());

        return redirect()->route('loaichungtu.index')->with('success', 'Loại chứng từ được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy thông tin chi tiết loại chứng từ
        $loaichungtu = LoaiChungTu::findOrFail($id);
        return view('loaichungtu.show', compact('loaichungtu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Hiển thị form chỉnh sửa loại chứng từ
        $loaichungtu = LoaiChungTu::findOrFail($id);
        return view('loaichungtu.edit', compact('loaichungtu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'ma_loai_chung_tu' => 'required|string|max:50|unique:loai_chung_tus,ma_loai_chung_tu,' . $id,
            'ten_loai_chung_tu' => 'required|string|max:100',
            'ghi_chu' => 'nullable|string',
        ]);

        // Cập nhật thông tin loại chứng từ
        $loaichungtu = LoaiChungTu::findOrFail($id);
        $loaichungtu->update($request->all());

        return redirect()->route('loaichungtu.index')->with('success', 'Loại chứng từ được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Xóa loại chứng từ
        $loaichungtu = LoaiChungTu::findOrFail($id);
        $loaichungtu->delete();

        return redirect()->route('loaichungtu.index')->with('success', 'Loại chứng từ đã được xóa.');
    }
}
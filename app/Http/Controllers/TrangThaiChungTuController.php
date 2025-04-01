<?php

namespace App\Http\Controllers;

use App\Models\TrangThaiChungTu;
use Illuminate\Http\Request;

class TrangThaiChungTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách trạng thái chứng từ, sắp xếp theo ngày tạo mới nhất
        $trangThaiChungTus = TrangThaiChungTu::orderBy('created_at', 'desc')->get();
        return view('trangthaichungtu.index', compact('trangThaiChungTus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo mới trạng thái chứng từ
        return view('trangthaichungtu.create');
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
            'ma_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus',
            'ten_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus',
            'ghi_chu' => 'nullable|string',
        ]);

        // Tạo mới trạng thái chứng từ
        TrangThaiChungTu::create($request->all());

        return redirect()->route('trangthaichungtu.index')->with('success', 'Trạng thái chứng từ được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy thông tin chi tiết trạng thái chứng từ
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        return view('trangthaichungtu.show', compact('trangThaiChungTu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Hiển thị form chỉnh sửa trạng thái chứng từ
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        return view('trangthaichungtu.edit', compact('trangThaiChungTu'));
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
            'ma_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus,ma_trang_thai,' . $id,
            'ten_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus,ten_trang_thai,' . $id,
            'ghi_chu' => 'nullable|string',
        ]);

        // Cập nhật thông tin trạng thái chứng từ
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        $trangThaiChungTu->update($request->all());

        return redirect()->route('trangthaichungtu.index')->with('success', 'Trạng thái chứng từ được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Xóa trạng thái chứng từ
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        $trangThaiChungTu->delete();

        return redirect()->route('trangthaichungtu.index')->with('success', 'Trạng thái chứng từ đã được xóa.');
    }
}
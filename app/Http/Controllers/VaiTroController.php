<?php

namespace App\Http\Controllers;

use App\Models\VaiTro;
use Illuminate\Http\Request;

class VaiTroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách vai trò, sắp xếp theo ngày tạo mới nhất
        $vaiTros = VaiTro::orderBy('created_at', 'desc')->get();
        return view('vaitro.index', compact('vaiTros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo mới vai trò
        return view('vaitro.create');
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
            'ma_vai_tro' => 'required|string|max:50|unique:vai_tros',
            'ten_vai_tro' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string',
        ]);

        // Tạo mới vai trò
        VaiTro::create($request->all());

        return redirect()->route('vaitro.index')->with('success', 'Vai trò được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy thông tin chi tiết vai trò
        $vaiTro = VaiTro::findOrFail($id);
        return view('vaitro.show', compact('vaiTro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Hiển thị form chỉnh sửa vai trò
        $vaiTro = VaiTro::findOrFail($id);
        return view('vaitro.edit', compact('vaiTro'));
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
            'ma_vai_tro' => 'required|string|max:50|unique:vai_tros,ma_vai_tro,' . $id,
            'ten_vai_tro' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string',
        ]);

        // Cập nhật thông tin vai trò
        $vaiTro = VaiTro::findOrFail($id);
        $vaiTro->update($request->all());

        return redirect()->route('vaitro.index')->with('success', 'Vai trò được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Xóa vai trò
        $vaiTro = VaiTro::findOrFail($id);
        $vaiTro->delete();

        return redirect()->route('vaitro.index')->with('success', 'Vai trò đã được xóa.');
    }
}


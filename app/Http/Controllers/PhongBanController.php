<?php

namespace App\Http\Controllers;

use App\Models\PhongBan;
use Illuminate\Http\Request;

class PhongBanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách phòng ban, sắp xếp theo ngày tạo mới nhất
        $phongbans = PhongBan::orderBy('created_at', 'desc')->get();
        return view('phongban.index', compact('phongbans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo mới phòng ban
        return view('phongban.create');
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
            'ma_phong_ban' => 'required|string|max:50|unique:phong_bans',
            'ten_phong_ban' => 'required|string|max:100',
            'ghi_chu' => 'nullable|string',
        ]);

        // Tạo mới phòng ban
        PhongBan::create($request->all());

        return redirect()->route('phongban.index')->with('success', 'Phòng ban được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy thông tin chi tiết phòng ban
        $phongban = PhongBan::findOrFail($id);
        return view('phongban.show', compact('phongban'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Hiển thị form chỉnh sửa phòng ban
        $phongban = PhongBan::findOrFail($id);
        return view('phongban.edit', compact('phongban'));
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
            'ma_phong_ban' => 'required|string|max:50|unique:phong_bans,ma_phong_ban,' . $id,
            'ten_phong_ban' => 'required|string|max:100',
            'ghi_chu' => 'nullable|string',
        ]);

        // Cập nhật thông tin phòng ban
        $phongban = PhongBan::findOrFail($id);
        $phongban->update($request->all());

        return redirect()->route('phongban.index')->with('success', 'Phòng ban được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Xóa phòng ban
        $phongban = PhongBan::findOrFail($id);
        $phongban->delete();

        return redirect()->route('phongban.index')->with('success', 'Phòng ban đã được xóa.');
    }
}

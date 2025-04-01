<?php

namespace App\Http\Controllers;

use App\Models\HuongChungTu;
use Illuminate\Http\Request;

class HuongChungTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy danh sách hướng chứng từ, sắp xếp theo ngày tạo mới nhất
        $huongChungTus = HuongChungTu::orderBy('created_at', 'desc')->get();
        return view('huongchungtu.index', compact('huongChungTus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hiển thị form tạo mới hướng chứng từ
        return view('huongchungtu.create');
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
            'ma_huong_chung_tu' => 'required|string|max:50|unique:huong_chung_tus',
            'ten_huong_chung_tu' => 'required|string|max:100',
            'ghi_chu' => 'nullable|string',
        ]);

        // Tạo mới hướng chứng từ
        HuongChungTu::create($request->all());

        return redirect()->route('huongchungtu.index')->with('success', 'Hướng chứng từ được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Lấy thông tin chi tiết hướng chứng từ
        $huongChungTu = HuongChungTu::findOrFail($id);
        return view('huongchungtu.show', compact('huongChungTu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Hiển thị form chỉnh sửa hướng chứng từ
        $huongChungTu = HuongChungTu::findOrFail($id);
        return view('huongchungtu.edit', compact('huongChungTu'));
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
            'ma_huong_chung_tu' => 'required|string|max:50|unique:huong_chung_tus,ma_huong_chung_tu,' . $id,
            'ten_huong_chung_tu' => 'required|string|max:100',
            'ghi_chu' => 'nullable|string',
        ]);

        // Cập nhật thông tin hướng chứng từ
        $huongChungTu = HuongChungTu::findOrFail($id);
        $huongChungTu->update($request->all());

        return redirect()->route('huongchungtu.index')->with('success', 'Hướng chứng từ được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Xóa hướng chứng từ
        $huongChungTu = HuongChungTu::findOrFail($id);
        $huongChungTu->delete();

        return redirect()->route('huongchungtu.index')->with('success', 'Hướng chứng từ đã được xóa.');
    }
}

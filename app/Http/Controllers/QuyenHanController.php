<?php

namespace App\Http\Controllers;

use App\Models\QuyenHan;
use Illuminate\Http\Request;

class QuyenHanController extends Controller
{
    public function index()
    {
        $quyenHans = QuyenHan::all();
        return view('quyenhan.index', compact('quyenHans'));
    }

    public function create()
    {
        return view('quyenhan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_quyen' => 'required|unique:quyen_hans|string|max:255',
            'ten_quyen' => 'required|string|max:255',
        ]);

        QuyenHan::create($request->only(['ma_quyen', 'ten_quyen']));

        return redirect()->route('quyenhan.index')->with('success', 'Thêm quyền mới thành công.');
    }

    

    public function edit($id)
    {
        // Hiển thị form chỉnh sửa quyền hạn
        $quyenHan = QuyenHan::findOrFail($id);
        return view('quyenhan.edit', compact('quyenHan'));
    }
    
    /**
     * Cập nhật quyền hạn đã chọn
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'ma_quyen' => 'required|string|max:255|unique:quyen_hans,ma_quyen,' . $id,
            'ten_quyen' => 'required|string|max:255',
        ]);
    
        // Tìm và cập nhật quyền hạn
        $quyenHan = QuyenHan::findOrFail($id);
        $quyenHan->update([
            'ma_quyen' => $request->ma_quyen,
            'ten_quyen' => $request->ten_quyen,
        ]);
    
        return redirect()->route('quyenhan.index')->with('success', 'Quyền hạn được cập nhật thành công.');
    }
    

    public function destroy(QuyenHan $quyenHan)
    {
        // Kiểm tra xem quyền hạn có tồn tại không
          
        $quyenHan->delete();

        return redirect()->route('quyenhan.index')->with('success', 'Xoá quyền thành công.');
    }
}

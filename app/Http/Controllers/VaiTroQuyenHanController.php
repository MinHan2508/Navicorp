<?php
namespace App\Http\Controllers;

use App\Models\VaiTro;
use App\Models\QuyenHan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaiTroQuyenHanController extends Controller
{
    // Danh sách vai trò và quyền tương ứng
    public function index()
    {
        $vaiTros = VaiTro::with('quyenHans')->get(); // assuming you have quan hệ quyenHans trong VaiTro
        return view('vaitro_quyenhan.index', compact('vaiTros'));
    }

    // Form chỉnh sửa quyền cho 1 vai trò
    public function edit($id)
    {
        $vaiTro = VaiTro::findOrFail($id);
        $tatCaQuyen = QuyenHan::all();
        $quyenDaGan = $vaiTro->quyenHans->pluck('id')->toArray(); // danh sách quyền đã gán

        return view('vaitro_quyenhan.edit', compact('vaiTro', 'tatCaQuyen', 'quyenDaGan'));
    }

    // Lưu cập nhật quyền cho vai trò
    public function update(Request $request, $id)
    {
        $vaiTro = VaiTro::findOrFail($id);

        $quyenIds = $request->input('quyen_ids', []);
        $vaiTro->quyenHans()->sync($quyenIds); // cập nhật bảng pivot

        return redirect()->route('vaitro_quyenhan.index')->with('success', 'Cập nhật quyền cho vai trò "' . $vaiTro->ten_vai_tro . '" thành công.');
    }
}

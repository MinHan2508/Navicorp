<?php

namespace App\Http\Controllers;

use App\Models\ChungTu;
use Illuminate\Http\Request;

class ChungTuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chungTus = ChungTu::with(['loaiChungTu', 'nguoiTao', 'nguoiGuiDoiTac', 'trangThai'])->get();
        return view('chungtu.index', compact('chungTus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loaiChungTus = \App\Models\LoaiChungTu::all(); // Lấy tất cả loại chứng từ
        $trangThaiChungTus = \App\Models\TrangThaiChungTu::all(); // Lấy tất cả trạng thái chứng từ

        return view('chungtu.create', compact('loaiChungTus', 'trangThaiChungTus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ma_chung_tu' => 'required|string|max:255|unique:chung_tus',
            'tieu_de' => 'required|string|max:255',
            'duong_dan' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'nguoi_tao_id' => 'nullable|exists:users,id',
            'nguoi_gui_doi_tac_id' => 'nullable|exists:doi_tacs,id',
            'trang_thai_id' => 'required|exists:trang_thai_chung_tus,id',
        ]);

        $chungTu = ChungTu::create($validatedData);

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        return view('chungtu.show', compact('chungTu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        return view('chungtu.edit', compact('chungTu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChungTu  $chungTu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChungTu $chungTu)
    {
        $validatedData = $request->validate([
            'ma_chung_tu' => 'required|string|max:255|unique:chung_tus,ma_chung_tu,' . $chungTu->id,
            'tieu_de' => 'required|string|max:255',
            'duong_dan' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string',
            'id_loai_chung_tu' => 'required|exists:loai_chung_tus,id',
            'nguoi_tao_id' => 'nullable|exists:users,id',
            'nguoi_gui_doi_tac_id' => 'nullable|exists:doi_tacs,id',
            'trang_thai_id' => 'required|exists:trang_thai_chung_tus,id',
        ]);

        $chungTu->update($validatedData);

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chungTu = ChungTu::findOrFail($id);
        $chungTu->delete();

        return redirect()->route('chungtu.index')->with('success', 'Chứng từ đã được xóa thành công.');
    }
}

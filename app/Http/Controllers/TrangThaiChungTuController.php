<?php

namespace App\Http\Controllers;

use App\Models\TrangThaiChungTu;
use Illuminate\Http\Request;

class TrangThaiChungTuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trangThaiChungTus = TrangThaiChungTu::orderBy('created_at', 'desc')->get();
        return view('trangthaichungtu.index', compact('trangThaiChungTus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trangthaichungtu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus',
            'ten_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus',
        ]);

        $trangThaiChungTu = new TrangThaiChungTu();
        $trangThaiChungTu->ma_trang_thai = $request->ma_trang_thai;
        $trangThaiChungTu->ten_trang_thai = $request->ten_trang_thai;
        $trangThaiChungTu->save();

        return redirect()->route('trangthaichungtu.index')->with('success', 'Trạng thái chứng từ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        return view('trangthaichungtu.show', compact('trangThaiChungTu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        return view('trangthaichungtu.edit', compact('trangThaiChungTu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ma_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus,ma_trang_thai,' . $id,
            'ten_trang_thai' => 'required|string|max:255|unique:trang_thai_chung_tus,ten_trang_thai,' . $id,
        ]);

        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        $trangThaiChungTu->ma_trang_thai = $request->ma_trang_thai;
        $trangThaiChungTu->ten_trang_thai = $request->ten_trang_thai;
        $trangThaiChungTu->save();

        return redirect()->route('trangthaichungtu.index')->with('success', 'Trạng thái chứng từ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $trangThaiChungTu = TrangThaiChungTu::findOrFail($id);
        $trangThaiChungTu->delete();

        return redirect()->route('trangthaichungtu.index')->with('success', 'Trạng thái chứng từ deleted successfully.');
    }
}

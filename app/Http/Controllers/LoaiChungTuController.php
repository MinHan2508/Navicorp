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
        $request->validate([
            'ma_loai_chung_tu' => 'required|string|max:50|unique:loai_chung_tus',
            'ten_loai_chung_tu' => 'required|string|max:100',
        ]);

        $loaichungtu = new LoaiChungTu();
        $loaichungtu->ma_loai_chung_tu = $request->ma_loai_chung_tu;
        $loaichungtu->ten_loai_chung_tu = $request->ten_loai_chung_tu;
        $loaichungtu->save();

        return redirect()->route('loaichungtu.index')->with('success', 'Loại chứng từ created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoaiChungTu  $loaichungtu
     * @return \Illuminate\Http\Response
     */
    public function show(LoaiChungTu $loaichungtu)
    {
        return view('loaichungtu.show', compact('loaichungtu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoaiChungTu  $loaichungtu
     * @return \Illuminate\Http\Response
     */
    public function edit(LoaiChungTu $loaichungtu)
    {
        return view('loaichungtu.edit', compact('loaichungtu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoaiChungTu  $loaichungtu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoaiChungTu $loaichungtu)
    {
        $request->validate([
            'ma_loai_chung_tu' => 'required|string|max:50|unique:loai_chung_tus,ma_loai_chung_tu,' . $loaichungtu->id,
            'ten_loai_chung_tu' => 'required|string|max:100',
        ]);

        $loaichungtu->ma_loai_chung_tu = $request->ma_loai_chung_tu;
        $loaichungtu->ten_loai_chung_tu = $request->ten_loai_chung_tu;
        $loaichungtu->save();

        return redirect()->route('loaichungtu.index')->with('success', 'Loại chứng từ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoaiChungTu  $loaichungtu
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoaiChungTu $loaichungtu)
    {
        $loaichungtu->delete();

        return redirect()->route('loaichungtu.index')->with('success', 'Loại chứng từ deleted successfully.');
    }
}

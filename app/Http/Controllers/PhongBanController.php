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
        $request->validate([
            'ma_phong_ban' => 'required|string|max:50|unique:phong_bans',
            'ten_phong_ban' => 'required|string|max:100',
        ]);

        $phongban = new PhongBan();
        $phongban->ma_phong_ban = $request->ma_phong_ban;
        $phongban->ten_phong_ban = $request->ten_phong_ban;
        $phongban->save();

        return redirect()->route('phongban.index')->with('success', 'Phòng ban created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $request->validate([
            'ma_phong_ban' => 'required|string|max:50|unique:phong_bans,ma_phong_ban,' . $id,
            'ten_phong_ban' => 'required|string|max:100',
        ]);

        $phongban = PhongBan::findOrFail($id);
        $phongban->ma_phong_ban = $request->ma_phong_ban;
        $phongban->ten_phong_ban = $request->ten_phong_ban;
        $phongban->save();

        return redirect()->route('phongban.index')->with('success', 'Phòng ban updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phongban = PhongBan::findOrFail($id);
        $phongban->delete();

        return redirect()->route('phongban.index')->with('success', 'Phòng ban deleted successfully.');
    }
}

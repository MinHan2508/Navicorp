<?php

namespace App\Http\Controllers;

use App\Models\PhanCong;
use App\Models\User;
use App\Models\PhongBan;
use Illuminate\Http\Request;

class PhanCongController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phancongs = PhanCong::with(['user', 'phongban'])->orderBy('created_at', 'desc')->get();
        return view('phancong.index', compact('phancongs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $phongbans = PhongBan::all();
        return view('phancong.create', compact('users', 'phongbans'));
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
            'user_id' => 'required|exists:users,id',
            'phongban_id' => 'required|exists:phong_bans,id',
        ]);

        $phancong = new PhanCong();
        $phancong->user_id = $request->user_id;
        $phancong->phongban_id = $request->phongban_id;
        $phancong->save();

        return redirect()->route('phancong.index')->with('success', 'Phân công created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phancong = PhanCong::with(['user', 'phongban'])->findOrFail($id);
        return view('phancong.show', compact('phancong'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phancong = PhanCong::findOrFail($id);
        $users = User::all();
        $phongbans = PhongBan::all();
        return view('phancong.edit', compact('phancong', 'users', 'phongbans'));
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
            'user_id' => 'required|exists:users,id',
            'phongban_id' => 'required|exists:phong_bans,id',
        ]);

        $phancong = PhanCong::findOrFail($id);
        $phancong->user_id = $request->user_id;
        $phancong->phongban_id = $request->phongban_id;
        $phancong->save();

        return redirect()->route('phancong.index')->with('success', 'Phân công updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phancong = PhanCong::findOrFail($id);
        $phancong->delete();

        return redirect()->route('phancong.index')->with('success', 'Phân công deleted successfully.');
    }
}

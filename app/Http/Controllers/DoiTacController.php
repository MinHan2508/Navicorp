<?php

namespace App\Http\Controllers;

use App\Models\DoiTac;
use Illuminate\Http\Request;

class DoiTacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doiTacs = DoiTac::orderBy('created_at', 'desc')->get();
        return view('doitac.index', compact('doiTacs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doitac.create');
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
            'ten_doi_tac' => 'required|string|max:255',
            'email' => 'required|email|unique:doi_tacs,email',
            'sdt' => 'required|string|max:20|unique:doi_tacs,sdt',
            'dia_chi' => 'nullable|string|max:255',
            'loai_doi_tac' => 'required|in:Cá nhân,Tổ chức,Nhà Nước,Khác',
        ]);

        $doiTac = new DoiTac();
        $doiTac->ten_doi_tac = $request->ten_doi_tac;
        $doiTac->email = $request->email;
        $doiTac->sdt = $request->sdt;
        $doiTac->dia_chi = $request->dia_chi;
        $doiTac->loai_doi_tac = $request->loai_doi_tac;
        $doiTac->save();

        return redirect()->route('doitac.index')->with('success', 'Đối tác được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doiTac = DoiTac::findOrFail($id);
        return view('doitac.show', compact('doiTac'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doiTac = DoiTac::findOrFail($id);
        return view('doitac.edit', compact('doiTac'));
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
            'ten_doi_tac' => 'required|string|max:255',
            'email' => 'required|email|unique:doi_tacs,email,' . $id,
            'sdt' => 'required|string|max:20|unique:doi_tacs,sdt,' . $id,
            'dia_chi' => 'nullable|string|max:255',
            'loai_doi_tac' => 'required|in:Cá nhân,Tổ chức,Nhà Nước,Khác',
        ]);

        $doiTac = DoiTac::findOrFail($id);
        $doiTac->ten_doi_tac = $request->ten_doi_tac;
        $doiTac->email = $request->email;
        $doiTac->sdt = $request->sdt;
        $doiTac->dia_chi = $request->dia_chi;
        $doiTac->loai_doi_tac = $request->loai_doi_tac;
        $doiTac->save();

        return redirect()->route('doitac.index')->with('success', 'Đối tác được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doiTac = DoiTac::findOrFail($id);
        $doiTac->delete();

        return redirect()->route('doitac.index')->with('success', 'Đối tác đã được xóa thành công.');
    }
}

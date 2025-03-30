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
        $chungTus = ChungTu::all();
        return view('chungtu.index', compact('chungTus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chungtu.create');
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $chungTu = ChungTu::create($validatedData);

        return response()->json($chungTu, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChungTu  $chungTu
     * @return \Illuminate\Http\Response
     */
    public function show(ChungTu $chungTu)
    {
        return response()->json($chungTu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChungTu  $chungTu
     * @return \Illuminate\Http\Response
     */
    public function edit(ChungTu $chungTu)
    {
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $chungTu->update($validatedData);

        return response()->json($chungTu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChungTu  $chungTu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChungTu $chungTu)
    {
        $chungTu->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

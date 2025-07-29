<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::latest()->paginate(10);
        return view('divisions.index', [
            'title' => 'Data Divisi',
            'divisions' => $divisions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('divisions.create', [
            'title' => 'Tambah Divisi'
        ]);
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
            'name' => 'required|string|max:255|unique:divisions',
            'description' => 'nullable|string'
        ]);

        Division::create($request->all());

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        return view('divisions.show', [
            'title' => 'Detail Divisi',
            'division' => $division
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return view('divisions.edit', [
            'title' => 'Edit Divisi',
            'division' => $division
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name,' . $division->id,
            'description' => 'nullable|string'
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()->route('divisions.index')
            ->with('success', 'Divisi berhasil dihapus');
    }
}

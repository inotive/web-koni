<?php

namespace App\Http\Controllers\Admin;

use App\Models\ManajemenRKA;
use Flasher\Laravel\Http\Request;
use App\Http\Controllers\Controller;

class ManajemenRKAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ManajemenRKA::orderBy('id', 'desc')->get();

        return view('admin.manajemen-rka.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ManajemenRKA $manajemenRKA)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManajemenRKA $manajemenRKA)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManajemenRKA $manajemenRKA)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManajemenRKA $manajemenRKA)
    {
        //
    }
}

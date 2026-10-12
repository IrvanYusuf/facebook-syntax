<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'this is car lists';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'this is car create form';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 'this is car store';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'this is car show with id: ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return 'this is car edit form with id: ' . $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'this is form update car with id: ' . $id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return 'this is car destroy with id: ' . $id;
    }
}

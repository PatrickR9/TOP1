<?php

namespace App\Http\Controllers;

use App\Models\Uservalue;
use App\Http\Requests\StoreUservalueRequest;
use App\Http\Requests\UpdateUservalueRequest;

class UservalueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreUservalueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Uservalue $uservalue)
    {
        return view('uservalue_data.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Uservalue $uservalue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUservalueRequest $request, Uservalue $uservalue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Uservalue $uservalue)
    {
        //
    }
}

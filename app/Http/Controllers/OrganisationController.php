<?php

namespace App\Http\Controllers;

use App\Models\organisation;
use App\Http\Requests\StoreorganisationRequest;
use App\Http\Requests\UpdateorganisationRequest;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(StoreorganisationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(organisation $organisation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(organisation $organisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorganisationRequest $request, organisation $organisation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(organisation $organisation)
    {
        //
    }
}

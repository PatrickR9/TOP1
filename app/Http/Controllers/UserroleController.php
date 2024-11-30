<?php

namespace App\Http\Controllers;

use App\Models\userrole;
use App\Http\Requests\StoreuserroleRequest;
use App\Http\Requests\UpdateuserroleRequest;

class UserroleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewParams = 
        [
            'title' => 'Benutzerrollen',
            'add_class' => resolve('customer_role')
        ];

        return view('management.user_roles.index', $viewParams);
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
    public function store(StoreuserroleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(userrole $userrole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(userrole $userrole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateuserroleRequest $request, userrole $userrole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userrole $userrole)
    {
        //
    }
}

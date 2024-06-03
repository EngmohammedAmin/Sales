<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account_type;
use Illuminate\Http\Request;

class Account_typeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Account_type::select()->orderby('id', 'ASC')->paginate(PAGINATION_CONST);

        return view('admin.account_type.index', compact('data'));
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
    public function show(Account_type $account_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data=$id;
        return view('admin.account_type.edit', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account_type $account_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account_type $account_type)
    {
        //
    }
}
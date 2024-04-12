<?php

namespace App\Http\Controllers;

use App\Models\ContactReturn;
use App\Http\Requests\StoreContactReturnRequest;
use App\Http\Requests\UpdateContactReturnRequest;
use Illuminate\Http\Request;

class ContactReturnController extends Controller
{

    private $contactReturn;

    public function __construct(ContactReturn $contactReturn)
    {
        $this->contactReturn = $contactReturn;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactreturns = $this->contactReturn->all();
        return response()->json($contactreturns, 200);
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
    public function store(StoreContactReturnRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $contactreturn = $this->contactReturn->find($id);
        if ($contactreturn === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404); //json
        }
        return response()->json($contactreturn, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactReturn $contactReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactReturnRequest $request, ContactReturn $contactReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactReturn $contactReturn)
    {
        //
    }
}

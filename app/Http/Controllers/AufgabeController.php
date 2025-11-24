<?php

namespace App\Http\Controllers;

use App\Models\Aufgabe;
use Illuminate\Http\Request;

class AufgabeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return response()->json(Aufgabe::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        try {
            $aufgabe = Aufgabe::create($request->all());
        } catch (\Throwable){
            return response()->json(null, 400);
        }
        return response()->json($aufgabe, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Aufgabe $aufgabe) {
        return response()->json($aufgabe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aufgabe $aufgabe) {
        $aufgabe->update($request->all());
        return response()->json($aufgabe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aufgabe $aufgabe) {
        $aufgabe->delete();
        return response()->json(null, 204);
    }
}

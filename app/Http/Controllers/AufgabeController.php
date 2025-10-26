<?php

namespace App\Http\Controllers;

use App\Events\AufgabeUpdated;
use App\Models\Aufgabe;
use App\Models\Projekt;
use App\Models\User;
use Illuminate\Http\Request;

class AufgabeController extends Controller {

    public function index() {
        return response()->json(Aufgabe::all());
    }

    public function store(Request $request) {
        try {
            $requestArr = $request->all();
            if (empty($request['user_id'])) {
                $requestArr['user_id'] = $request->user()->id;
            }
            $aufgabe = Aufgabe::create($requestArr);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
        return response()->json($aufgabe, 201);
    }

    public function show(Aufgabe $aufgabe) {
        return response()->json($aufgabe);
    }

    public function update(Request $request, Aufgabe $aufgabe) {
        $aufgabe->update($request->all());
        AufgabeUpdated::dispatch($aufgabe);
        return response()->json($aufgabe);
    }

    public function destroy(Aufgabe $aufgabe) {
        $aufgabe->delete();
        return response()->json(null, 204);
    }

    public function getAufgabenFromBenutzer(User $user) {
        return response()->json($user->aufgaben()->get());
    }

    public function getAufgabenFromProjekt(Projekt $projekt) {
        return response()->json($projekt->aufgaben()->get());
    }

    public function updateDeadline(Request $request, Aufgabe $aufgabe) {
        $aufgabe->deadline = $request->deadline;
        return response()->json($aufgabe);
    }

    public function getOverdue() {
        $aufgaben = Aufgabe::where('deadline', '<', now()->toDateTimeString())->get();
        return response()->json($aufgaben);
    }
}

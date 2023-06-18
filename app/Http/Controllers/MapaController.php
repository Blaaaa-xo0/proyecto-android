<?php

namespace App\Http\Controllers;

use App\Models\Mapa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (Auth::user()->hasRole('Admin')){
            $mapas = Mapa::all();
        } else {
            $mapas = $user->mapas;
        }

        return view('dashboard', ['mapas' => $mapas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        $user = $request->user();

        $mapa = new Mapa;
        
        $mapa->user_id = $user->id;
        $mapa->name = $request->input('name');
        $mapa->description = $request->input('description');
        $mapa->longitude = $request->input('longitude');
        $mapa->latitude = $request->input('latitude');
        
        $mapa->save();

        return response()->json(['id' => $mapa->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapa $mapa)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            
        ]);

        $mapa->name = $request->input('name');
        $mapa->description = $request->input('description');
        $mapa->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapa $mapa)
    {
        //
        $mapa->delete();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{public function index()
    {
    $films = Film::with('producers',)->get();
    return $films;
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomfilm' => [
                'required',
                'string',
                Rule::unique('films', 'nomfilm')->ignore($request->id),
            ],
            'description' => 'required|string',
            'imagefilm' => 'required|string',
            'typeven' => 'required|string',
            'prix' => 'required|integer',
            'nbplaces' => 'required|integer',
            'datedeb' => 'required|date',
            'datefin' => 'required|date',
            'producerID' => 'required|integer'
            // Add any additional rules if needed
        ], [
            'nomfilm.required' => 'Le champ "Nom" est obligatoire.',
            'nomfilm.unique' => 'Film existe déjà.',
            'description.required' => 'Le champ Description  est obligatoire.',
            'imagefilm.required' => 'Poster est obligatoire.',
            'typeven.required' => 'Le champ "Type" est obligatoire.',
            'prix.required' => 'Prix est obligatoire.',
            'nbplaces.required' => 'Le nombre des places disponible est obligatoire.',
            'datedeb.required' => 'Date Début est obligatoire.',
            'datefin.required' => 'Date Fin est obligatoire.',
            'producerID.required' => 'Le champ Producteur est obligatoire.',
            // Customize other error messages as needed
        ]);


         // Assuming 'acteurs' is an array of actor IDs in the request
        $acteurIds = $request->input('acteurs', []);
        $film = Film::create($validatedData);
        $film->acteurs()->attach($acteurIds);

        return response()->json($film, 201);
    }

    public function show($id)
    {
        $Films = Film::find($id);
    return response()->json($Films);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nomfilm' => 'required|string',
            'description' => 'required|string',
            'imagefilm' => 'required|string',
            'typeven' => 'required|string',
            'prix' => 'required|intger',
            'nbplaces' => 'required|integer',
            'datedeb' => 'required|date',
            'datefin' => 'required|date',
            'producerID' => 'required|integer'
            // Add any additional rules if needed
        ], [
            'nomfilm.required' => 'Le champ "Nom" est obligatoire.',
            'description.required' => 'Le champ Description  est obligatoire.',
            'imagefilm.required' => 'Poster est obligatoire.',
            'typeven.required' => 'Le champ "Type" est obligatoire.',
            'prix.required' => 'Prix est obligatoire.',
            'nbplaces.required' => 'Le nombre des places disponible est obligatoire.',
            'datedeb.required' => 'Date Début est obligatoire.',
            'datefin.required' => 'Date Fin est obligatoire.',
            'producerID.required' => 'Le champ Producteur est obligatoire.',
            // Customize other error messages as needed
        ]);
        $Films = Film::find($id);
        $Films->update($request->all());
    return response()->json($Films,200);
    }

    public function destroy($id)
    {
        $Films = Film::find($id);
        $Films->delete();
    return response()->json('Film supprimée !');
    }

    public function showFilmByProd($idprod)
    {
        $Films= Film::where('producerID', $idprod)->with('producers')->get();
    return response()->json($Films);
    }
}

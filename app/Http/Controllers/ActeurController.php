<?php

namespace App\Http\Controllers;

use App\Models\Acteur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActeurController extends Controller
{
    public function index()
    {
    $acteurs = Acteur::all();
    return $acteurs;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nompreacteur' => [
                'required',
                'string',
                Rule::unique('acteurs', 'nompreacteur')->ignore($request->id),
            ],
            'description' => 'required|string',
            'imageacteur' => 'required|string',
            // Add any additional rules if needed
        ], [
            'nompreacteur.required' => 'Le champ "Nom" est obligatoire.',
            'nompreacteur.unique' => 'Ce nom de acteur existe déjà.',
            'description.required' => 'Le champ "Bio" est obligatoire.',
            'imageacteur.required' => 'Le champ "Image du acteur" est obligatoire.',
            // Customize other error messages as needed
        ]);

        $acteur = Acteur::create($validatedData);

        return response()->json($acteur, 201);
    }
    public function show($id)
    {
        $acteurs = Acteur::find($id);
    return response()->json($acteurs);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nompreacteur' => 'required|string',
            'description' => 'required|string',
            'imageacteur' => 'required|string',
            // Add any additional rules if needed
        ], [
            'nompreacteur.required' => 'Le champ "Nom " est obligatoire.',
            'description.required' => 'Le champ "Bio" est obligatoire.',
            'imageacteur.required' => 'Le champ "Image " est obligatoire.',
            // Customize other error messages as needed
        ]);
        $acteurs = Acteur::find($id);
        $acteurs->update($request->all());
    return response()->json($acteurs, 200);
    }

    public function destroy($id)
    {
        $acteurs = Acteur::find($id);
        $acteurs->delete();
    return response()->json(' supprimée !');
    }
}

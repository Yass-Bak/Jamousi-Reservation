<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ProducerController extends Controller
{  public function index()
    {
     $producers = Producer::all();
    return  $producers;
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nompreproducer' => [
                'required',
                'string',
                Rule::unique('producers', 'nompreproducer')->ignore($request->id),
            ],
            'description' => 'required|string',
            'imageproducer' => 'required|string',
            // Add any additional rules if needed
        ], [
            'nompreproducer.required' => 'Le champ "Nom du producteur" est obligatoire.',
            'nompreproducer.unique' => 'Ce nom de producteur existe déjà.',
            'description.required' => 'Le champ "Bio" est obligatoire.',
            'imageproducer.required' => 'Le champ "Image du producteur" est obligatoire.',
            // Customize other error messages as needed
        ]);

        $producer = Producer::create($validatedData);

        return response()->json($producer, 201);
    }
    public function show($id)
    {
        $producers = Producer::find($id);
    return response()->json( $producers);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nompreproducer' => 'required|string',
            'description' => 'required|string',
            'imageproducer' => 'required|string',
            // Add any additional rules if needed
        ], [
            'nompreproducer.required' => 'Le champ "Nom du producteur" est obligatoire.',
            'description.required' => 'Le champ "Bio" doit être une chaîne de caractères.',
            'imageproducer.required' => 'Le champ "Image du producteur" est obligatoire.',
            // Customize other error messages as needed
        ]);
     $producers = Producer::find($id);
     $producers->update($request->all());
    return response()->json( $producers, 200);
    }

    public function destroy($id)
    {
     $producers = Producer::find($id);
     $producers->delete();
    return response()->json(' supprimée !');
    }
}

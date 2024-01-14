<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomfilm', 'description','imagefilm','typeven','prix', 'nbplaces', 'datedeb','datefin','producerID',
    ];

    public function acteurs()
    {
        return $this->belongsToMany(Acteur::class, 'film_acteur', 'film_id', 'acteur_id');
    }
    public function producers()
    {
        return $this->belongsTo(Producer::class, "producerID");
    }
    public static $rules = [
       // 'name' => 'required|string|max:255',
        'prix' => 'required|numeric|min:1', // Cette règle s'assure que le prix est un nombre positif
    ];

    public function validate($data)
    {
        return validator($data, static::$rules);
    }

}

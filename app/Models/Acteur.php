<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acteur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nompreacteur', 'description','imageacteur'
    ];
    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_acteur', 'acteur_id', 'film_id');
    }
}

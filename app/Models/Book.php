<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Adiciona o array $fillable para permitir a atribuição em massa
    protected $fillable = [
        'title',      // Exemplo de outros campos que podem existir no seu modelo
        'author',     // Exemplo de outros campos que podem existir no seu modelo
        'genre',      // Exemplo de outros campos que podem existir no seu modelo
        'image',      // Exemplo de outros campos que podem existir no seu modelo
        'synopsis',   // Exemplo de outros campos que podem existir no seu modelo
        'situation',  // Adicione 'situation' ao array $fillable
    ];

    public function reservation()
    {
        return $this->belongsTo('App\Models\Reservation');
    }
}

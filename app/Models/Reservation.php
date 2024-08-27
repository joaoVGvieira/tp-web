<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Adicione as colunas que podem ser preenchidas em massa
    protected $fillable = [
        'users_id',
        'books_id',
        'return_date',
    ];

    /**
     * Define o relacionamento com o modelo User.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    /**
     * Define o relacionamento com o modelo Book.
     */
    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'books_id');
    }
}

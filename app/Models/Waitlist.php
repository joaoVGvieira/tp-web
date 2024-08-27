<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use HasFactory;
    public function store(Request $request)
{
    $book = Book::findOrFail($request->books_id);

    if ($book->situation === 'Emprestado') {
        // Adiciona o usuário à fila de espera
        Waitlist::create([
            'users_id' => auth()->user()->id,
            'books_id' => $request->books_id,
        ]);

        return redirect('/dashboard')->with('msg-success', 'Livro está emprestado, você foi adicionado à fila de espera!');
    }

    // Código para reservar o livro se estiver disponível...
}
}

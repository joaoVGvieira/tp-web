<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Book;
use Datetime;

class ReservationController extends Controller
{
    public function create($id)
    {
        $user = auth()->user();
        $book = Book::findOrFail($id);
        return view('reservation.create', ['usuario' => $user, 'livro' => $book]);
    }

    public function store(Request $request)
    {
        $reservation = new Reservation;
        $reservation->users_id = auth()->user()->id;
        $reservation->books_id = $request->books_id;

        // Data atual
        $currentDate = new DateTime();

        // Adiciona 7 dias à data atual
        $returnDate = clone $currentDate;
        $returnDate->modify('+7 days');

        // Verifica se a data de retorno cai em um sábado ou domingo
        $dayOfWeek = $returnDate->format('N'); // 6 = Sábado, 7 = Domingo
        if ($dayOfWeek == 6) {
            // Se for sábado, adiciona 2 dias para ir para segunda-feira
            $returnDate->modify('+2 days');
        } elseif ($dayOfWeek == 7) {
            // Se for domingo, adiciona 1 dia para ir para segunda-feira
            $returnDate->modify('+1 day');
        }

        // Atribui a data de retorno ajustada à reserva
        $reservation->return_date = $returnDate->format('Y-m-d');

        // Verifica se a data de retorno não está no passado (no caso de manipulação da data)
        if ($returnDate < $currentDate) {
            return redirect('/livros/reserva/' . $reservation->books_id)->with('msg-error', 'Você não pode realizar uma reserva para uma data passada.');
        }

        if ($reservation->save()) {
            Book::where('id', $request->books_id)
                ->update(['situation' => 'Emprestado']);
            return redirect('/dashboard')->with('msg-success', 'Sua reserva foi realizada com sucesso!');
        }

        return redirect('/livros')->with('msg-error', 'Algo de inesperado aconteceu. Por favor, entre em contato com os administradores.');

    }

    public function dashboard()
    {
        $user = auth()->user();
        $reservations = Reservation::where('users_id', $user->id)->get();

        $books = [];
        foreach ($reservations as $reservation) {
            $books[] = Book::findOrFail($reservation->books_id);
        }


        return view('dashboard', ['livros' => $books, 'reserva' => $reservations]);
    }
    
}

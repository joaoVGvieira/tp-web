<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use App\Models\Book;
use Datetime;

class ReservationController extends Controller
{
    public function create($id)
    {
        $user = auth()->user();
        
        if ($user->pending_fine > 0) {
            return redirect('/dashboard')->with('msg-error', 'Você tem uma multa pendente. Pague a multa antes de fazer uma nova reserva.');
        }
    
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

    public function payFine()
{
    $user = auth()->user();

    if ($user->pending_fine > 0) {
        // Simulação de pagamento
        $this->simulatePayment($user);

        // Após o pagamento, zera o valor da multa pendente
        $user->pending_fine = 0;
        $user->save();

        return redirect('/dashboard')->with('msg-success', 'Sua multa foi paga com sucesso!');
    } else {
        return redirect('/dashboard')->with('msg-info', 'Não há multas pendentes para pagar.');
    }
}

private function simulatePayment($user)
{
    // Aqui você pode adicionar lógica de simulação de pagamento, como uma espera ou registro de logs
    sleep(1); // Simulando um atraso no processamento do pagamento

    // Log para simulação (opcional)
    \Log::info('Pagamento simulado para o usuário: ' . $user->id);
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

    public function returnBook($id)
    {
        $user = auth()->user();
    
        if (!$user->is_admin) {
            return redirect('/dashboard')->with('msg-error', 'Apenas administradores podem realizar a devolução de livros.');
        }
    
        $reservation = Reservation::where('books_id', $id)->first();
    
        if ($reservation) {
            $book = Book::findOrFail($reservation->books_id);
            $currentDate = new DateTime();
            $returnDate = new DateTime($reservation->return_date);
            $fine = 0;
    
            if ($currentDate > $returnDate) {
                $daysLate = $returnDate->diff($currentDate)->days;
                $fine = $daysLate * 5; // Exemplo: R$ 5,00 por dia de atraso
    
                $reservation->fine = $fine;
                $reservation->save();
    
                // Adiciona a multa ao usuário
                $reservationUser = $reservation->user; // Carrega o usuário associado à reserva
                $reservationUser->pending_fine += $fine;
                $reservationUser->save();
            }
            
            /* Exemplo de multa fixa
            $fine = 2.50;
            $reservationUser = $reservation->user; // Carrega o usuário associado à reserva
            $reservationUser->pending_fine += $fine;
            $reservationUser->save();*/
    
            $book->update(['situation' => 'Disponível']);
            $reservation->delete();
    
            // Verificar fila de espera e outras operações...
    
            return redirect('/dashboard')->with('msg-success', 'O livro foi devolvido com sucesso!');
        } else {
            return redirect('/dashboard')->with('msg-error', 'Reserva não encontrada.');
        }
    }
    
    
public function allReservations()
{
    // Obtém todas as reservas junto com o usuário e o livro relacionados
    $reservations = Reservation::with('user', 'book')->get()
        ->groupBy(function ($reservation) {
            return $reservation->user->id . '-' . $reservation->book->id;
        });

    return view('reservation.all-reservation', ['reservations' => $reservations]);
}
 

    public function waitlist()
{
    $waitlists = Waitlist::with('user', 'book')->get();
    return view('waitlist.index', ['waitlists' => $waitlists]);
}

public function addToWaitlist($bookId)
{
    $user = auth()->user();
    $book = Book::findOrFail($bookId);

    // Verifica se o usuário já está na fila de espera para este livro
    $exists = Waitlist::where('users_id', $user->id)
                      ->where('books_id', $bookId)
                      ->exists();
    
    if ($exists) {
        return redirect()->back()->with('msg-info', 'Você já está na fila de espera para este livro.');
    }

    // Adiciona à fila de espera
    $waitlist = new Waitlist();
    $waitlist->users_id = $user->id;
    $waitlist->books_id = $bookId;

    if ($waitlist->save()) {
        return redirect()->back()->with('msg-success', 'Você entrou na fila de espera com sucesso!');
    } else {
        return redirect()->back()->with('msg-error', 'Não foi possível entrar na fila de espera.');
    }
}
    
}

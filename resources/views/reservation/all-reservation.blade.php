@extends('layout.main')
@section('title', 'Todas as Reservas de Livros')

@section('content')

    <div class="page-header">
        <h1>Todas os emprestimos livros</h1>
    </div>

    <div class="dashboard-books-table">
        @if ($reservations->isEmpty())
            <p>Atualmente não há emprestimos de livros.</p>
        @else
            <p>Abaixo estão todas os emprestimos de livros, incluindo informações sobre multas, se houver.</p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Usuário</th>
                        <th scope="col">Livro</th>
                        <th scope="col">Data de Devolução</th>
                        <th scope="col">Multa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $group)
                        @php
                            // Obtém o primeiro item do grupo para exibir as informações
                            $first = $group->first();
                        @endphp
                        <tr>
                            <td>{{ $first->user->name }}</td>
                            <td>{{ $first->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($first->return_date)->format('d/m/Y') }}</td>
                            <td>
                                @if ($first->fine)
                                    R$ {{ number_format($first->fine, 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection

@extends('layout.main')
@section('title', 'Todas as Reservas de Livros')

@section('content')

    <div class="page-header">
        <h1>Painel de Controle</h1>
    </div>

    <div class="dashboard-books-table">
        @if ($reservations->isEmpty())
            <p>Atualmente não há empréstimos de livros.</p>
        @else
            <p>Abaixo estão todos os empréstimos de livros, incluindo informações sobre multas, se houver.</p>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Usuário</th>
                        <th scope="col">Livro</th>
                        <th scope="col">Data de Devolução</th>
                        <th scope="col">Multa</th>
                        <th scope="col">Ver mais</th> <!-- New column for "View More" -->
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
                            <!-- New cell for "View More" -->
                            <td><a href="/livros/{{ $first->book->id }}"><i class="fa-regular fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection

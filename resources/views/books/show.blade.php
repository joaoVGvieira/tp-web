@extends('layout.main')
@section('title', $livro->title)
@section('content')
    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div class="col-md-4" id="img-container">
                {{-- Imagem da capa --}}
                <img src="/img/{{ $livro->image ? 'books/'.$livro->image : 'default-book-image.jpg' }}" alt="{{ $livro->title }}">
            </div>
            <div class="col-md-8" id="info-container">
                <h1 class="book-title">{{ $livro->title }}</h1>
                <p class="book-author"><i class="fa-solid fa-pen"></i> {{ $livro->author }}</p>
                <p class="book-genre"><i class="fa-solid fa-comments"></i> {{ $livro->genre }}</p>
                <p class="book-situation"><i class="fa-solid fa-lightbulb"></i> {{ $livro->situation }}</p>
                <div class="button-book">
                    @if ($livro->situation == 'Disponível')
                        <a href="/livros/reserva/{{ $livro->id }}" class="btn btn-success">Realizar reserva</a>
                    @else
                        <a class="btn btn-danger" disabled>Indisponível</a>
                        
                        @if(auth()->user()->is_admin)
                            <form action="/livros/devolver/{{ $livro->id }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning">Devolver Livro</button>
                            </form>
                        @endif

                        @php
                            $user = auth()->user();
                            $isOnWaitlist = \App\Models\Waitlist::where('users_id', $user->id)
                                ->where('books_id', $livro->id)
                                ->exists();
                        @endphp
                        
                        @if (!$isOnWaitlist && !auth()->user()->is_admin)
                            <form action="{{ route('books.waitlist', $livro->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-info">Entrar na Fila de Espera</button>
                            </form>
                        @elseif ($isOnWaitlist)
                            <a class="btn btn-secondary" disabled>Já na Fila de Espera</a>
                        @endif
                    @endif

                    @if(auth()->user()->is_admin)
                        <a href="/livros/{{ $livro->id }}/edit" class="btn btn-warning">Editar</a>
                        <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja apagar este livro?')">Apagar</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <p class="book-synopsis"><i class="fa-regular fa-circle-question"></i> {{ $livro->synopsis }}</p>
        </div>
    </div>
@endsection
@extends('layout.main')
@section('title', 'Editar Livro')
@section('content')

    @if (auth()->user()->is_admin == '0')
        <div class="page-header">
            <h1>Você não possui permissão para editar livros.</h1>
            <p>Por favor, entre em contato com o Administrador.</p>
        </div>
    @else
        <div class="page-header">
            <h1>Editar Livro</h1>
            <p>Atualize as informações abaixo para modificar o livro no sistema.</p>
        </div>

        <div class="edit-book-form">
            <form action="{{ route('books.update', $livro->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" class="form-control"
                        placeholder="Título completo da obra" value="{{ $livro->title }}">
                </div>
                <div class="form-group">
                    <label for="author">Autor</label>
                    <input type="text" name="author" id="author" class="form-control"
                        placeholder="Nome completo do Autor" value="{{ $livro->author }}">
                </div>
                <div class="form-group">
                    <label for="genre">Gênero</label>
                    <input type="text" name="genre" id="genre" class="form-control"
                        placeholder="Ex.: Terror, Ação, Aventura, Romance, etc" value="{{ $livro->genre }}">
                </div>
                <div class="form-group">
                    <label for="synopsis">Sinopse</label>
                    <textarea name="synopsis" id="synopsis" class="form-control" rows="2"
                        placeholder="Escreva uma breve sinopse do livro">{{ $livro->synopsis }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">Imagem da capa</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($livro->image)
                        <img src="{{ asset('/img/books/' . $livro->image) }}" alt="Capa do Livro" width="150">
                    @endif
                </div>
                <div class="form-group">
                    <label for="registration_number">Número de Registro</label>
                    <input type="text" name="registration_number" id="registration_number" class="form-control"
                        onkeypress="return checkNumber(event);" maxlength="5" placeholder="Insira apenas números" value="{{ $livro->registration_number }}">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
    @endif
@endsection

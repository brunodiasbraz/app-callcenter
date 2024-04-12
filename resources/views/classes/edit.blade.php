@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Aula</h2>
            <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('course.index') }}">Cursos</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none"
                        href="{{ route('classe.index', ['course' => $classe->course_id]) }}">Aulas</a>
                </li>
                <li class="breadcrumb-item active">Aula</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span>Editar</span>
                <span class="d-flex">

                    @can('index-classe')
                        <a href="{{ route('classe.index', ['course' => $classe->course_id]) }}"
                            class="btn btn-info btn-sm me-1"><i class="fa-solid fa-list"></i> Listar</a>
                    @endcan

                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <form action="{{ route('classe.update', ['classe' => $classe->id]) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-12">
                        <label for="name" class="form-label">Nome: </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome da aula"
                            value="{{ old('name', $classe->name) }}">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Descrição: </label>
                        <textarea name="description" rows="4" cols="30" id="description" class="form-control">{{ old('description', $classe->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit"class="btn btn-warning btn-sm me-1">Salvar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection





@extends('layouts.admin')

@section('content')

    <a href="{{ route('classe.index', ['course' => $classe->course_id]) }}">
        <button type="button">Listar</button>
    </a><br><br>

    <a href="{{ route('classe.show', ['classe' => $classe->id]) }}">
        <button type="button">Visualizar</button>
    </a><br><br>

    <h2>Editar a Aula</h2>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    <br>

    <form action="{{ route('classe.update', ['classe' => $classe->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome da aula"
            value="{{ old('name', $classe->name) }}"><br><br>

        <label>Descrição: </label>
        <textarea name="description" rows="4" cols="30" id="description">{{ old('description', $classe->description) }}</textarea><br><br>

        <button type="submit">Salvar</button>

    </form>
@endsection

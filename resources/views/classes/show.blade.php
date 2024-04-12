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
                <span>Listar</span>
                <span class="d-flex">

                    @can('index-classe')
                        <a href="{{ route('classe.index', ['course' => $classe->course_id]) }}"
                            class="btn btn-info btn-sm me-1"><i class="fa-solid fa-list"></i> Listar</a>
                    @endcan

                    @can('edit-classe')
                        <a href="{{ route('classe.edit', ['classe' => $classe->id]) }}" class="btn btn-warning btn-sm me-1"><i
                                class="fa-solid fa-pen-to-square"></i>Editar
                        </a>
                    @endcan

                    @can('destroy-classe')
                        <form id="formDelete{{ $classe->id }}" method="POST" action="{{ route('classe.destroy', ['classe' => $classe->id]) }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm me-1 btnDelete" data-delete-id="{{ $classe->id }}"><i
                                    class="fa-regular fa-trash-can"></i> Apagar</button>
                        </form>
                    @endcan

                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <dl class="row">

                    <dt class="col-sm-3">ID: </dt>
                    <dd class="col-sm-9">{{ $classe->id }}</dd>

                    <dt class="col-sm-3">Nome: </dt>
                    <dd class="col-sm-9">{{ $classe->name }}</dd>

                    <dt class="col-sm-3">Descrição: </dt>
                    <dd class="col-sm-9">{{ $classe->description }}</dd>

                    <dt class="col-sm-3">Ordem: </dt>
                    <dd class="col-sm-9">{{ $classe->order_classe }}</dd>

                    <dt class="col-sm-3">Curso: </dt>
                    <dd class="col-sm-9">{{ $classe->course->name }}</dd>

                    <dt class="col-sm-3">Cadastrado: </dt>
                    <dd class="col-sm-9">
                        {{ \Carbon\Carbon::parse($classe->created_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}
                    </dd>

                    <dt class="col-sm-3">Editado: </dt>
                    <dd class="col-sm-9">
                        {{ \Carbon\Carbon::parse($classe->updated_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}
                    </dd>

                </dl>
            </div>
        </div>
    </div>
@endsection

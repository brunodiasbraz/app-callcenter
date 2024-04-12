@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Papel</h2>
            <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('role.index') }}">Papéis</a>
                </li>
                <li class="breadcrumb-item active">Cadastrar</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span>Cadastrar</span>
                <span class="d-flex">

                    @can('index-classe')
                        <a href="{{ route('role.index') }}" class="btn btn-info btn-sm me-1"><i
                                class="fa-solid fa-list"></i> Listar</a>
                    @endcan

                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <form action="{{ route('role.store') }}" method="POST" class="row g-3">
                    @csrf
                    @method('POST')

                    <div class="col-12">
                        <label for="name" class="form-label">Nome: </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome do papel"
                            value="{{ old('name') }}">
                    </div>

                    <div class="col-12">
                        <button type="submit"class="btn btn-success btn-sm me-1">Cadastrar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

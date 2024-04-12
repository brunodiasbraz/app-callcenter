@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Ramais</h2>
            <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('ramais.index') }}">Ramais</a>
                </li>
                <li class="breadcrumb-item active">Listar Ramais</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span class="fw-bold">Pesquisar</span>
            </div>

            <div class="card-body">
                <form action="{{ route('user.index') }}">
                    <div class="row mb-3">

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label" for="name">Nome</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="" placeholder="Nome do usuário">
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label" for="email">Ramal</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="" placeholder="Ramal do usuário">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 col-sm-12">
                            <button type="submit" class="btn btn-info btn-sm"><i class="fa-solid fa-magnifying-glass"></i>
                                Pesquisa</button>
                            <a href="{{ route('user.index') }}" class="btn btn-warning btn-sm"><i
                                    class="fa-solid fa-trash"></i> Limpar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span class="fw-bold">Listar Ramais</span>
                <span>
                    @can('create-user')
                        <a href="{{ route('user.create') }}" class="btn btn-success btn-sm"><i
                                class="fa-regular fa-square-plus"></i> Cadastrar</a>
                    @endcan
                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Ramal</th>
                            <th>Endereço IP - Status</th>
                            <th class="d-none d-md-table-cell">Tipos de chamadas permitidas</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
           
                    </tbody>
                    </table>
                    <div class="alert alert-danger" role="alert">Nenhum ramal encontrado!</div>

            </div>
        </div>
    </div>
@endsection

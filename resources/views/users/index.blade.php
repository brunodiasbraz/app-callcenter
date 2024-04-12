@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Usuário</h2>
            <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span>Pesquisar</span>
            </div>

            <div class="card-body">
                <form action="{{ route('user.index') }}">
                    <div class="row mb-3">

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label" for="name">Nome</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $name }}" placeholder="Nome do usuário">
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label class="form-label" for="email">E-mail</label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ $email }}" placeholder="E-mail do usuário">
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 col-sm-12">
                            <label class="form-label" for="data_cadastro_inicio">Data Cadastro Início</label>
                            <input type="datetime-local" name="data_cadastro_inicio" id="data_cadastro_inicio"
                                class="form-control" value="{{ $data_cadastro_inicio }}">
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label class="form-label" for="data_cadastro_fim">Data Cadastro Fim</label>
                            <input type="datetime-local" name="data_cadastro_fim" id="data_cadastro_fim"
                                class="form-control" value="{{ $data_cadastro_fim }}">
                        </div>

                        <div class="col-md-4 col-sm-12 mt-4 pt-3">
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
                <span>Listar</span>
                <span>
                    @can('create-user')
                        <a href="{{ route('user.create') }}" class="btn btn-success btn-sm"><i
                                class="fa-regular fa-square-plus"></i> Cadastrar</a>
                    @endcan

                    @can('generate-pdf-user')
                        {{-- <a href="{{ route('user.generate-pdf') }}" class="btn btn-warning btn-sm"><i class="fa-regular fa-file-pdf"></i> Gerar PDF</a> --}}

                        <a href="{{ url('generate-pdf-user?' . request()->getQueryString()) }}"
                            class="btn btn-warning btn-sm"><i class="fa-regular fa-file-pdf"></i> Gerar PDF</a>
                    @endcan


                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th class="d-none d-md-table-cell">E-mail</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($users as $user)
                            <tr>
                                <th>{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                <td class="d-md-flex justify-content-center">

                                    @can('show-user')
                                        <a href="{{ route('user.show', ['user' => $user->id]) }}"
                                            class="btn btn-primary btn-sm me-1 mb-1">
                                            <i class="fa-regular fa-eye"></i> Visualizar
                                        </a>
                                    @endcan

                                    @can('edit-user')
                                        <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                            class="btn btn-warning btn-sm me-1 mb-1">
                                            <i class="fa-solid fa-pen-to-square"></i> Editar
                                        </a>
                                    @endcan

                                    @can('destroy-user')

                                        <form id="formDelete{{ $user->id }}" method="POST"
                                            action="{{ route('user.destroy', ['user' => $user->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm me-1 mb-1 btnDelete"
                                                data-delete-id="{{ $user->id }}"><i class="fa-regular fa-trash-can"></i>
                                                Apagar</button>
                                        </form>
                                    @endcan

                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">Nenhum usuário encontrado!</div>
                        @endforelse

                    </tbody>
                </table>

                {{ $users->onEachSide(0)->links() }}
                {{-- {{ $users->appends(request()->all())->onEachSide(0)->links() }} --}}

            </div>
        </div>
    </div>
@endsection

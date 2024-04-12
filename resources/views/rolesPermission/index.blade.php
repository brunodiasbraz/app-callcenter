@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Permissões do Papel - {{ $role->name }}</h2>
            <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('role.index') }}">Papéis</a></li>
                <li class="breadcrumb-item active">Papéis</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span>Pesquisar</span>
            </div>

            <div class="card-body">
                <form action="{{ route('role-permission.index', ['role' => $role->id]) }}">
                    <div class="row">

                        <div class="col-md-4 col-sm-12">
                            <label class="form-label" for="title">Título</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $title }}"
                                placeholder="Título da página">
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label class="form-label" for="name">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $name }}"
                                placeholder="Nome da página">
                        </div>

                        <div class="col-md-4 col-sm-12 mt-4 pt-3">
                            <button type="submit" class="btn btn-info btn-sm"><i class="fa-solid fa-magnifying-glass"></i>
                                Pesquisa</button>
                            <a href="{{ route('role-permission.index', ['role' => $role->id]) }}" class="btn btn-warning btn-sm"><i
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
                    @can('index-role')
                        <a href="{{ route('role.index') }}" class="btn btn-info btn-sm"><i class="fa-solid fa-list"></i>
                            Papéis</a>
                    @endcan
                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Nome</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($permissions as $permission)
                            <tr>
                                <th>{{ $permission->id }}</th>
                                <td>{{ $permission->title }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>

                                    @if (in_array($permission->id, $rolePermissions ?? []))
                                        <a
                                            href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                                            <span class="badge text-bg-success">Liberado</span>
                                        </a>
                                    @else
                                        <a
                                            href="{{ route('role-permission.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                                            <span class="badge text-bg-danger">Bloqueado</span>
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <div class="alert alert-danger" role="alert">Nenhuma permissão para o papel encontrado!</div>
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

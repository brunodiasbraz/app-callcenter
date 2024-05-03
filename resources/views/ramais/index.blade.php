@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 space-between-elements">
        <h2 class="ms-2 mt-3 me-3">Ramais</h2>
        <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
            <li class="breadcrumb-item"><a class="text-decoration-none"
                    href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Ramais</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header space-between-elements">
            <span class="fw-bold">Pesquisar</span>
        </div>

        <div class="card-body">
            <form action="{{ route('ramais.index') }}">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-4 col-sm-4">
                        <!-- <label class="form-label" for="email">Ramal</label> -->
                        <input type="text" name="email" id="email" class="form-control" value=""
                            placeholder="Ramal do usuário">
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <!-- <label class="form-label" for="name">Status</label> -->
                        <input type="text" name="name" id="name" class="form-control" value=""
                            placeholder="Status do Ramal">
                    </div>


                    <div class="col-md-4 col-sm-4">
                        <button type="submit" class="btn btn-info btn-sm mx-2"><i
                                class="fa-solid fa-magnifying-glass"></i>
                            Pesquisa</button>
                        <a href="{{ route('ramais.index') }}" class="btn btn-warning btn-sm"><i
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
                @can('create-ramais')
                <a href="{{ route('ramais.create') }}" class="btn btn-success btn-sm"><i
                        class="fa-regular fa-square-plus"></i> Cadastrar</a>
                @endcan
            </span>
        </div>
        <div class="card-body">

            <x-alert />

            @if (count($ramais) > 0)
            <table class="table table-sm table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Contexto</th>
                        <th>Disallow</th>
                        <th>Allow</th>
                        <th>Senha</th>
                        <th>DirectMedia</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ramais as $ramal)
                    <tr>
                        <td class="text-center">
                            @if ($ramal->status == 'logado')
                            <span class="badge rounded-pill text-bg-success">Logado</span>
                            @else
                            <span class="badge rounded-pill text-bg-danger">Deslogado</span>
                            @endif
                        </td>
                        <td>{{ $ramal->id }}</td>
                        <td>{{ $ramal->context }}</td>
                        <td>{{ $ramal->disallow }}</td>
                        <td>{{ $ramal->allow }}</td>
                        <td>{{ $ramal->password }}</td>
                        <td>{{ $ramal->direct_media }}</td>
                        <td class="d-md-flex justify-content-center">
                            <a href="#" class="edit-ramal-btn" data-bs-toggle="modal" data-bs-target="#editRamal"
                                data-ramal-id="{{ $ramal->id }}"><i class="fa fa-edit"></i></a>

                            @can('destroy-ramais')
                            <form id="formDelete{{ $ramal->id }}" method="POST"
                                action="{{ route('ramais.destroy', $ramal->id) }}">
                                @csrf
                                @method('delete')
                                <a type="submit" class="text-danger mx-2 btnDelete" data-delete-id="{{ $ramal->id }}"><i
                                        class="fa fa-trash"></i></a>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-danger" role="alert">Nenhum ramal encontrado!</div>
            @endif

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editRamal" tabindex="-1" aria-labelledby="editRamalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Ramal <span id="ramal-id"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                @method('GET')
                <form action="{{ route('ramais.edit') }}" method="GET">
                    <input type="hidden" name="ramal" id="ramal-input" value="">
                    <div class="mb-3">
                        <label for="maxContacts" class="form-label">Max Contacts</label>
                        <input type="text" name="maxContacts" id="maxContacts" class="form-control" placeholder="Ex.: 1"
                            value="{{ old('maxContacts') }}">
                    </div>
                    <div class="mb-3">
                        <label for="secretRamal" class="form-label">Senha</label>
                        <input type="text" name="secretRamal" id="secretRamal" class="form-control" placeholder="dialer"
                            value="{{ old('secretRamal') }}">
                    </div>
                    <div class="mb-3">
                        <label for="context" class="form-label">Contexto</label>
                        <input type="text" name="context" id="context" class="form-control"
                            placeholder="Insira o contexto" value="{{ old('context') }}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Captura o evento de clique nos botões de edição
    const editButtons = document.querySelectorAll('.edit-ramal-btn');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            // Recupera o ID do ramal da linha clicada
            const ramalId = button.getAttribute('data-ramal-id');
            // Atualiza o conteúdo do modal com o ID do ramal
            document.getElementById('ramal-id').textContent = ramalId;
            document.getElementById('ramal-input').value = ramalId;
        });
    });
});
</script>
@endsection
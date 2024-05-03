@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 space-between-elements">
        <h2 class="ms-2 mt-3 me-3">Troncos</h2>
        <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
            <li class="breadcrumb-item"><a class="text-decoration-none"
                    href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">PBX</li>
            <li class="breadcrumb-item active">Troncos</li>
        </ol>
    
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header space-between-elements">
            <span class="fw-bold">Listar</span>
            <span>
                @can('create-ramais')
                <a href="{{ route('ramais.create') }}" class="btn btn-success btn-sm"><i
                        class="fa-regular fa-square-plus"></i> Cadastrar</a>
                @endcan
            </span>
        </div>
        <div class="card-body">

            <x-alert />

            @if (count($trunks) > 0)
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Host</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trunks as $trunk)
                    <tr>
                        <td>{{ $trunk->id }}</td>
                        <td>{{ $trunk->match }}</td>
                        <td>
                            <a href="#" class="edit-trunk-btn" data-bs-toggle="modal" data-bs-target="#editTrunk"
                                data-trunk-id="{{ $trunk->id }}"><i class="fa fa-edit"></i></a>
                            
                                <a href="#"
                                onclick="return confirm('Tem certeza que deseja excluir este tronco?')"
                                class="text-danger mx-2"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-danger" role="alert">Nenhum tronco encontrado!</div>
            @endif

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editTrunk" tabindex="-1" aria-labelledby="editTrunkLabel" aria-hidden="true">
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
                        <input type="text" name="secretRamal" id="secretRamal" class="form-control"
                            placeholder="dialer" value="{{ old('secretRamal') }}">
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
    const editButtons = document.querySelectorAll('.edit-trunk-btn');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            // Recupera o ID do trunk da linha clicada
            const trunkId = button.getAttribute('data-trunk-id');
            // Atualiza o conteúdo do modal com o ID do ramal
            document.getElementById('trunk-id').textContent = trunkId;
            document.getElementById('trunk-input').value = trunkId;
        });
    });
});
</script>
@endsection
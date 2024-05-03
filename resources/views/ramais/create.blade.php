@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Ramais</h2>
            <ol class="breadcrumb mb-3 mt-3">
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('ramais.index') }}">Ramais</a></li>
                <li class="breadcrumb-item active">Criar Ramal</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-header space-between-elements">
                <span class="fw-bold">Cadastrar</span>
                <span class="d-flex">

                    @can('index-ramais')
                        <a href="{{ route('ramais.index') }}" class="btn btn-info btn-sm me-1"><i class="fa-solid fa-list"></i>
                            Listar</a>
                    @endcan

                </span>
            </div>
            <div class="card-body">

                <x-alert />

                <form action="{{ route('ramais.store') }}" method="POST" class="row g-3">
                    @csrf
                    @method('POST')
                    <!---Inserir na Tabela ps_aors--->
                    <div class="col-3">
                        <label for="ramal" class="form-label">Ramal: </label>
                        <input type="text" name="ramal" id="ramal" class="form-control" placeholder="Ex.: 1111"
                            value="{{ old('ramal') }}" maxlength="4">
                    </div>
                    <div class="col-3">
                        <label for="name" class="form-label">Max Contacts: </label>
                        <input type="text" name="maxContacts" id="maxContacts" class="form-control" placeholder="Ex.: 1"
                            value="{{ old('maxContacts') }}">
                    </div>
                    <!---Inserir na Tabela ps_auths--->
                    <div class="col-3">
                        <label for="secretRamal" class="form-label">Senha: </label>
                        <input type="text" name="secretRamal" id="secretRamal" class="form-control"
                            placeholder="dialer" value="{{ old('secretRamal') }}">
                        </div>
                        <!---Inserir na Tabela ps_endpoints--->
                        <div class="col-3">
                            <label for="context" class="form-label">Contexto: </label>
                            <input type="text" name="context" id="context" class="form-control"
                            placeholder="Insira o contexto" value="{{ old('context') }}">
                        </div>

                        <div class="col-12">
                        <button type="submit" class="btn btn-success bt-sm">Cadastrar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@extends('layouts.login')

@section('content')
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Área Restrita</h3>
                                </div>
                                <div class="card-body">

                                    <x-alert />

                                    <form action="{{ route('login.store-user') }}" method="POST">
                                        @csrf

                                        <div class="form-floating mb-3">
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Nome completo" value="{{ old('name') }}">
                                            <label for="name">Nome</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="E-mail de usuário" value="{{ old('email') }}">
                                            <label for="email">E-mail</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Senha" value="{{ old('password') }}">
                                            <label for="password">Senha</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a class="text-decoration-none"
                                            href="{{ route('login.index') }}">Clique aqui</a> para acessar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

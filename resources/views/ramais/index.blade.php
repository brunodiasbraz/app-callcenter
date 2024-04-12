@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 space-between-elements">
        <h2 class="ms-2 mt-3 me-3">Ramais</h2>
        <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
            <li class="breadcrumb-item active">Ramais</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-body">
            
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link disabled" id="listarRamal" href="#">Listar Ramais</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-reset" id="criarRamal" href="#">Criar Ramal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-reset" id="editarRamal" href="#">Editar Ramal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-reset" id="deletarRamal" href="#">Excluir Ramal</a>
                </li>
            </ul>
        </div>
    </div>
    <!----------Card para Criar Ramais--------->
    <div class="card d-block mb-4 border-light shadow" id="cardCriarRamal">
        <div class="card-header space-between-elements">
            <span class="fw-bold">Criar Ramal</span>
        </div>
        <div class="card-body">
            <div class="container col-sm-12 col-md-8">
                <form action="{{ route('ramais.create') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group my-4 col-sm-12 col-md-12">
                        <label for="">Conta Ramal Sip</label>
                        <input name="ramal_sip" type="text" class="form-control" id="" placeholder="Digite aqui a conta SIP." autofocus required>

                        <label for="">Senha :</label>
                        <input name="senha_ramal_sip" type="password" class="form-control" id="" placeholder="Digite aqui uma senha." required>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Permissão de chamadas</label>
                            <select name="contexto_ramal_sip" class="form-control" id="exampleFormControlSelect1">
                                <option value="phones">Chamadas internas(phones)</option>
                                <option value="phones-local">Chamadas Locais</option>
                                <option value="phones-local-celular">Chamadas Locais e Celular</option>
                                <option value="phones-ddd-fixo">Chamadas DDD Fixo</option>
                                <option value="phones-ddd-fixo-celular">Chamadas DDD fixo e celular</option>
                                <option value="phones-ddi">Chamadas DDI</option>
                            </select>
                        </div>


                        <label for="">Tipo de host Dynamic </label>
                        <input name="dinamic_static_ramal_sip" readonly="readonly" value="dynamic" type="text" class="form-control" id="" placeholder="">
                        <small class="form-text text-muted">Digite o ip ou dinamico .</small>
                        <button type="submit" class="mt-2 btn btn-primary col-sm-12 col-md-12">Criar</button>
                    </div>

                </form>
            </div>
            <x-alert />
        </div>
    </div>
    <!----------Fim Card para Criar Ramais--------->

    <!----------Card para Editar Ramais--------->
    <div class="card d-none mb-4 border-light shadow" id="cardEditarRamal">
        <div class="card-header space-between-elements">
            <span class="fw-bold">Editar Ramal</span>
        </div>
        <div class="card-body">
            <div class="container col-sm-12 col-md-8">
                <form action="{{ route('ramais.update') }}" method="GET">
                @csrf
                @method('GET')
                <div class="form-group col-sm-12 my-4 col-md-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label for="">Ramais Iniciados com ...</label>
                            <input name="rama_sip" type="text" class="form-control my-3" id=""  placeholder="Digite aqui..." autofocus >
                            <button type="submit" class="btn btn-primary col-sm-12 col-md-12">Editar ramal</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <x-alert />
        </div>
    </div>
    <!----------Fim Card para Editar Ramais--------->

    <!----------Card para Deletar Ramais--------->
    <div class="card d-none mb-4 border-light shadow" id="cardDeletarRamal">
        <div class="card-header space-between-elements">
            <span class="fw-bold">Deletar Ramal</span>
        </div>
        <div class="card-body">
            <div class="container col-sm-12 col-md-8">
                <form action="{{ route('ramais.delete') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group col-sm-12 my-4 col-md-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label for="">Ramais Iniciados com ...</label>
                            <input name="rama_sip" type="text" class="form-control my-3" id=""  placeholder="Digite aqui..." autofocus >
                            <button type="submit" class="btn btn-primary col-sm-12 col-md-12">Deletar Ramal</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <x-alert />
        </div>
    </div>
    <!----------Fim Card para Deletar Ramais--------->

</div>
<script>
        // Seleciona o link e a div
    const linkCriarRamal = document.getElementById('criarRamal');
    const linkEditarRamal = document.getElementById('editarRamal');
    const linkDelRamal = document.getElementById('deletarRamal');
    const divCardCriarRamal = document.getElementById('cardCriarRamal');
    const divCardEditarRamal = document.getElementById('cardEditarRamal');
    const divCardDelRamal = document.getElementById('cardDeletarRamal');

    // Adiciona um evento de clique ao link
    linkCriarRamal.addEventListener('click', function(event) {
        // Impede o comportamento padrão do link
        event.preventDefault();
        divCardEditarRamal.classList.add('d-none')
        divCardDelRamal.classList.add('d-none')
        // Verifica se a div está oculta
        if (divCardCriarRamal.classList.contains('d-none')) {
            // Se estiver oculta, remove a classe 'd-none' para mostrar a div
            divCardCriarRamal.classList.remove('d-none');
        } else {
            // Se estiver visível, adiciona a classe 'd-none' para ocultar a div
            divCardCriarRamal.classList.add('d-none');
        }
    });
    
    linkEditarRamal.addEventListener('click', function(event) {
        // Impede o comportamento padrão do link
        event.preventDefault();
        divCardCriarRamal.classList.add('d-none')
        divCardDelRamal.classList.add('d-none')
        // Verifica se a div está oculta
        if (divCardEditarRamal.classList.contains('d-none')) {
            // Se estiver oculta, remove a classe 'd-none' para mostrar a div
            divCardEditarRamal.classList.remove('d-none');
        } else {
            // Se estiver visível, adiciona a classe 'd-none' para ocultar a div
            divCardEditarRamal.classList.add('d-none');
        }
    });

    linkDelRamal.addEventListener('click', function(event) {
        // Impede o comportamento padrão do link
        event.preventDefault();
        divCardCriarRamal.classList.add('d-none')
        divCardEditarRamal.classList.add('d-none')
        // Verifica se a div está oculta
        if (divCardDelRamal.classList.contains('d-none')) {
            // Se estiver oculta, remove a classe 'd-none' para mostrar a div
            divCardDelRamal.classList.remove('d-none');
        } else {
            // Se estiver visível, adiciona a classe 'd-none' para ocultar a div
            divCardDelRamal.classList.add('d-none');
        }
    });
</script>
@endsection
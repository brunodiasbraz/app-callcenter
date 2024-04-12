@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="mb-1 space-between-elements">
        <h2 class="ms-2 mt-3 me-3">Entradas</h2>
        <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
            <li class="breadcrumb-item active">Entradas</li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-body">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Mailing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Blacklist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card mb-4 border-light shadow">
        <div class="card-header space-between-elements">
            <span class="fw-bold">Mailing</span>
        </div>
        <div class="card-body">
            <div class="container col-sm-12 my-4 col-md-8">
                <p>1 • Para subir um arquivo de mailing contendo vários números, basta fazer um upload do arquivo em formato CSV contendo o ID da campanha e o telefone no formato DDD+Número</p>
                <p><strong>Obs.: </strong>Este modelo será ajustado posteriormente.</p>
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 col-sm-12 my-4 col-md-12">
                        <input class="form-control form-control-sm" type="file" name="file" accept=".csv">
                    </div>
                    <button class="btn btn-outline-primary btn-sm px-4" type="submit">Enviar</button>
                </form>
                <x-alert />
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault();

        if (confirm("Tem certeza de que deseja enviar o mailing?")) {
            var formData = new FormData(this);

            fetch('/upload-entradas', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao processar a requisição.');
                    }
                    return response.text();
                })
                .then(data => {
                    Swal.fire({
                        title: 'Pronto!',
                        html: 'Seu mailing foi enviado com sucesso!',
                        icon: 'success'
                    });
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao processar a requisição.');
                });
        }
    });
</script>
@endsection
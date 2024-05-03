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
        <div class="card-header space-between-elements">
            <span class="fw-bold">Mailing</span>
        </div>
        <div class="card-body">
            <div class="container">
                <p>1 • Para subir um arquivo de mailing contendo vários números, basta fazer um upload do arquivo em formato CSV.</p>
                <p>2 • Após a mensagem de confirmação de carga será mostrado um seletor para informar em qual campanha deseja ativar o mailing, basta clicar na desejada e clicar no botão "Ativar mailing".</p>
                
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" type="file" name="file" accept=".csv" aria-label="Upload">
                        <button class="btn btn-outline-secondary" type="submit">Enviar</button>
                    </div>
                </form>
                <p class="text-secondary"><small><strong>Obs.: </strong>Modelo previamente alinhado com setores.</small></p>
                <div class="input-group d-none" id="selActiveCamp">
                     <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                        <option selected>Escolha uma campanha</option>
                        <option value="1">1 - Telecom</option>
                        <option value="2">2 - Enel</option>
                        <option value="3">3 - Cemig</option>
                    </select>
                <button class="btn btn-outline-secondary col-3" id="enviarBtn">Ativar mailing</button>
                </div>
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

                    document.getElementById("selActiveCamp").classList.remove("d-none");
                
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao processar a requisição.');
                });
        }
    });
    document.getElementById("enviarBtn").addEventListener("click", function() {
        // Obtém o valor selecionado no <select>
        var selectedValue = document.getElementById("inputGroupSelect04").value;
    
    // Verifica se um valor válido foi selecionado
    if (selectedValue !== "") {
        // Faz a requisição GET com o valor selecionado
        fetch("/api/hml/input-file/" + selectedValue)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao processar a requisição.');
                }
                return response.text();
            })
            .then(data => {
                Swal.fire({
                    title: 'Pronto!',
                    html: 'Sua requisição foi concluída com sucesso!',
                    icon: 'success'
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao processar a requisição.',
                    icon: 'error'
                });
            });
    } else {
        // Caso nenhum valor tenha sido selecionado, exibe uma mensagem de erro
        Swal.fire({
            title: 'Erro!',
            text: 'Por favor, escolha uma campanha antes de enviar.',
            icon: 'error'
        });
    }
    });
</script>
@endsection
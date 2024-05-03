@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="mb-1 space-between-elements">
            <h2 class="ms-2 mt-3 me-3">Canais Discando</h2>
            <ol class="breadcrumb mb-3 mt-3 p-1 rounded bg-light">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>

        <div class="card mb-4 border-light shadow">
            <div class="card-body">

                <x-alert />

                <div class="container-fluid my-3">                   
                         <div class="card-body">
                            <table id="dialingTable" class="table table-sm table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Campanha</th>
                                        <th>Nome Cliente</th>
                                        <th>CPF Cliente</th>
                                        <th>Telefone</th>
                                        <th>Data Entrada</th>
                                        <th>UniqueID</th>
                                    </tr>
                                </thead>
                                <tbody id="dialingTbody">
                                @forelse ($dialing as $dial)
                                    <tr>
                                        <td>@if($dial->status == 'Placing')
                                                Discando
                                            @endif
                                        </td>
                                        <td>
                                            @if($dial->id_campaign == 2)
                                                2 - Enel
                                            @elseif($dial->id_campaign == 3)
                                                3 - Cemig
                                            @endif
                                        </td>
                                        <td>{{ $dial->pessoa_nome }}</td>
                                        <td>{{ $dial->pessoa_cpf }}</td>
                                        <td>{{ $dial->phone }}</td>
                                        <td>{{ $dial->datetime_originate }}</td>
                                        <td>{{ $dial->uniqueid }}</td>
                                    </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7">Nenhuma chamada ativa!</td>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        // Função para atualizar a tabela a cada 2 segundos
        function updateTable() {
            // Fazer uma requisição AJAX
            $.ajax({
                url: "{{ route('dialing.refresh') }}", // Rota para a função que retorna os novos dados
                type: "GET",
                success: function(response) {
                    // Limpar o conteúdo atual da tabela
                    $('#dialingTbody').empty();
                    // Adicionar os novos dados à tabela
                    $('#dialingTbody').html(response);
                }
            });
        }

        // Atualizar a tabela a cada 2 segundos
        setInterval(updateTable, 2000); // 2000 milissegundos = 2 segundos
    </script>
@endsection

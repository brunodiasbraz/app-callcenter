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

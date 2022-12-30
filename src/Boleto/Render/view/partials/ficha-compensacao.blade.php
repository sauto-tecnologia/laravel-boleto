<table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
    <tbody>
    <tr>
        <td valign="bottom" colspan="8" class="noborder nopadding">
            <div class="logocontainer">
                <div class="logobanco">
                    <img src="{{ isset($logo_banco_base64) && !empty($logo_banco_base64) ? $logo_banco_base64 : 'https://dummyimage.com/150x75/fff/000000.jpg&text=+' }}" alt="logo do banco">
                </div>
                <div class="codbanco">{{ $codigo_banco_com_dv }}</div>
            </div>
            <div class="linha-digitavel">{{ $linha_digitavel }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="7" class="top-2">
            <div class="titulo">Local de pagamento</div>
            <div class="conteudo">{{ $local_pagamento }}</div>
        </td>
        <td width="180" class="top-2">
            <div class="titulo">Vencimento</div>
            <div class="conteudo rtl">{{ $data_vencimento->format('d/m/Y') }}</div>
        </td>
    </tr>
    <tr class="@if($mostrar_endereco_ficha_compensacao) duas-linhas @endif" style="vertical-align: top; height: 40px;">
        <td colspan="4">
            <div class="titulo">Beneficiário</div>
            <div class="conteudo">{{ $beneficiario['nome_documento'] }}</div>
            @if($mostrar_endereco_ficha_compensacao)<div class="conteudo">{{ $beneficiario['endereco_completo'] }}</div>@endif
        </td>
        <td colspan="3">
            <div class="titulo">Intermediador</div>
            <div class="conteudo">{{ $sacador_avalista['nome_documento'] }}</div>
            @if($mostrar_endereco_ficha_compensacao)<div class="conteudo">{{ $sacador_avalista['nome_documento'] }}</div>@endif
        </td>
        <td>
            <div class="titulo">Agência/Código Intermediador</div>
            <div class="conteudo rtl">{{ $agencia_codigo_beneficiario }}</div>
        </td>
    </tr>
    <tr>
        <td width="110" colspan="2">
            <div class="titulo">Data do documento</div>
            <div class="conteudo">{{ $data_documento->format('d/m/Y') }}</div>
        </td>
        <td width="120" colspan="2">
            <div class="titulo">Nº documento</div>
            <div class="conteudo">{{ $numero_documento }}</div>
        </td>
        <td width="60">
            <div class="titulo">Espécie doc.</div>
            <div class="conteudo">{{ $especie_doc }}</div>
        </td>
        <td>
            <div class="titulo">Aceite</div>
            <div class="conteudo">{{ $aceite }}</div>
        </td>
        <td width="110">
            <div class="titulo">Data processamento</div>
            <div class="conteudo">{{ $data_processamento->format('d/m/Y') }}</div>
        </td>
        <td>
            <div class="titulo">Nosso número</div>
            <div class="conteudo rtl">{{ $nosso_numero_boleto }}</div>
        </td>
    </tr>
    <tr>
        @if(!isset($esconde_uso_banco) || !$esconde_uso_banco)
            <td {{ !isset($mostra_cip) || !$mostra_cip ? 'colspan=2' : ''}}>
                <div class="titulo">Uso do banco</div>
                <div class="conteudo">{{ $uso_banco }}</div>
            </td>
            @endif
            @if (isset($mostra_cip) && $mostra_cip)
                    <!-- Campo exclusivo do Bradesco -->
            <td width="20">
                <div class="titulo">CIP</div>
                <div class="conteudo">{{ $cip }}</div>
            </td>
        @endif

        <td {{isset($esconde_uso_banco) && $esconde_uso_banco ? 'colspan=3': '' }}>
            <div class="titulo">Carteira</div>
            <div class="conteudo">{{ $carteira_nome }}</div>
        </td>
        <td width="35">
            <div class="titulo">Espécie</div>
            <div class="conteudo">{{ $especie }}</div>
        </td>
        <td colspan="2">
            <div class="titulo">Quantidade</div>
            <div class="conteudo"></div>
        </td>
        <td width="110">
            <div class="titulo">Valor</div>
            <div class="conteudo">R$ {{ $valor }}</div>
        </td>
        <td>
            <div class="titulo">(=) Valor do Documento</div>
            <div class="conteudo rtl">R$ {{ $valor }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="@if ($qrcode && !!$collection) 6 @else 7 @endif">
            <div class="titulo">Instruções de responsabilidade do beneficiário. Qualquer dúvida sobre este boleto, contate o beneficiário</div>
        </td>

        @if ($qrcode && !!$collection)
        <td colspan="1" rowspan="4">
            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="{{ env('APP_API_URL').'v1/qrcode?text='.urlencode($qrcode) }}" width="100px" height="100px" alt="">
            </div>
        </td>
        @endif

        <td>
            <div class="titulo">(-) Descontos / Abatimentos</div>
            <div class="conteudo rtl"></div>
        </td>
    </tr>
    <tr>
        <td colspan="@if ($qrcode && !!$collection) 6 @else 7 @endif" class="notopborder">
            @if ($desconto)
            <div class="conteudo">Desconto de R$ {{ $desconto }} até o vencimento</div>
            @endif

            @if ($multa || $juros)
            <div class="conteudo">
                Sujeito a
                
                @if ($multa)
                multa de R$ {{ $multa }}
                @endif 

                @if ($multa && $juros) e @endif

                @if ($juros)
                juros de {{ $juros }}%
                @endif

                após o vencimento
            </div>
            @endif
        </td>
        <td>
            <div class="titulo">(-) Outras deduções</div>
            <div class="conteudo rtl"></div>
        </td>
    </tr>
    <tr>
        <td colspan="@if ($qrcode && !!$collection) 6 @else 7 @endif" class="notopborder">
            <div class="conteudo">{{ $instrucoes[0] }}</div>
            <div class="conteudo">{{ $descricao }}</div>
        </td>
        <td>
            <div class="titulo">(+) Mora / Multa {{ $codigo_banco == '104' ? '/ Juros' : '' }}</div>
            <div class="conteudo rtl"></div>
        </td>
    </tr>
    <tr>
        <td colspan="@if ($qrcode && !!$collection) 6 @else 7 @endif" class="notopborder">
            <div class="conteudo">{{ $instrucoes[6] }}</div>
            <div class="conteudo">{{ $instrucoes[7] }}</div>
        </td>
        <td>
            <div class="titulo">(=) Valor cobrado</div>
            <div class="conteudo rtl"></div>
        </td>
    </tr>
    <tr>
        <td colspan="@if ($qrcode && !!$collection) 6 @else 7 @endif">
            <div class="titulo">Pagador</div>
            <div class="conteudo">{{ $pagador['nome_documento'] }}</div>
            <div class="conteudo">{{ $pagador['endereco'] }}</div>
            <div class="conteudo">{{ $pagador['endereco2'] }}</div>

        </td>

        @if ($qrcode && !!$collection)
        <td class="noleftborder" colspan="1" rowspan="1"></td>
        @endif

        <td class="noleftborder">
            <div class="titulo" style="margin-top: 50px">Cód. Baixa</div>
        </td>
    </tr>

    <tr>
        <td colspan="@if ($qrcode && !!$collection) 6 @else 7 @endif" class="noleftborder">
            <div class="titulo">Intermediador
                <div class="conteudo sacador">{{ $sacador_avalista ? $sacador_avalista['nome_documento'] : '' }}</div>
            </div>
        </td>
        <td colspan="2" class="norightborder noleftborder">
            <div class="conteudo noborder rtl">Autenticação mecânica - Ficha de Compensação</div>
        </td>
    </tr>

    <tr>
        <td colspan="7" class="noborder" style="padding-top: 10px;">
            {!! $codigo_barras !!}
        </td>

        <td colspan="1" class="noborder rtl" style="padding-top: 10px;">
            @if ($qrcode && !!!$collection)
                <div style="display: flex; justify-content: end; font-family: Arial, sans-serif; font-size: 11px; margin-bottom: 5px; font-weight: bold; margin-right: 14px;">Pague via Pix</div>
                <img src="{{ env('APP_API_URL').'v1/qrcode?text='.urlencode($qrcode) }}" alt="">
            @endif
        </td>

    </tr>

    </tbody>
</table>
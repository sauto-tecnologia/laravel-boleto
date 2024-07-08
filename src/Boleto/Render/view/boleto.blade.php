@extends('BoletoHtmlRender::layout')
@section('boleto')

    @foreach($boletos as $i => $boleto)
        @php extract($boleto, EXTR_OVERWRITE); @endphp
        @if($mostrar_instrucoes)
            <div class="noprint info">
                <h2>Instruções de Impressão</h2>
                <ul>
                    @forelse ($instrucoes_impressao as $instrucao_impressao)
                        <li>{{ $instrucao_impressao }}</li>
                    @empty

                        <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use
                            modo econômico).
                        </li>
                        <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à
                            direita do formulário.
                        </li>
                        <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o
                            código de barras.
                        </li>
                        <li>Caso não apareça o código de barras no final, pressione F5 para atualizar esta tela.</li>
                        <li>Caso tenha problemas ao imprimir, copie a sequencia numérica abaixo e pague no caixa
                            eletrônico ou no internet banking:
                        </li>
                    @endforelse
                </ul>
                <span class="header">Linha Digitável: {{ $linha_digitavel }}</span>
                <span class="header">Número: {{ $numero }}</span>
                {!! $valor ? '<span class="header">Valor: R$' . $valor . '</span>' : '' !!}
                <br>
            </div>
        @endif

        <div class="linha-pontilhada" style="margin-bottom: 15px;">Recibo do pagador</div>

        @if ($qrcode)
            <div style="display: flex; justify-content: end; font-family: Arial, sans-serif; font-size: 11px; margin-bottom: 5px; font-weight: bold; margin-right: 14px;">Pague via Pix</div>
        @endif

        <div style="display: flex; justify-content: space-between; align-items: flex-end;">

            <div class="info-empresa">
                @if ($logo)
                    <div style="display: inline-block;">
                        <img alt="logo" style="max-width: 120px; max-height: 60px;" src="{{ $logo_base64 }}"/>
                    </div>
                @endif
                <div style="display: inline-block; vertical-align: super; margin-left: 16px;">
                    <div style="text-transform: uppercase;"><strong>{{ $beneficiario['nome'] }}</strong></div>
                    <div>{{ $beneficiario['documento'] }}</div>
                    <div>{{ $beneficiario['endereco'] }}</div>
                    <div>{{ $beneficiario['endereco2'] }}</div>
                </div>

            </div>
            <div style="display: flex; justify-content: end; vertical-align: super; margin-left: 16px;">

                @if ($qrcode)

                    <img src="{{ env('APP_API_URL').'v1/qrcode?s=150&type=svg&text='.urlencode($qrcode) }}" width="150px" height="150px">

                @endif

            </div>
        </div>

        <br>

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
                <td colspan="2" width="250" class="top-2">
                    <div class="titulo">Intermediador</div>
                    <div class="conteudo">{{ $sacador_avalista['nome'] }}</div>
                </td>
                <td class="top-2">
                    <div class="titulo">CPF/CNPJ</div>
                    <div class="conteudo">{{ $sacador_avalista['documento'] }}</div>
                </td>
                <td width="120" class="top-2">
                    <div class="titulo">Ag/Cod. Intermediador</div>
                    <div class="conteudo rtl">{{ $agencia_codigo_beneficiario }}</div>
                </td>
                <td width="120" class="top-2">
                    <div class="titulo">Vencimento</div>
                    <div class="conteudo rtl">{{ $data_vencimento->format('d/m/Y') }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="titulo">Beneficiário</div>
                    <div class="conteudo">{{ $beneficiario['nome_documento'] }}</div>
                </td>
                <td>
                    <div class="titulo">Nº documento</div>
                    <div class="conteudo rtl">{{ $numero_documento }}</div>
                </td>
                <td>
                    <div class="titulo">Nosso número</div>
                    <div class="conteudo rtl">{{ $nosso_numero_boleto }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="titulo">Pagador</div>
                    <div class="conteudo">{{ $pagador['nome_documento'] }} </div>
                </td>
                <td>
                    <div class="titulo">(-) Descontos / Abatimentos</div>
                    <div class="conteudo rtl"></div>
                </td>
                <td>
                    <div class="titulo">(=) Valor Documento</div>
                    <div class="conteudo rtl">R$ {{ $valor }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="titulo">Espécie</div>
                    <div class="conteudo">{{ $especie }}</div>
                </td>
                <td>
                    <div class="titulo">Quantidade</div>
                    <div class="conteudo rtl"></div>
                </td>
                <td>
                    <div class="titulo">Valor</div>
                    <div class="conteudo rtl">R$ {{ $valor }}</div>
                </td>
                <td>
                    <div class="titulo">(+) Outros acréscimos</div>
                    <div class="conteudo rtl"></div>
                </td>
                <td>
                    <div class="titulo">(-) Outras deduções</div>
                    <div class="conteudo"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="conteudo"></div>
                    <div class="titulo">Demonstrativo</div>
                </td>
                <td>
                    <div class="titulo">(+) Mora / Multa</div>
                    <div class="conteudo rtl"></div>
                </td>
                <td>
                    <div class="titulo">(=) Valor cobrado</div>
                    <div class="conteudo rtl"></div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-top: 10px" class="conteudo">{{ $descricao }}</div>
                </td>
                <td class="noleftborder">
                    <div class="titulo">Autenticação mecânica</div>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="notopborder">
                    <div class="conteudo">{{ $demonstrativo[0] }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="notopborder bottomborder">
                    <div style="margin-bottom: 10px;" class="conteudo">{{ $demonstrativo[1] }}</div>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="linha-pontilhada">Corte na linha pontilhada</div>
        <br>

        <!-- Ficha de compensação -->
        @include('BoletoHtmlRender::partials/ficha-compensacao', ['collection' => false])

        @if(count($boletos) > 1 && count($boletos)-1 != $i)
            <div style="page-break-before:always"></div>
        @endif
    @endforeach
@endsection

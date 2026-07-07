@php
    setlocale(LC_ALL, 'es_ES');
    \Carbon\Carbon::setLocale('es');
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura N° {{ $numeroFactura }} | Consultar Guía de Transporte | Avícola el Madroño</title>
    <style type="text/css">
        * {
            font-family: Arial, Verdana, sans-serif;
        }

        html {
            margin:25px;
        }

        table {
            font-size: 10px;
            border-collapse: collapse;
        }

        table.bordered td, table.bordered th {
            border: solid 0.5px #000;
        }

        span {
            font-weight: 700;
            font-size: 7px;
        }

        p {
            margin: 0;
        }

        h3 {
            margin: 0;
        }

        tfoot tr td{
            font-weight: bold;
            font-size: 10px;
        }

        td, th {
            padding-left: 5px;
            padding-right: 5px;
        }

        .bold {
            font-weight: 700;
        }

        table.bordered {
            border-radius: 5px;
            border-style: hidden; /* hide standard table (collapsed) border */
            box-shadow: 0 0 0 1px #000; /* this draws the table border  */
        }

        table.bordered thead tr td, table.bordered thead tr th {
            border-bottom: solid 1px #000000;
            background-color: #f2f2f2;
            height: 30px;
        }

        table.border-bottom td, table.border-bottom th {
            border-bottom: solid 1px #000000;
            background-color: #fff;
        }

        #firmas {
            table-layout: fixed;
        }

        #firmas div {
            border-bottom: solid 1px #000;
            padding-top: 5px;
            padding-bottom: 5px;
            min-height: 40px;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .center {
            text-align: center;
        }

        .fz-10 {
            font-size: 8px!important;
        }

        .fz-12 {
            font-size: 12px!important;
        }

        .gray {
            background-color: lightgray
        }

        .logo {
            height: 50px;
            margin: 0;
        }

        .right {
            text-align: right;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .valign-top td, .valign-top th {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <table width="100%" class="valign-top" style="margin-bottom: 15px;">
        <tr>
            <td width="130px">
                <img class="logo" src="{{ asset('imagenes/logos/madrono-logo.png') }}" alt="{{ 'Logo ' . $empresa->logo }}">
            </td>
            <td>
                <table width="100%" style="margin: 0;">
                    <tr>
                        <th class="center">
                            <h3 style=" margin: 0; font-size: 14px;">GUÍA DE TRANSPORTE</h3>
                        </th>
                        <th class="center"></th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Compañia: {!! $cop->nit ? $cop->nit : '&nbsp;' !!}, {!! $cop->razon_social ? $cop->razon_social : '&nbsp;' !!}</td>
                        <td class="center">Codigo: 02PR-F18 Version: 02</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Dirección: {!! $cop->direccion ? $cop->direccion : '&nbsp;' !!}</td>
                        <td class="center"><b>Numero de Guia:</b></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">Ciudad: {!! $cop->ciudad ? $cop->ciudad : '&nbsp;' !!}, {!! $cop->departamento ? $cop->departamento : '&nbsp;' !!}</td>
                        <td class="center"><b>{{ $numeroFactura }}</b></td>
                    </tr>
                </table>
            </td>
            <td width="130px" style="text-align: right;">
                <img src="data:{{ $qrCode->getContentType().';base64,'.$qrCode->generate() }}" alt="">
            </td>
        </tr>
    </table>
    <table width="100%" class="valign-top border-bottom" style="border-bottom: solid 1px black;">
        <tr>
            <td>
                <b>Fecha de Expedición:</b> {{ $hoy->format('d/m/Y') }}
            </td>
            <td>
                <b>Código Inscripción INVIMA:</b> {!! $cop->codinvima ? $cop->codinvima : '&nbsp;' !!}
            </td>
            <td>
                <b>Marca Comercial: {!! $cop->marca ? mb_strtoupper($cop->marca) : '&nbsp;' !!}</b>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Dirección del Establecimiento:</b> {!! $cop->direccion_establecimiento ? $cop->direccion_establecimiento : '&nbsp;' !!}
            </td>
        </tr>
        <tr>
            <td>
                <b>Especie:</b> {!! $cop->especie ? $cop->especie : '&nbsp;' !!}
            </td>
            <td colspan="2">
                <b>Dictámen de Productos:</b> {!! $cop->dictamen ? $cop->dictamen : '&nbsp;' !!}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Cliente Destino:</b> {!! $guia->NIT || $guia->NOMCLIENTE ? trim($guia->NIT) . ', ' . trim($guia->NOMCLIENTE) : '&nbsp;' !!}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Dirección Destino:</b> {!! $guia->DIRCLIENTE ? trim($guia->DIRCLIENTE) : '&nbsp;' !!}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Ciudad Destino:</b> {!! $guia->CIUDAD ? trim($guia->CIUDAD) : '&nbsp;' !!}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Departamento Destino:</b> {!! $guia->CIUDAD ? trim($guia->CIUDAD) : '&nbsp;' !!}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Temperatura Despacho:</b> {!! $cop->temperatura ? $cop->temperatura : '&nbsp;' !!}
            </td>
            <td>
                <b>Hora Despacho:</b> {{ \Carbon\Carbon::parse($guia->FECHASAL)->format('H:i:s') }}
            </td>
        </tr>
    </table>
    <table width="100%" class="valign-top border-bottom">
        <thead>
            <tr>
                <th class="fz-10">PRODUCTO</th>
                <th class="fz-10">DETALLE</th>
                <th class="fz-10">UNIDADES</th>
                <th class="fz-10">PESO EN KILOS</th>
                <th class="fz-10">LOTE</th>
                <th class="fz-10">FECHA DE PRODUCCION</th>
                <th class="fz-10">VENCIMIENTO</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cargue as $key => $ITEM)
                <tr>
                    <td>{{ trim($ITEM->CODIGO) }}</td>
                    <td>{{ trim($ITEM->NOMBRE) }}</td>
                    <td class="center">{{ trim(number_format($ITEM->CANTEMPAQ, 2, '.', '')) }}</td>
                    <td class="center">{{ trim(number_format($ITEM->CANTIDAD, 2, '.', '')) }}</td>
                    <td>{{ trim($ITEM->CODLOTE) }}</td>
                    <td class="center">{{ trim(\Carbon\Carbon::parse($ITEM->FECPROD)->format('d/m/Y')) }}</td>
                    <td>{{ trim(\Carbon\Carbon::parse($ITEM->FECVENCE)->format('d/m/Y')) }}</td>
                </tr>
            @empty
                <tr>
                    <th class="center" scope="row" colspan="7">No hay productos</th>
                </tr>
            @endforelse
        </tbody>
    </table>
    <table width="100%" class="valign-top">
        <tbody>
            <tr>
                <td>
                    <b>Placa del Vehículo: </b>{!! trim($guia->PLACA) ? mb_strtoupper($guia->PLACA) : '&nbsp;' !!}
                </td>
                <td>
                    <b>Conductor: </b>{!! trim($guia->CONDUC) || trim($guia->NOMCOND) ? trim($guia->CONDUC) . ', ' . trim($guia->NOMCOND) : '&nbsp;' !!}
                </td>
                <td>
                    <b>Transportador: </b>{!! trim($guia->NITTRASP) || trim($guia->NOMEMPRESA) ? trim($guia->NITTRASP) . ', ' . trim($guia->NOMEMPRESA) : '&nbsp;' !!}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: solid 1px black;">
                    <b>Observación:</b> {!! trim($guia->OBSERVAC) !!}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%" class="left" style="margin-bottom: 15px;" id="firmas">
        <tr>
            <td>Médico Veterinario</td>
            <td>Aseguramiento de Calidad</td>
            <td>Cliente</td>
            <td></td>
        </tr>
        <tr>
            <td style="vertical-align: bottom;">
                <div>
                    @if ($cop->firma_veterinario)
                        <img style="width: 120px" src="{{ $cop->firma_veterinario }}" alt="{{ 'Firma ' . $cop->nombre_veterinario }}">
                    @endif
                </div>
            </td>
            <td style="vertical-align: bottom;">
                <div>
                    @if ($cop->firma_despachos)
                        <img style="width: 120px" src="{{ $cop->firma_despachos }}" alt="{{ 'Firma ' . $cop->nombre_despachos }}">
                    @endif
                </div>
            </td>
            <td style="vertical-align: bottom;">
                <div></div>
            </td>
            <td style="vertical-align: bottom;">
                <div></div>
            </td>
        </tr>
        <tr>
            <td>{!! $cop->nombre_veterinario ? $cop->nombre_veterinario : '&nbsp;' !!}</td>
            <td>{!! $cop->nombre_despachos ? $cop->nombre_despachos : '&nbsp;' !!}</td>
            <td>{!! $guia->NOMCLIENTE ? mb_convert_case(trim($guia->NOMCLIENTE), MB_CASE_TITLE, "UTF-8") : '&nbsp;' !!}</td>
            <td>Hora de Entrega</td>
        </tr>
    </table>
</body>
</html>

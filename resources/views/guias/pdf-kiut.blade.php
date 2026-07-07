@php
    setlocale(LC_ALL, 'es_ES');
    \Carbon\Carbon::setLocale('es');
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Factura N° {{ mb_strtoupper($factura) }} | Consultar Guía de Transporte | Avícola el Madroño</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
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

        .fz-12 {
            font-size: 12px!important;
        }

        .gray {
            background-color: lightgray
        }
        
        .logo {
            height: 70px;
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
    <table width="100%" style="margin-bottom: 15px;">
        <tr>
            <th class="center" rowspan="2"><img class="logo" src="{{ asset($empresa->logo) }}" alt="{{ 'Logo ' . $empresa->logo }}"></th>
            <th class="center">
                <h3 style="font-size: 20px;">GUÍA DE TRANSPORTE</h3>
                <h3 style="font-size: 15px;">FACTURA N° {{ mb_strtoupper($factura) }}</h3>
            </th>
            <th class="center" rowspan="2"><img src="data:{{ $qrCode->getContentType().';base64,'.$qrCode->generate() }}" alt=""></th>
        </tr>
        <tr>
            <td class="center" style="vertical-align: top; padding-top: 5px;">
                <p>
                    {!! $cop->nit ? $cop->nit : '&nbsp;' !!}, {!! $cop->razon_social ? $cop->razon_social : '&nbsp;' !!}<br>
                    {!! $cop->direccion ? $cop->direccion : '&nbsp;' !!}<br>
                    CIUDAD: {!! $cop->ciudad ? $cop->ciudad : '&nbsp;' !!} - DEPARTAMENTO: {!! $cop->departamento ? $cop->departamento : '&nbsp;' !!}<br>
                    TELÉFONO: {!! $cop->telefono ? $cop->telefono : '&nbsp;' !!}
                </p>
            </td>
        </tr>
    </table>
    <div style="border-radius: 5px; border: solid 1px #000;">
        <table width="100%" class="bordered valign-top">
            <tr>
                <td>
                    <span>Fecha de Expedición</span>
                    <p>{{ mb_convert_case($hoy->dayName, MB_CASE_TITLE, "UTF-8") .', '. $hoy->day . ' de '. ucfirst($hoy->monthName) . ' del '. $hoy->year }}</p>
                </td>
                <td>
                    <span>Código Inscripción INVIMA</span>
                    <p>{!! $cop->codinvima ? $cop->codinvima : '&nbsp;' !!}</p>
                </td>
                <td>
                    <span>Marca Comercial</span>
                    <p class="bold">{!! $cop->marca ? mb_strtoupper($cop->marca) : '&nbsp;' !!}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <span>Dirección del Establecimiento</span>
                    <p>{!! $cop->direccion_establecimiento ? $cop->direccion_establecimiento : '&nbsp;' !!}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Especie</span>
                    <p>{!! $cop->especie ? $cop->especie : '&nbsp;' !!}</p>
                </td>
                <td colspan="2">
                    <span>Dictámen de Productos</span>
                    <p>{!! $cop->dictamen ? $cop->dictamen : '&nbsp;' !!}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <span>Cliente Destino</span>
                    <p>{!! $guia->NIT || $guia->NOMCLIENTE ? trim($guia->NIT) . ', ' . trim($guia->NOMCLIENTE) : '&nbsp;' !!}</p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <span>Dirección Destino</span>
                    <p>{!! $guia->DIRCLIENTE ? trim($guia->DIRCLIENTE) : '&nbsp;' !!}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span>Temperatura de Despacho</span>
                    <p>{!! $cop->temperatura ? $cop->temperatura : '&nbsp;' !!}</p>
                </td>
                <td>
                    <span>Hora de Despacho</span>
                    <p>
                        {{ mb_convert_case(\Carbon\Carbon::parse($guia->FECHASAL)->dayName, MB_CASE_TITLE, "UTF-8") .', '. \Carbon\Carbon::parse($guia->FECHASAL)->day . ' de '. ucfirst(\Carbon\Carbon::parse($guia->FECHASAL)->monthName) . ' del '. \Carbon\Carbon::parse($guia->FECHASAL)->year }}<br>
                        {{ \Carbon\Carbon::parse($guia->FECHASAL)->format('h:i:s a') }}
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Placa del Vehículo</span>
                    <p>{!! trim($guia->PLACA) ? mb_strtoupper($guia->PLACA) : '&nbsp;' !!}</p>
                </td>
                <td>
                    <span>Conductor</span>
                    <p>{!! trim($guia->CONDUC) || trim($guia->NOMCOND) ? trim($guia->CONDUC) . ', ' . trim($guia->NOMCOND) : '&nbsp;' !!}</p>
                </td>
                <td>
                    <span>Transportador</span>
                    <p>{!! trim($guia->NITTRASP) || trim($guia->NOMEMPRESA) ? trim($guia->NITTRASP) . ', ' . trim($guia->NOMEMPRESA) : '&nbsp;' !!}</p>
                </td>
            </tr>
        </table>
    </div>
    <br/>
    <div style="border-radius: 5px; border: solid 1px #000; overflow: hidden;">
        <table width="100%" class="bordered">
            <thead style="background-color: lightgray; border-top-left-radius: 5px;">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Lote</th>
                    <th scope="col">Fecha de<br>Producción</th>
                    <th scope="col">Fecha de<br>Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guia->ITEMS as $key => $ITEM)
                    <tr>
                        <th scope="row">{{ $ITEM->CODIGO }}</th>
                        <td>{{ $ITEM->NOMBRE }}</td>
                        <td class="center">{{ number_format($ITEM->CANTEMPAQ, 0, ',', '.') }}</td>
                        <td class="right">{{ number_format($ITEM->CANTIDAD, 3, ',', '.') }} Kg</td>
                        <td class="center">{{ $ITEM->CODLOTE }}</td>
                        <td class="capitalize">
                            <span>
                                @switch(\Carbon\Carbon::parse($ITEM->FECPROD)->startOfDay()->diffInDays($hoy->startOfDay(), false))
                                    @case(0)
                                        Hoy
                                        @break
                                    @case(1)
                                        Ayer
                                        @break
                                    @default
                                        {{ \Carbon\Carbon::parse($ITEM->FECPROD)->dayName }}
                                @endswitch
                            </span>
                            <br>
                            {{ \Carbon\Carbon::parse($ITEM->FECPROD)->format('d') . '/'. ucfirst(mb_substr(\Carbon\Carbon::parse($ITEM->FECPROD)->monthName, 0, 3)) . '/'. \Carbon\Carbon::parse($ITEM->FECPROD)->year }}
                        </td>
                        <td class="capitalize">
                            <span>
                                @switch(\Carbon\Carbon::parse($ITEM->FECVENCE)->startOfDay()->diffInDays($hoy->startOfDay(), false))
                                    @case(0)
                                        Hoy
                                        @break
                                    @case(1)
                                        Ayer
                                        @break
                                    @default
                                        {{ \Carbon\Carbon::parse($ITEM->FECVENCE)->dayName }}
                                @endswitch
                            </span>
                            <br>
                            {{ \Carbon\Carbon::parse($ITEM->FECVENCE)->format('d') . '/'. ucfirst(mb_substr(\Carbon\Carbon::parse($ITEM->FECVENCE)->monthName, 0, 3)) . '/'. \Carbon\Carbon::parse($ITEM->FECVENCE)->year }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th class="center" scope="row" colspan="7">No hay productos</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <table width="100%" class="left" style="margin-bottom: 15px;" id="firmas">
        <tr>
            <td>Médico Veterinario</td>
            <td>Jefe de Despachos</td>
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
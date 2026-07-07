@php
    $empresa = \App\Models\TblEmpresa::first();
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Impresion de Pedidos</title>
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" />

    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            font-size:small;
            margin: 0px;
        }
        br {
            font-size: 1px;
        }
        hr {
            border-top-width: 1px;
            border-right-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px;
            border-top-style: solid;
            border-right-style: none;
            border-bottom-style: none;
            border-left-style: none;
            border-top-color: #CCCCCC;
            border-right-color: #CCCCCC;
            border-bottom-color: #CCCCCC;
            border-left-color: #CCCCCC;
        }
        fieldset {
            border: 1px solid #333333;
        }
        .tbl_reporte {
            border: 1px solid #000000;
        }
        .tbl_lista {
            border: 1px dashed #000000;
            border-collapse:collapse;
        }
        .td_lista {
            border-bottom-width: 1px;
            border-left-width: 1px;
            border-bottom-style: dashed;
            border-left-style: dashed;
            border-bottom-color: #000;
            border-left-color: #000;
            border-top-style: dashed;
            border-right-style: dashed;
            border-top-width: 1px;
            border-right-width: 1px;
        }
        .td_firma {
            border-top-width: 1px;
            border-top-style: solid;
            border-top-color: #000;
            font-size: 14px;
        }
        .SaltoDePagina
        {
            PAGE-BREAK-AFTER: always;
            margin: 20px;
        }

        h1, h2, h3, p {
            margin: 0px;
        }

        h1 {
            font-size: 22px;
            line-height: 30px;
        }

        label {
            font-size: 10px;
            line-height: 10px;
            margin-bottom: 3px;
        }

        h3, .title-3 {
            font-size: 16px;
            line-height: 16px;
        }

        body {
            width: 776px;
            margin: 20px;
        }

        .row {
            display: block;
            width: 100%;
            margin-top: 10px;
        }

        .row > div {
            display: inline-block;
        }

        .cols-1 {
            width: 100%;
        }

        .cols-5 {
            width: 20%;
        }

        .col.12 {
            width: 100%;
        }

        .center {
            text-align: center;
        }

        td {
            font-size: 14px;
            vertical-align: top;
        }

        .totales > td {
            font-size: 16px;
        }

        .fila_producto td {
            font-size: 12px;
        }

        @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }
    </style>
</head>
<body>
    @foreach ($pedidos as $pedido)
    <div class="SaltoDePagina">
        <div class="row" style="margin-bottom: 30px; position: relative;">
            <div class="cols-1 center">
                <h1>ORDEN DE DESPACHO N° {{ $pedido->id_comercial }}</h1>
                <p class="title-3">{{ mb_strtoupper($empresa->nombre) }} - {{ $pedido->centroDist->nombre }}</p>
                <img src="{{ asset($empresa->logo) }}" alt="Logo" style="position: absolute; width: 80px; left: 0; top: 0;">
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td width="100">Fecha P:</td>
                        <td>{{ $pedido->fecha_ingreso }}</td>
                        <td width="90"><b>Fecha E:</b></td>
                        <td><b>{{ $pedido->fecha_entrega }}</b></td>
                    </tr>
                    <tr>
                        <td width="100">C.C/NIT:</td>
                        <td>{{ $pedido->cedula_cliente_vd ? $pedido->cedula_cliente_vd : $pedido->cliente->cc_nit }}</td>
                        <td width="90">Cliente:</td>
                        <td>{{ $pedido->nombre_cliente_vd ? $pedido->nombre_cliente_vd : $pedido->cliente->nombre_cliente}}</td>
                    </tr>
                    <tr>
                        <td width="100">Teléfono: </td>
                        <td>{{ $pedido->telefono_cliente_vd ? $pedido->telefono_cliente_vd : ($pedido->cliente->telefono ? $pedido->cliente->telefono : '----------') }}</td>
                        <td width="90">Dirección: </td>
                        <td>{{ $pedido->direccion_cliente_vd ? substr($pedido->direccion_cliente_vd, 0, strpos($pedido->direccion_cliente_vd, ' B. ')) : $pedido->cliente->direccion }}</td>
                    </tr>
                    <tr>
                        <td width="100">Creado por:</td>
                        <td>{{ $pedido->creador->nombres . ' ' . $pedido->creador->apellidos }}</td>
                        <td width="90">Barrio:</td>
                        <td>{{ $pedido->direccion_cliente_vd ? substr($pedido->direccion_cliente_vd, strpos($pedido->direccion_cliente_vd, ' B. ') + 3) : ($pedido->cliente->barrio ? $pedido->cliente->barrio : '------') }}</td>
                    </tr>
                    <tr>
                        <td width="100">Lista:</td>
                        <td>{{ $pedido->codigo_lista }}</td>
                        <td width="90">Ciudad:</td>
                        <td>{{ $pedido->ciudad_cliente_vd ? $pedido->ciudad_cliente_vd : ($pedido->cliente->ciudadCl ? $pedido->cliente->ciudadCl->ciudad : '------') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <table cellpadding="6" cellspacing="0" class="tbl_lista" style="width: 100%;">
                <tbody>
                    <tr>
                        <td colspan="{{ $empresa->nombre == 'San Marino' ? '5' : '4' }}" align="center" class="td_lista" >Pedido</td>
                        <td colspan="4" align="center" class="td_lista" >Precio</td>
                        <td colspan="2" align="center" class="td_lista" >Despachado</td>
                    </tr>
                    <tr>
                        <td align="center" class="td_lista" >Cod</td>
                        <td align="center" class="td_lista" >Producto</td>
                        @if ($empresa->nombre == 'San Marino')
                            <td align="center" class="td_lista" >Tiq</td>
                        @endif
                        <td align="center" class="td_lista" >Un</td>
                        <td align="center" class="td_lista" >Kg</td>
                        <td align="center" class="td_lista" >$Un</td>
                        <td align="center" class="td_lista" >$Kg</td>
                        <td align="center" class="td_lista" >$Ds</td>
                        <td align="center" class="td_lista" >$Total</td>
                        <td align="center" class="td_lista" >Un</td>
                        <td align="center" class="td_lista" >Kg</td>
                    </tr>
                    @foreach($pedido->productos as $producto)
                        <tr class="fila_producto">
                            <td align="center" class="td_lista">{{ $producto->codigo }}</td>
                            <td align="left" class="td_lista">{{ $producto->nombre }}</td>
                            @if ($empresa->nombre == 'San Marino')
                                <td align="center" class="td_lista">{{ $producto->pivot->tiquetear ? 'X' : '' }}</td>
                            @endif
                            <td align="center" class="td_lista" style="min-width: 35px;">{{ number_format($producto->pivot->unidades, 0, ',', '.') }}</td>
                            <td align="right" class="td_lista">{{ number_format($producto->pivot->peso, 2, ',', '.') }}</td>
                            <td align="right" class="td_lista">{{ number_format($producto->pivot->valor_un, $empresa->decimales, ',', '.') }}</td>
                            <td align="right" class="td_lista">{{ number_format($producto->pivot->valor_kg, $empresa->decimales, ',', '.') }}</td>
                            <td align="right" class="td_lista">{{ number_format($producto->pivot->descuento, $empresa->decimales, ',', '.') }}</td>
                            <td align="right" class="td_lista">{{ number_format($producto->pivot->total, $empresa->decimales, ',', '.') }}</td>
                            <td align="right" class="td_lista">&nbsp;</td>
                            <td align="right" class="td_lista">&nbsp;</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="td_lista" colspan="{{ $empresa->nombre == 'San Marino' ? '11' : '10' }}">
                            <b>Observación: {{ (!$pedido->observacion_pedido || $pedido->observacion_pedido == ' ' || strlen($pedido->observacion_pedido) < 2) ? 'No hay observaciones' : $pedido->observacion_pedido }}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-bottom: 80px;">
            <table width="100%" cellspacing="0" cellpadding="10">
                <tbody>
                    <tr>
                        <td width="50%" align="center" class="td_lista">
                            <span style="font-size: 12px;">TOTAL DESCUENTO</span><br>
                            <span style="font-size: 20px;">$ {{ number_format($pedido->productos->sum('pivot.totald'), $empresa->decimales, ',', '.') }}</span>
                        </td>
                        <td width="50%" align="center" class="td_lista">
                            <b>
                                <span style="font-size: 12px;">TOTAL PEDIDO</span><br>
                                <span style="font-size: 20px;">$ {{ number_format($pedido->productos->sum('pivot.total'), $empresa->decimales, ',', '.') }}</span>
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <table width="100%" cellspacing="10" cellpadding="10">
                <tbody>
                    <tr>
                        <td width="25%" align="center" class="td_firma">FIRMA CONDUCTOR</td>
                        <td width="25%" align="center" class="td_firma">FIRMA CLIENTE</td>
                        <td width="25%" align="center" class="td_firma">RECIBE {{ mb_strtoupper($empresa->nombre) }}</td>
                        <td width="25%" align="center" class="td_firma">DESPACHADO POR</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    @endforeach
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            console.log('print');
            window.print();
        });
    </script>
</body>
</html>

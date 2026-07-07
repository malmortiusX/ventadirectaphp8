@extends('layouts.app')

@php
    setlocale(LC_ALL, 'es_ES');
    \Carbon\Carbon::setLocale('es');
@endphp

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leafletjs/leaflet.css') }}">
    <style>
        #map_cliente { 
            width: 100%;
            height: 150px;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('pedidos.create') }}" method="post" id="form_crear_pedido">
        @csrf
        <input type="text" class="hide" id="id_cliente" name="id_cliente">
        <input type="text" class="hide" id="fecha_entrega" name="fecha_entrega" value="{{ date("Y-m-d", time() + 86400) }}">
        <input type="text" class="hide" id="cop" name="cop" value="{{ $vendedor->centrosDist->count() ? $vendedor->centrosDist()->first()->cop : $vendedor->cop }}">
        <div class="container-full">
            <div class="row">
                <div class="col s12 l6">
                    <h1 class="title">Rutero</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Rutero</a>
                    </div>
                </div>
                <div class="col l6 right-align">
                    <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('pedidos.create') }}">
                        <span class="mdc-button__label mr-1">Nuevo Pedido</span>
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 l8 xl9 mb-2">
                    <div class="card mb-0">
                        <div class="card-content">
                            <span class="card-title mb-2">Filtros</span>
                            <div class="row mb-0">
                                <div class="col s6 m3 mb-2-s">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense focusable {{ $estado > 3 ? '' : 'mdc-select--filled' }}" id="mdc-select-estado">
                                        <div class="mdc-select__anchor" aria-labelledby="estado-select-label">
                                            <input type="hidden" name="estado" id="estado" class="mdc-select__input-value" value="{{ $estado }}">
                                            <span id="estado__selected-text" class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="estado-select-label" class="mdc-floating-label {{ $estado > 3 ? '' : 'mdc-floating-label--float-above' }}">Estado</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--superdense" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item {{ $estado == 1 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 1 ? 'aria-selected="true"' : '' }} data-value="1" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">Sin Visitar</span>
                                                </li>
                                                <li class="mdc-list-item {{ $estado == 2 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 2 ? 'aria-selected="true"' : '' }} data-value="2" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">No Compras</span>
                                                </li>
                                                <li class="mdc-list-item {{ $estado == 3 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 3 ? 'aria-selected="true"' : '' }} data-value="3" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">Visitados</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3 mb-2-s">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense" id="mdc-fecha">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha" name="fecha" id="fecha" value="{{ $fecha->format('Y-m-d') }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_fecha">Fecha de Descuento</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s12 m3">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense" id="mdc-busqueda">
                                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_busqueda" name="busqueda" id="busqueda" value="{{ $busqueda }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_busqueda">CC/NIT o Nombre del cliente</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s6 m3">
                                    <a class="mdc-button mdc-button--raised full-width" href="{{ route('clientes.rutero') }}">
                                        <span class="mdc-button__label">Reiniciar Filtros</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 l4 xl3">
                    <div class="card mb-0 highlighted bg-primary white-text">
                        <div class="card-content full-height d-flex f-column justify-content-center" style="padding: 8px 24px;">
                            <label class="center">Número de Clientes</label>
                            <span class="card-title highlighted center" id="total_clientes" style="font-size: 18px; line-height: 18px; margin-bottom: 4px;">{{ $totalClientes->count() }}</span>
                            <div class="row mb-0">
                                <div class="col s6">
                                    <label>Pedidos</label>
                                    <span class="card-subtitle subtitle-3 highlighted nowrap" id="total_pedidos">{{ $totalClientes->filter(function ($cliente) { return $cliente->estado_cli == 3; })->count() }}</span>
                                </div>
                                <div class="col s6 right-align">
                                    <label>No Compras</label>
                                    <span class="card-subtitle subtitle-3 highlighted right-align nowrap" id="total_no_compra">{{ $totalClientes->filter(function ($cliente) { return $cliente->estado_cli == 2; })->count() }}</span>
                                </div>
                            </div>
                            <label class="capitalize center mt-1">{{ \Carbon\Carbon::create()->month($semana->month)->monthName . ' - Semana ' . $semana->weekOfMonth . ' - ' . \Carbon\Carbon::parse($fecha)->dayName }}</label>
                        </div>
                    </div>
                </div>
                <div class="row" id="tbl_rutero">
                    <div class="col s12">
                        <div class="mdc-data-table mdc-data-table--dense full-width card">
                            <div class="mdc-data-table__table-container">
                                <table class="mdc-data-table__table" aria-label="Dessert calories">
                                    <thead>
                                        <tr class="mdc-data-table__header-row">
                                            <th class="mdc-data-table__header-cell" role="columnheader" scope="col">#</th>
                                            <th class="mdc-data-table__header-cell hide-on-med-and-up" role="columnheader" scope="col">Cliente</th>
                                            <th class="mdc-data-table__header-cell hide-on-small-only" role="columnheader" scope="col">CC/NIT</th>
                                            <th class="mdc-data-table__header-cell hide-on-small-only" role="columnheader" scope="col">Nombre</th>
                                            <th class="mdc-data-table__header-cell px-0" role="columnheader" scope="col"></th>
                                            <th class="mdc-data-table__header-cell hide-on-small-only" role="columnheader" scope="col">Estado</th>
                                            <th class="mdc-data-table__header-cell hide-on-med-and-up" role="columnheader" scope="col">Es.</th>
                                            @if($hoy->format('Ymd') == $fecha->format('Ymd'))
                                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Acciones</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="mdc-data-table__content">
                                        @forelse ($clientes as $index => $cliente)
                                            <tr class="mdc-data-table__row" id="{{ $cliente->id_cliente }}">
                                                <th class="mdc-data-table__cell" scope="row">{{ $cliente->secuencia }}</th>
                                                <td class="mdc-data-table__cell capitalize hide-on-med-and-up">
                                                    <a style="line-height: 2;" class="link color-primary" href="{{ route('clientes.show', ['cc_nit' => $cliente->cc_nit]) }}">{{ mb_strtolower($cliente->cc_nit) }}</a>
                                                    <br>
                                                    {!! mb_strtolower($cliente->nombre_cliente) !!}
                                                </td>
                                                <td class="mdc-data-table__cell capitalize hide-on-small-only">
                                                    <a class="link color-primary" href="{{ route('clientes.show', ['cc_nit' => $cliente->cc_nit]) }}">{{ mb_strtolower($cliente->cc_nit) }}</a>
                                                </td>
                                                <td class="mdc-data-table__cell capitalize hide-on-small-only nombre_cliente">{!! mb_strtolower($cliente->nombre_cliente) !!}</td>
                                                <td class="mdc-data-table__cell px-0">
                                                    @if($cliente->latitud && $cliente->longitud)
                                                        <!--i class="fas fa-check"></i-->
                                                        <a class="color-primary" target="_blank" href="{{ 'https://www.google.com/maps/dir/?api=1&travelmode=driving&destination=' . $cliente->latitud . ',' . $cliente->longitud }}">
                                                            <i aria-describedby="tooltip-maps_{{ $cliente->cc_nit }}" class="fal fa-store-alt"></i>
                                                        </a>
                                                        <div id="tooltip-maps_{{ $cliente->cc_nit }}" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">Abrir en Google Maps</div></div>
                                                    @endif
                                                </td>
                                                <td class="mdc-data-table__cell hide-on-small-only">
                                                    @switch($cliente->estado_cli)
                                                        @case(2)
                                                            <div class="chip-estado noselect white-text center orange" style="min-width: 80px; max-width: 100px;">No Compra</div>
                                                            @break
                                                        @case(3)
                                                            <div class="chip-estado noselect white-text center green" style="min-width: 80px; max-width: 100px;">Visitado</div>
                                                            @break
                                                        @default
                                                            <div class="chip-estado noselect white-text center grey" style="min-width: 80px; max-width: 100px;">Sin Visitar</div>
                                                    @endswitch
                                                </td>
                                                <td class="mdc-data-table__cell hide-on-med-and-up">
                                                    @if($cliente->pedidos)
                                                        <div class="chip-estado noselect white-text center green" style="width: 30px;">V</div>
                                                    @elseif($cliente->id_no_compra)
                                                        <div class="chip-estado noselect white-text center orange" style="width: 30px;">NC</div>
                                                    @else    
                                                        <div class="chip-estado noselect white-text center grey" style="width: 30px;">SV</div>
                                                    @endif
                                                </td>
                                                @if($hoy->format('Ymd') == $fecha->format('Ymd'))
                                                    <td class="mdc-data-table__cell" style="min-width: 100px;">
                                                        <button type="button" class="geolocalizar btn-icon primary-on-hover" data-index="{{ $index }}" data-id_cliente="{{ $cliente->id_cliente }}"><i class="fas fa-map-marker-alt"></i></button>
                                                        <button type="button" class="crear-pedido btn-icon primary-on-hover" data-index="{{ $index }}" data-id_no_compra="{{ $cliente->id_no_compra }}" data-pedidos="{{ $cliente->pedidos }}" data-id_cliente="{{ $cliente->id_cliente }}"><i class="fas fa-shopping-cart"></i></button>
                                                        @if($cliente->estado_cli == 1)
                                                            <button type="button" class="registrar-no-compra btn-icon primary-on-hover" data-index="{{ $index }}" data-id_no_compra="{{ $cliente->id_no_compra }}" data-pedidos="{{ $cliente->pedidos }}" data-id_cliente="{{ $cliente->id_cliente }}"><i class="fas fa-exclamation-triangle"></i></button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr class="mdc-data-table__row">
                                                <th class="mdc-data-table__cell center" scope="row" colspan="{{ $usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_suervisor' ? '8' : '7' }}">No se han encontrado clientes de precios</th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($destino)
                    <div class="row mb-0">
                        <div class="col s12">
                            <a class="mdc-button mdc-button--raised mdc-button--large" target="_blank" href="{{ 'https://www.google.com/maps/dir/?api=1&travelmode=driving' . $waypoints . '&destination=' . $destino }}">
                                <span class="mdc-button__label mr-1">Exportar a Maps</span>
                                <i class="fal fa-map-marker-alt"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div id="ver_cliente_modal" class="modal" style="max-height: 90%">
            <div class="modal-content">
                <div class="row mb-1">
                    <div class="col s12 m8">
                        <h4 class="title">Detalle de Cliente</h4>
                        <p class="my-0">Datos del cliente selecionado en el día de hoy {{ date('d/m/Y') }}</p>
                    </div>
                    <div class="col s12 m4 mt-1-s">
                        <div class="card highlighted black white-text mt-0">
                            <div class="card-content py-1 px-2 center">
                                <span id="estado" class="d-block subtitle-3 highlighted card-title mt-0 mb-0" style="margin-top: 2px">VISITADO</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col s12">
                        <blockquote class="mb-1">
                            <h6 class="subtitle-2 highlighted">Datos del Cliente</h6>
                        </blockquote>
                    </div>
                    <div class="col s12 m6">
                        <label>Nombre completo</label>
                        <span id="nombre_cliente" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s6 m3 mt-1-s">
                        <label>CC/NIT</label>
                        <span id="cc_nit" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s6 m3 mt-1-s">
                        <label>Teléfono</label>
                        <span id="telefono" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s12 m8 mt-1">
                        <label>Dirección</label>
                        <span id="direccion" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s12 m4 mt-1">
                        <label>Ciudad</label>
                        <span id="ciudad" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s12 mt-1">
                        <div id="map_cliente"></div>
                    </div>
                </div>
                <div class="row mb-1 div-no_compra" style="display: none;">
                    <div class="col s12">
                        <blockquote class="mb-1">
                            <h6 class="subtitle-2 highlighted">Datos de No Compra</h6>
                        </blockquote>
                    </div>
                    <div class="col s12 m6">
                        <label>Motivo</label>
                        <span id="motivo_no_compra" class="d-block subtitle-3 highlighted">Motivo No Ingresado</span>
                    </div>
                    <div class="col s12 m6 mt-1-s">
                        <label>Usuario</label>
                        <span id="creador_no_compra" class="d-block subtitle-3 highlighted">HEIDY MILENA BAYONA HENAO</span>
                    </div>
                </div>
                <div class="row mb-1 div-pedidos" style="display: none;">
                    <div class="col s12">
                        <blockquote class="mb-1">
                            <h6 class="subtitle-2 highlighted">Pedidos del Día (<span id="numero_pedidos"></span>)</h6>
                        </blockquote>
                    </div>
                    <div class="col s12">
                        <table id="lista_pedidos" style="margin-top: 8px;">
                            <thead>
                                <tr class="dense black white-text">
                                    <th class="center">Código</th>
                                    <th class="center">Estado</th>
                                    <th class="center">Valor</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3 mb-0">
                    <div class="col s12 right-align div-nuevo-cliente">
                        <button class="mdc-button mdc-button--outlined mt-1-s modal-close" type="button">
                            <span class="mdc-button__label">Salir</span>
                        </button>
                        <a class="mdc-button mdc-button--outlined mt-1-s" id="pqrs_cliente" href="">
                            <span class="mdc-button__label">PQRS</span>
                        </a>
                        <button class="mdc-button mdc-button--outlined mt-1-s" id="geolocalizar_ver_cliente" type="button">
                            <span class="mdc-button__label">Geolocalizar</span>
                        </button>
                        <button class="mdc-button mdc-button--raised mt-1-s" id="no_compra_ver_cliente" type="button">
                            <span class="mdc-button__label">No Compra</span>
                        </button>
                        <button class="mdc-button mdc-button--raised mt-1-s" id="pedido_ver_cliente" type="button">
                            <span class="mdc-button__label">Pedido</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="no_compra_modal" class="modal" style="max-height: 90%;">
            <div class="modal-content">
                <div class="row mb-1">
                    <div class="col s12">
                        <h4 class="title">No Compra</h4>
                        <p class="my-0">Registrar no compra en el día de hoy {{ date('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col s12">
                        <blockquote class="mb-1">
                            <h6 class="subtitle-2 highlighted">Datos del Cliente</h6>
                        </blockquote>
                    </div>
                    <div class="col s12 m6">
                        <label>Nombre completo</label>
                        <span id="noc_nombre_cliente" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s6 m3 mt-1-s">
                        <label>CC/NIT</label>
                        <span id="noc_cc_nit" class="d-block subtitle-3 highlighted"></span>
                    </div>
                    <div class="col s6 m3 mt-1-s">
                        <label>Teléfono</label>
                        <span id="noc_telefono" class="d-block subtitle-3 highlighted"></span>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col s12">
                        <blockquote class="mb-1">
                            <h6 class="subtitle-2 highlighted">Motivo</h6>
                        </blockquote>
                    </div>
                    @foreach ($motivos as $motivo)
                        <div class="col s6 m3 l4 xl3">
                            <div class="card card--outlined card--option noselect mt-1 mb-0 opcion-no-compra" data-id-motivo="{{ $motivo->motivo }}">
                                <div class="card-content center">
                                    <p class="no-margin nowrap">{{ $motivo->motivo }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-3 mb-0">
                    <div class="col s12 right-align div-nuevo-cliente">
                        <button class="mdc-button mdc-button--outlined modal-close" id="salir_registrar_no_compra" type="button">
                            <span class="mdc-button__label">Salir</span>
                        </button>
                        <button class="mdc-button mdc-button--raised guardar_cliente" id="registrar_no_compra" type="button">
                            <span class="mdc-button__label">Guardar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/leafletjs/leaflet.js') }}"></script>
    <script>
        $(document).ready(async function() {
            // Url's a utilizar
            const urlRegistrarNoCompra = '{!! route('rutero.registrarNoCompra') !!}';

            // Elementos de material.io
            const fecha =  new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha'));
            const selectEstado = new mdc.select.MDCSelect(document.querySelector('#mdc-select-estado'));
            const busqueda =  new mdc.textField.MDCTextField(document.querySelector('#mdc-busqueda'));
            const dataTable = new mdc.dataTable.MDCDataTable(document.querySelector('.mdc-data-table'));
            
            const tooltips = [].map.call(document.querySelectorAll('.mdc-tooltip'), function(el) {
                return new mdc.tooltip.MDCTooltip(el);
            });

            selectEstado.listen('MDCSelect:change', (el) => {
                $('#estado').val(selectEstado.value);
                $('#mainForm').submit();
            });


            //Toca usar esta cada vez que se quiera obtener coordenadas
            const coordenadas = await geolocalizar();
            console.log(coordenadas);

            var clientes = @json($clientes);
            console.log(clientes);

            // Elementos de Materialize
            $('#no_compra_modal').modal({
                dismissible: true,
                startingTop: '5%',
                endingTop: '5%',
                onOpenStart: function(modal, trigger) {
                    // Nada por ahora
                },
                onCloseEnd: function() {
                    motivoNoCompra = null;
                    $('#registrar_no_compra').removeAttr('data-id_cliente');
                    $('#registrar_no_compra').removeData('id_cliente');
                    $('.opcion-no-compra').removeClass('card--option-selected');
                    $('#noc_nombre_cliente').text('');
                    $('#noc_cc_nit').text('');
                    $('#noc_telefono').text('');
                }
            });

            // Métodos

            // Abrir la modal de No Compra
            $('#tbl_rutero').on('click', '.registrar-no-compra', function() {
                let index = $(this).data('index');
                abrirNoCompra(index);
            });
            
            // Seleccionar motivo de No Compra
            $('.opcion-no-compra').click(function() {
                $('.opcion-no-compra').removeClass('card--option-selected');
                $(this).addClass('card--option-selected');
            });

            $('#registrar_no_compra').click(function() {
                let motivoNoCompra = $('.opcion-no-compra.card--option-selected').first().data('id-motivo');
                if (motivoNoCompra) {
                    $.ajax({
                        method: 'POST',
                        url: urlRegistrarNoCompra,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            cliente: $('#registrar_no_compra').data('id_cliente'),
                            motivo: motivoNoCompra
                        }
                    }).done(function(response) {
                        let indexCliente = clientes.map(function(e) { return e.id_cliente; }).indexOf(response.cliente.id_cliente);
                        clientes[indexCliente].motivo_no_compra = response.motivo;
                        clientes[indexCliente].id_no_compra = response.noCompra;
                        clientes[indexCliente].creador_no_compra = '{!! $usuario->nombres . ' ' . $usuario->apellidos !!}';
                        $('.cliente-' + response.cliente.id_cliente + ' .estado').text('No Compra');
                        $('.cliente-' + response.cliente.id_cliente + ' .estado-mv').text('NC');
                        $('#no_compra_modal').modal('close');
                        location.reload();
                        actualizarTotales();
                    }).fail(function(error) {
                        console.error(error);
                        if (error.responseJSON.cliente) {
                            let indexCliente = clientes.map(function(e) { return e.id_cliente; }).indexOf(error.responseJSON.cliente.id_cliente);
                            clientes[indexCliente].motivo_no_compra = error.responseJSON.validacion.motivo;
                            clientes[indexCliente].id_no_compra = error.responseJSON.validacion.id_no_compra;
                            clientes[indexCliente].creador_no_compra = 'No disponible';
                            $('.cliente-' + error.responseJSON.cliente.id_cliente + ' .estado').text('No Compra');
                            $('.cliente-' + error.responseJSON.cliente.id_cliente + ' .estado-mv').text('NC');
                            $('#no_compra_modal').modal('close');
                            Swal.fire({
                                title: 'NO PERMITIDO!',
                                text: error.responseJSON.mensaje,
                                icon: 'error'
                            });
                        } else {
                            $('#no_compra_modal').modal('close');
                            Swal.fire({
                                title: 'ERROR',
                                text: 'Hubo un error al intentar guardar la no compra.',
                                icon: 'error'
                            });
                        }
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'SELECCIONE EL MOTIVO!',
                        text: 'Debe seleccionar un motivo de no compra.',
                        icon: 'error'
                    });
                }
            });

            function abrirNoCompra(index) {
                let cliente = clientes[index];
                console.log(cliente);
                $('#noc_nombre_cliente').text(cliente.nombre_cliente);
                $('#noc_cc_nit').text(cliente.cc_nit);
                $('#noc_telefono').text(cliente.telefono);
                $('#registrar_no_compra').attr('data-id_cliente', cliente.id_cliente);
                $('#registrar_no_compra').data('id_cliente', cliente.id_cliente);
                $('#no_compra_modal').modal('open');
            }

            Number.prototype.toRad = function() {
                return this * Math.PI / 180;
            }

            var lat1 = coordenadas.latitud; 
            var lon1 = coordenadas.longitud; 
            var R = 6371; // km 
            
            for (let index = 0; index < clientes.length; index++) {
                const cliente = clientes[index];
                if (cliente.latitud && cliente.longitud) {
                    let lat2 = parseFloat(cliente.latitud);
                    let lon2 = parseFloat(cliente.longitud);
                    //has a problem with the .toRad() method below.
                    let x1 = lat2-lat1;
                    let dLat = x1.toRad();  
                    let x2 = lon2-lon1;
                    let dLon = x2.toRad();  
                    let a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * Math.sin(dLon/2) * Math.sin(dLon/2);  
                    let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                    let d = R * c; 
        
                    console.log(d);
                }
            }
        });
    </script>
@endsection
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
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
        <input type="text" class="hide" id="cop" name="cop" value="{{ $usuario->centrosDist->count() ? $usuario->centrosDist()->first()->cop : $usuario->cop }}">
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
                    @if($usuario->nivel == "u_callcenter")
                    <a class="mdc-button mdc-button--raised mdc-button--large mb-1" href="{{ route('pedidos.createLlamada') }}">
                        <span class="mdc-button__label mr-1">Pedido en Llamada</span>
                        <i class="fas fa-phone"></i>
                    </a>
                    @endif
                    <a class="mdc-button mdc-button--raised mdc-button--large mb-1" href="{{ route('pedidos.create') }}">
                        <span class="mdc-button__label mr-1">Nuevo Pedido</span>
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 l8 xl9 mb-2">
                    <div class="card mb-0 valign-wrapper" style="height: 122px">
                        <div class="card-content full-width">
                            <div class="row mb-0">
                                <div class="col s12 m8">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--filled mdc-text-field--label-floating mdc-text-field--dense" id="mdc-fecha_consulta">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_consulta" id="fecha_consulta" value="{{ date('Y-m-d') }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label mdc-floating-label--float-above" id="lbl_fecha_consulta">Fecha de Ruta</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s12 m4 mt-1-s">
                                    <button class="mdc-button mdc-button--raised mdc-button--x-large full-width" id="buscar_rutero" type="button" disabled>
                                        <span class="mdc-button__label mr-1">Buscar</span>
                                        <i class="fas fa-search send" style="display: none"></i>
                                        <i class="fas fa-spinner sending"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 l4 xl3">
                    <div class="card mb-0 highlighted bg-primary white-text">
                        <div class="card-content full-height d-flex f-column justify-content-center" style="padding: 8px 24px;">
                            <label class="center">Número de Clientes</label>
                            <span class="card-title highlighted center" id="total_clientes" style="font-size: 18px; line-height: 18px; margin-bottom: 4px;">N/A</span>
                            <div class="row mb-0">
                                <div class="col s6">
                                    <label>
                                        @if($usuario->nivel == 'u_callcenter')
                                        Contactados
                                        @else
                                        Visitados
                                        @endif
                                    </label>
                                    <span class="card-subtitle subtitle-3 highlighted nowrap" id="total_pedidos">N/A</span>
                                </div>
                                <div class="col s6 right-align">
                                    <label>No Compra</label>
                                    <span class="card-subtitle subtitle-3 highlighted right-align nowrap" id="total_no_compra">N/A</span>
                                </div>
                            </div>
                            <label id="info-semana" class="capitalize center mt-1">N/A</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-0 mt-3" id="listado_clientes" class="display responsive" width="100%" style="width:100%">
                    <div class="col s12">
                        <div class="card mb-0">
                            <div class="card-content">
                                <table id="tbl_rutero" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="hide-on-small-only">CC/NIT</th>
                                            <th class="hide-on-small-only">Teléfono</th>
                                            @if ($usuario->nivel != 'u_callcenter')
                                            <th class="hide-on-med-and-up">S.</th>
                                            @endif
                                            <th>Nombre</th>
                                            <th></th>
                                            <th class="center hide-on-med-and-down">Estado</th>
                                            <th class="center hide-on-large-only">E</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <a id="telefono_cliente" class="llamar-cliente" href="" data-index="" data-id_cliente="">
                            <span id="telefono" class="d-block subtitle-3 highlighted"></span>
                        </a>
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
                        {{-- <a class="mdc-button mdc-button--outlined mt-1-s" id="pqrs_cliente" href="">
                            <span class="mdc-button__label">PQRS</span>
                        </a> --}}
                        @if ($usuario->nivel != 'u_callcenter')
                        <button class="mdc-button mdc-button--outlined mt-1-s" id="geolocalizar_ver_cliente" type="button">
                            <span class="mdc-button__label">Geolocalizar</span>
                        </button>
                        @endif
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
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/leafletjs/leaflet.js') }}"></script>
    <script>
        $(document).ready(function(){
            var clientes = [];
            var fConsulta = '';
            var motivoNoCompra = null;
            var fHoy = new Date().setHours(0,0,0,0) / 1000;
            var mapCliente;
            var markerCliente = null;
            var circleCliente = null;
            var horaLimite = '{{ $usuario->pedidos_mismo_dia ? $usuario->limite_mismo_dia : "" }}';
            var hoy = '{{ $hoy ?? '' }}';

            var urlBuscarRutero = '{!! route('rutero.clientes', ['fecha' => 'null']) !!}';
            var urlRegLlamada = '{!! route('rutero.regLlamada', ['cliente' => 'idCliente', 'clienteVd' => 'idClienteVd']) !!}';
            var urlPedidosCliente = '{!! route('rutero.pedidosCliente', ['fecha' => 'fecha', 'cliente' => 'idCliente']) !!}';
            var urlVerPedido = '{!! route('pedidos.show', ['id' => 'null']) !!}'.replace('/null', '/');
            var urlRegistrarNoCompra = '{!! route('rutero.registrarNoCompra') !!}';
            var urlRegistrarPQRS = '{!! route('pqrs.create') !!}';
            var urlCoordenadasClientes = '{!! route('ajax.clientes.coordenadas') !!}';

            $('#rutero').addClass('mdc-list-item--active');

            const fechaConsulta = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_consulta'));

            @if($pqrs)
                Swal.fire({
                    title: 'PQRS CREADA!',
                    text: 'Se ha creado la PQRS {{ $pqrs[0] }} del cliente {{ $pqrs[1] }}. El seguimiento de la PQRS está disponible en el Service Desk.',
                    icon: 'success'
                });
            @endif

            // Se inicializa el mapa
            mapCliente = L.map('map_cliente');
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapCliente);
            L.control.scale().addTo(mapCliente);

            // Inicializa elementos de materialize
            $('#ver_cliente_modal').modal({
                dismissible: true,
                startingTop: '5%',
                endingTop: '5%',
                onOpenStart: function(modal, trigger) {
                    // Nada por ahora
                },
                onOpenEnd: function() {
                    mapCliente.invalidateSize(true);
                },
                onCloseEnd: function() {
                    $('#nombre_cliente').text('');
                    $('#cc_nit').text('');
                    $('#telefono').text('');
                    $('#direccion').text('');
                    $('#ciudad').text('');
                    $('#estado').text('');
                    $('#numero_pedidos').text('');
                    $('#motivo_no_compra').text('');
                    $('#creador_no_compra').text('');
                    $('#lista_pedidos tbody').html('');
                    $('.div-no_compra').hide();
                    $('.div-pedidos').hide();
                    $('#geolocalizar_ver_cliente').removeAttr('data-index');
                    $('#pedido_ver_cliente').removeAttr('data-index');
                    $('#no_compra_ver_cliente').removeAttr('data-index');
                    $('#telefono_cliente').removeAttr('data-index');
                }
            });

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

            obtenerRutero();

            $('#buscar_rutero').on('click', function(){
                if($('#fecha_consulta').val()) {
                    $(this).attr('disabled', 'disabled');
                    $('#buscar_rutero .send').hide();
                    $('#buscar_rutero .sending').show();
                    $('#buscar_rutero .cargando').show();
                    obtenerRutero();
                }
            });

            $('#tbl_rutero').on('click', '.geolocalizar', function() {
                let index = $(this).data('index');
                geolocalizar(index);
            });

            $('#tbl_rutero').on('click', '.crear-pedido', function() {
                let index = $(this).data('index');
                crearPedido(index);
            });

            $('#tbl_rutero').on('click', '.registrar-no-compra', function() {
                let index = $(this).data('index');
                abrirNoCompra(index);
            });

            $('.opcion-no-compra').click(function() {
                motivoNoCompra = $(this).data('id-motivo');
                console.log(motivoNoCompra);
                $('.opcion-no-compra').removeClass('card--option-selected');
                $(this).addClass('card--option-selected');
            });

            $('#registrar_no_compra').click(function() {
                if (motivoNoCompra) {
                    $.ajax({
                        method: 'POST',
                        url: urlRegistrarNoCompra,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        @if ($usuario->nivel == 'u_callcenter')
                        data: {
                            cliente: {{ $usuario->cliente->id_cliente }},
                            motivo: motivoNoCompra,
                            cliente_vd: $('#registrar_no_compra').data('id_cliente')
                        }
                        @else
                        data: {
                            cliente: $('#registrar_no_compra').data('id_cliente'),
                            motivo: motivoNoCompra
                        }
                        @endif
                    }).done(function(response) {
                        @if ($usuario->nivel == "u_callcenter")
                            let indexCliente = clientes.map(function(e) { return e.id_cliente_vd; }).indexOf(parseInt(response.cliente_vd));
                        @else
                            let indexCliente = clientes.map(function(e) { return e.id_cliente; }).indexOf(response.cliente.id_cliente);
                        @endif
                        clientes[indexCliente].motivo_no_compra = response.motivo;
                        clientes[indexCliente].id_no_compra = response.noCompra;
                        clientes[indexCliente].creador_no_compra = '{!! $usuario->nombres . ' ' . $usuario->apellidos !!}';
                        $('.cliente-' + response.cliente.id_cliente + ' .estado').text('No Compra');
                        $('.cliente-' + response.cliente.id_cliente + ' .estado-mv').text('NC');
                        $('#no_compra_modal').modal('close');
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
                        actualizarTotales();
                    });
                } else {
                    Swal.fire({
                        title: 'SELECCIONE EL MOTIVO!',
                        text: 'Debe seleccionar un motivo de no compra.',
                        icon: 'error'
                    });
                }
            });

            $('#tbl_rutero').on('click', '.ver-mas', function() {
                let index = $(this).data('index');
                mostrarCliente(index);
            });

            $('#tbl_rutero').on('click', 'tr', function() {
                if (fHoy > fConsulta) {
                    let index = $(this).data('index');
                    mostrarCliente(index);
                }
            });

            $('#geolocalizar_ver_cliente').click(function() {
                let index = $(this).data('index');
                geolocalizar(index);
            });

            $('#pedido_ver_cliente').click(function() {
                let index = $(this).data('index');
                $('#ver_cliente_modal').modal('close');
                crearPedido(index);
            });

            $('#no_compra_ver_cliente').click(function() {
                let index = $(this).data('index');
                $('#ver_cliente_modal').modal('close');
                abrirNoCompra(index);
            });

            function mostrarCliente(index) {
                let cliente = clientes[index];
                console.log(index);
                pedidosCliente(cliente.id_cliente);
                $('#nombre_cliente').text(cliente.nombre_cliente);
                $('#cc_nit').text(cliente.cc_nit);
                $('#telefono').text(cliente.telefono);
                $('#direccion').text(cliente.direccion);
                $('#ciudad').text(cliente.ciudad);
                $('#geolocalizar_ver_cliente').attr('data-index', index);
                $('#pedido_ver_cliente').attr('data-index', index);
                $('#no_compra_ver_cliente').attr('data-index', index);
                $('#telefono_cliente').attr('data-index', index).attr('data-id_cliente', cliente.id_cliente_vd).attr('href', 'tel:+57' + cliente.telefono);
                if (cliente.pedidos) {
                    $('#numero_pedidos').text(cliente.pedidos);
                    $('#estado').text('VISITADO');
                } else if (cliente.id_no_compra) {
                    $('#estado').text('NO COMPRA');
                    $('#motivo_no_compra').text(cliente.motivo_no_compra);
                    $('#creador_no_compra').text(cliente.creador_no_compra);
                    $('.div-no_compra').show();
                } else {
                    $('#estado').text('SIN VISITAR');
                }
                $('#pqrs_cliente').attr('href', urlRegistrarPQRS +'/'+ cliente.id_cliente);
                if (cliente.latitud && cliente.longitud) {
                    $('#map_cliente').show();
                    graficarMapa(cliente);
                } else {
                    $('#map_cliente').hide();
                }
                $('#ver_cliente_modal').modal('open');
                $('#telefono_cliente').click(function(){
                    guardarLlamadaCliente(index);
                });
            }

            function crearPedido(index) {
                @if($usuario->nivel != 'u_callcenter')
                if (horaLimite) {
                    if (hoy > horaLimite) {
                        let fecha = new Date();
                        fecha.setHours(horaLimite.substring(0, 2));
                        fecha.setMinutes(horaLimite.substring(2, 2));
                        Swal.fire({
                            title: 'ERROR!',
                            text: 'Hola {{ mb_convert_case($usuario->nombres, MB_CASE_TITLE, "UTF-8") }}, no puedes crear pedidos después de las '+ fecha.toLocaleTimeString('es-CO', { hour12: true, hour: '2-digit', minute: '2-digit'}),
                            icon: 'error'
                        });
                        return;
                    }
                }
                @endif
                let cliente = clientes[index];
                // console.log(cliente);

                @if ($usuario->nivel == 'u_callcenter')
                $('#id_cliente').val(cliente.id_cliente_vd).attr('value', cliente.id_cliente_vd);
                @else
                $('#id_cliente').val(cliente.id_cliente).attr('value', cliente.id_cliente);
                @endif

                if ($('#id_cliente').val() && $('#cop').val() && $('#fecha_entrega').val()) {
                    if (cliente.pedidos) {
                        Swal.fire({
                            title: '¿Crear Pedido?',
                            text: "Este cliente ya tiene un pedido creado. Esta acción creará uno nuevo.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ff0000',
                            confirmButtonText: 'Si, crear pedido!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#form_crear_pedido').submit();
                            }
                        });
                    } else if (cliente.id_no_compra) {
                        Swal.fire({
                            title: '¿Crear Pedido?',
                            text: "Este cliente tiene registrada una No Compra para este día.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ff0000',
                            confirmButtonText: 'Si, crear pedido!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#form_crear_pedido').submit();
                            }
                        });
                    } else {
                        $('#form_crear_pedido').submit();
                    }
                }
            }

            function abrirNoCompra(index) {
                let cliente = clientes[index];
                // console.log(cliente);
                if (cliente.id_no_compra) {
                    Swal.fire({
                        title: 'NO PERMITIDO!',
                        text: cliente.nombre_cliente + " ya tiene una No Compra registrada en este día.",
                        icon: 'error'
                    });
                } else if (cliente.pedidos) {
                    Swal.fire({
                        title: 'NO PERMITIDO!',
                        text: cliente.nombre_cliente + " tiene uno o más pedidos cerrados en este día.",
                        icon: 'error'
                    });
                } else {
                    $('#noc_nombre_cliente').text(cliente.nombre_cliente);
                    $('#noc_cc_nit').text(cliente.cc_nit);
                    $('#noc_telefono').text(cliente.telefono);
                    @if ($usuario->nivel == 'u_callcenter')
                    $('#registrar_no_compra').attr('data-id_cliente', cliente.id_cliente_vd);
                    @else
                    $('#registrar_no_compra').attr('data-id_cliente', cliente.id_cliente);
                    @endif
                    $('#registrar_no_compra').data('id_cliente', cliente.id_cliente);
                    $('#no_compra_modal').modal('open');
                }
            }

            function pedidosCliente(idCliente) {
                let fecha = new Date(fConsulta).getFullYear() + "-" + (new Date(fConsulta).getMonth() + 1) + "-" + new Date(fConsulta).getDate();
                let urlBuscar = urlPedidosCliente.replace('fecha', fecha).replace('idCliente', idCliente);
                    // console.log(urlBuscar);
                $.ajax({
                    'url': urlBuscar,
                    'context': document.body
                }).done(function(response) {
                    // console.log(response);
                    if (response.pedidos.length) {
                        $('.div-pedidos').show();
                        for (let index = 0; index < response.pedidos.length; index++) {
                            const pedido = response.pedidos[index];
                            $('#lista_pedidos tbody').append('<tr class="super-dense"><td class="center"><a class="link" href="'+ urlVerPedido + pedido.id_comercial +'">'+ pedido.id_comercial +'</a></td><td class="center">'+ (pedido.estado ? 'Cerrado' : 'Abierto') +'</td><td class="center">$ '+ numeroMiles(pedido.total_pedido) +'</td></tr>');
                        }
                    }
                    actualizarTotales();
                }).fail(function(error) {
                    console.error(error);
                    actualizarTotales();
                });
            }

            $('#tbl_rutero').on('click', '.llamar-cliente', function(e) {
                let index = $(this).data('index');
                guardarLlamadaCliente(index);
            });

            function guardarLlamadaCliente(index) {
                let cliente = clientes[index];
                // console.log(index);
                // console.log(cliente);
                @if ($usuario->nivel == 'u_callcenter')
                let urlLlamada = urlRegLlamada.replace('idCliente', {{ $usuario->cliente->id_cliente }}).replace('idClienteVd', cliente.id_cliente_vd);
                @else
                let urlLlamada = urlRegLlamada.replace('idCliente', cliente.id_cliente);
                @endif
                $.ajax({
                    url: urlLlamada
                })
                .done( function (response) {
                    // console.log(response);
                    $("#"+cliente.id_cliente_vd)[0].click();

                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                });
            }

            function obtenerRutero() {
                $('#listado_clientes').show();
                let urlBuscar = urlBuscarRutero.replace('null', $('#fecha_consulta').val());
                // console.log(urlBuscar);
                $.ajax({
                    'url': urlBuscar,
                    'context': document.body
                }).done(function(response) {
                    console.log(response);
                    clientes = response.clientes;
                    fConsulta = response.fechaConsulta;
                    $('#tbl_rutero').DataTable({
                        destroy: true,
                        data: clientes,
                        pageLength: 25,
                        responsive: true,
                        columnDefs: [
                            { orderable: false, targets: [7] },
                            { searchable: false, targets: [5, 7] }
                        ],
                        columns: [
                            {
                                title: '#',
                                data: 'secuencia',
                                render: function(data, type, row){
                                    if (data > 0)
                                        return numeroMiles(parseFloat(data));
                                    else
                                        return '---';
                                }
                            },
                            {
                                title: 'CC/NIT',
                                data: 'cc_nit',
                                className: 'hide-on-small-only'
                            },
                            {
                                title: 'TELEFONO',
                                data: 'telefono',
                                className: 'hide-on-small-only',
                                render: function(data, type, row, meta){
                                    if (data) {
                                        return '<a class="llamar-cliente ver-mas" data-index="' + meta.row + '" data-id_cliente="'+ row.id_cliente +'" style="cursor: pointer;">' + '<i class="fa fa-phone" aria-hidden="true"></i> ' + data + '</a>'+
                                        '<a id="' + row.id_cliente_vd + '" href="tel:+57' + data + '" class="" data-index="' + meta.row + '" data-id_cliente="'+ row.id_cliente_vd +'" style="display: none">' + '<i class="fa fa-phone" aria-hidden="true"></i> ' + data + '</a>';
                                        // return '<a class="llamar-cliente ver-mas" data-index="' + meta.row + '" data-id_cliente="'+ row.id_cliente +'">' + '<i class="fa fa-phone" aria-hidden="true"></i> ' + data + '</a>';
                                    } else {
                                        return 'Sin teléfono';
                                    }
                                }
                            },
                            @if ($usuario->nivel != 'u_callcenter')
                            {
                                title: 'S.',
                                data: 'sucursal',
                                className: 'hide-on-med-and-up'
                            },
                            @endif
                            {
                                title: 'Nombre',
                                data: 'nombre_cliente',
                                className: 'capitalize nombre_cliente',
                                render: function(data, type, row){
                                    if (data) {
                                        return data.toLowerCase();
                                    } else {
                                        return 'Sin Nombre';
                                    }
                                }
                            },
                            {
                                title: '',
                                data: 'cc_nit',
                                className: 'iconos-cliente px-0',
                                render: function(data, type, row){
                                    let iconGeo = '';
                                    if (row.latitud && row.longitud) {
                                        iconGeo = '<i aria-describedby="tooltip-geo_'+ data +'" class="fal fa-store-alt mr-1"></i><div id="tooltip-geo_'+ data +'" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">El cliente está Georreferenciado</div></div>';
                                    }
                                    return iconGeo;
                                }
                            },
                            {
                                title: 'Estado',
                                data: 'pedidos',
                                className: 'hide-on-med-and-down center estado',
                                render: function(data, type, row){
                                    if (data) {
                                        @if($usuario->nivel == 'u_callcenter')
                                        return 'Contactado';
                                        @else
                                        return 'Visitado';
                                        @endif
                                    } else if (row.id_no_compra) {
                                        return 'No Compra';
                                    } else {
                                        @if($usuario->nivel == 'u_callcenter')
                                        return 'Sin Contactar';
                                        @else
                                        return 'Sin Visitar';
                                        @endif
                                    }
                                }
                            },
                            {
                                title: 'E',
                                data: 'pedidos',
                                className: 'center hide-on-large-only estado-mv',
                                render: function(data, type, row){
                                    if (data) {
                                        @if($usuario->nivel == 'u_callcenter')
                                        return 'CC';
                                        @else
                                        return 'VV';
                                        @endif
                                    } else if (row.id_no_compra) {
                                        return 'NC';
                                    } else {
                                        @if($usuario->nivel == 'u_callcenter')
                                        return 'SC';
                                        @else
                                        return 'SV';
                                        @endif
                                    }
                                }
                            },
                            {
                                title: '',
                                @if ($usuario->nivel == 'u_callcenter')
                                data: 'id_cliente_vd',
                                @else
                                data: 'id_cliente',
                                @endif
                                ordering: false,
                                className: 'right-align no-line-height table-actions',
                                render: function(data, type, row, meta){
                                    if (fHoy > fConsulta) {
                                        $('.table-actions').addClass('hide');
                                        return null;
                                    } else {
                                        $('.table-actions').removeClass('hide');
                                        let btnPedido = '<button type="button" class="crear-pedido btn-icon mx-05 my-05" data-index='+ meta.row +' data-id_cliente='+ data +'><i class="fas fa-shopping-cart"></i></button>';

                                        let btnLlamada = '<button type="button" class="llamar-cliente ver-mas btn-icon mx-05 my-05" data-index='+ meta.row +' data-id_cliente='+ data +'><i class="fas fa-phone"></i></button>';

                                        let btnNoCompra = '<button type="button" class="registrar-no-compra btn-icon mx-05 my-05" data-index='+ meta.row +' data-id_cliente='+ data +'><i class="fas fa-exclamation-triangle"></i></button>';
                                        let btnModal = '<button type="button" class="ver-mas btn-icon mx-05 my-05" data-index='+ meta.row +' data-id_cliente='+ data +'><i class="fas fa-eye"></i></button>';
                                        let btnGeolocalizar = '<button type="button" class="geolocalizar btn-icon mx-05 my-05" data-index='+ meta.row +' data-id_cliente='+ data +'><i class="fas fa-map-marker-alt"></i></button>';
                                        @if($usuario->nivel == 'u_callcenter')
                                        return btnPedido + btnNoCompra + btnModal + btnLlamada;
                                        @else
                                        return btnPedido + btnNoCompra + btnModal + btnGeolocalizar;
                                        @endif
                                    }
                                }
                            }
                        ],
                        rowCallback: function(row, data, displayNum, displayIndex, dataIndex) {
                            $(row).addClass('primary-on-hover').addClass('cliente-' + data.id_cliente).attr('data-id_cliente', data.id_cliente).attr('data-index', dataIndex);
                            if (fHoy > fConsulta) {
                                $(row).addClass('clickable');
                            }
                        },
                        language: {
                            'sProcessing':    'Procesando...',
                            'sLengthMenu':    'Mostrar _MENU_ registros',
                            'sZeroRecords':   'No se encontraron resultados',
                            'sEmptyTable':    'Ningún dato disponible en esta tabla',
                            'sInfo':          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                            'sInfoEmpty':     'Mostrando registros del 0 al 0 de un total de 0 registros',
                            'sInfoFiltered':  '(filtrado de un total de _MAX_ registros)',
                            'sInfoPostFix':   '',
                            'sSearch':        'Buscar:',
                            'sUrl':           '',
                            'sInfoThousands':  ',',
                            'sLoadingRecords': 'Cargando...',
                            'oPaginate': {
                                'sFirst':    'Primero',
                                'sLast':    'Último',
                                'sNext':    'Siguiente',
                                'sPrevious': 'Anterior'
                            },
                            'oAria': {
                                'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                                'sSortDescending': ': Activar para ordenar la columna de manera descendente'
                            }
                        }
                    });

                    const tooltips = [].map.call(document.querySelectorAll('.mdc-tooltip'), function(el) {
                        return new mdc.tooltip.MDCTooltip(el);
                    });

                    actualizarTotales();
                    $('#info-semana').empty().text(response.mesConsulta + ' - Semana ' + response.semana.replace('s', '') + ' - ' + response.diaConsulta);

                    // console.log(response.pedidos);
                    $('#buscar_rutero').removeAttr('disabled');
                    $('#buscar_rutero .send').show();
                    $('#buscar_rutero .sending').hide();
                }).fail(function(error) {
                    console.error(error);
                });
            }

            function geolocalizar(index) {
                let cliente = clientes[index];
                if (navigator.geolocation) {
                    if (cliente.latitud && cliente.longitud) {
                        Swal.fire({
                            title: '¿Actualizar Coordenadas?',
                            text: "Esta acción reemplazará las coordenadas del cliente por las de tu ubicación actual.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '{{ App\Models\TblEmpresa::first()->color }}',
                            confirmButtonText: 'Si, actualizar!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                navigator.geolocation.getCurrentPosition(showPosition, error, {maximumAge:5000, timeout:1000, enableHighAccuracy: true});
                            }
                        });
                    } else {
                        navigator.geolocation.getCurrentPosition(showPosition, error, {maximumAge:5000, timeout:1000, enableHighAccuracy: true});
                    }
                } else {
                    Swal.fire({
                        title: 'ALERTA!',
                        text: "Intente tomar las caoordenadas con otro dispositivo.",
                        icon: 'error'
                    });
                }

                function showPosition(position) {
                    if (position.coords.accuracy > 1000) {
                        Swal.fire({
                            title: 'ALERTA!',
                            text: "La localización no es muy precisa. Revise configuración y señal e intente de nuevo.",
                            icon: 'error'
                        });
                    } else {
                        $.ajax({
                            method: 'POST',
                            url: urlCoordenadasClientes,
                            context: document.body,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id_cliente: cliente.id_cliente,
                                longitud: position.coords.longitude,
                                latitud: position.coords.latitude,
                                precision: Math.round(position.coords.accuracy)
                            }
                        }).done(function(response){
                            let index = clientes.findIndex(function (clienteLista) {
                                return clienteLista.id_cliente == response.cliente.id_cliente;
                            });
                            if (index) {
                                clientes[index].latitud = response.cliente.latitud;
                                clientes[index].longitud = response.cliente.longitud;
                                clientes[index].precision = response.cliente.precision;
                                console.log(clientes[index]);
                                let iconGeo = '<i aria-describedby="tooltip-geo_' +clientes[index].cc_nit+ '" class="fal fa-store-alt mr-1"></i>';
                                let tootlipGeo = '<div id="tooltip-geo_' +clientes[index].cc_nit+ '" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">El cliente está Georreferenciado</div></div>';
                                $('tr.cliente-' + clientes[index].id_cliente + ' td.iconos-cliente').html(iconGeo + tootlipGeo);
                                if ($('#ver_cliente_modal').hasClass('open')) {
                                    let cliente = clientes[index];
                                    $('#map_cliente').show();
                                    graficarMapa(cliente);
                                }
                                Swal.fire({
                                    title: 'COORDENADAS ASIGNADAS!',
                                    text: "Las coordenadas del cliente "+ cliente.nombre_cliente +' se han asignado correctamente.',
                                    icon: 'success'
                                });

                                const tooltips = [].map.call(document.querySelectorAll('.mdc-tooltip'), function(el) {
                                    return new mdc.tooltip.MDCTooltip(el);
                                });
                            }
                        }).fail(function(error){
                            console.error(error);
                            Swal.fire({
                                title: 'ERROR!',
                                text: 'Hubo un error al guardar las coordenadas. Intente de nuevo más tarde.',
                                icon: 'error'
                            });
                        });
                    }
                }

                function error(error) {
                    console.error(error);
                    Swal.fire({
                        title: 'ERROR!',
                        text: 'La localización no está habilitada.',
                        icon: 'error'
                    });
                }
            }

            function actualizarTotales() {
                let visitados = clientes.filter(function (cliente) {
                    return cliente.pedidos > 0;
                });

                let nocompra = clientes.filter(function (cliente) {
                    return (!cliente.pedidos && cliente.id_no_compra);
                });

                $('#total_clientes').text(numeroMiles(clientes.length));
                $('#total_pedidos').text(numeroMiles(visitados.length));
                $('#total_no_compra').text(numeroMiles(nocompra.length));
            }

            function numeroMiles(numero) {
                if (numero) {
                    let numeroStr = numero.toString();
                    let decimales = null;
                    if (numeroStr.indexOf('.') > 0) {
                        decimales = numeroStr.substring(numeroStr.indexOf('.') + 1);
                        numeroStr = numeroStr.substring(0, numeroStr.indexOf('.'));
                    }
                    let numeroFinal = '';
                    for (var j, i = numeroStr.length - 1, j = 0; i >= 0; i-- , j++) {
                        numeroFinal = numeroStr.charAt(i) + ((j > 0) && (j % 3 === 0) ? "." : "") + numeroFinal;
                    }
                    if (decimales) {
                        numeroFinal = numeroFinal + ',' + decimales;
                    }
                    return numeroFinal;
                } else {
                    return 0;
                }
            }

            function graficarMapa(cliente) {
                if (markerCliente != null) {
                    mapCliente.removeLayer(markerCliente);
                }
                if (circleCliente != null) {
                    mapCliente.removeLayer(circleCliente);
                }
                mapCliente.setView([cliente.latitud, cliente.longitud], 13);
                markerCliente = L.marker([cliente.latitud, cliente.longitud]);
                mapCliente.addLayer(markerCliente);
                if (cliente.precision > 10) {
                    circleCliente = L.circle([cliente.latitud, cliente.longitud], Math.round(cliente.precision));
                    mapCliente.addLayer(circleCliente);
                } else {
                    circleCliente = null;
                }
            }
        });
    </script>
@endsection

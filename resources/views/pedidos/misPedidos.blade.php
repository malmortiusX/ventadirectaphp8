@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    @php
        setlocale(LC_TIME, "spanish");
        setlocale(LC_MONETARY, 'it_IT');
    @endphp
    @csrf
    <div class="container-full">
        <div class="row">
            <div class="col s12 l6">
                <h1 class="title">Mis Pedidos</h1>
                <div class="breadcrumbs full-width">
                    <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                    <a class="breadcrumb">Pedidos</a>
                </div>
            </div>
            {{-- <div class="col l6 right-align">
                <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('pedidos.create') }}">
                    <span class="mdc-button__label mr-1">Nuevo Pedido</span>
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div> --}}
        </div>
        <div class="row mb-0">
            <div class="col s12 l8 xl9">
                <div class="card mb-0">
                    <div class="card-content">
                        <div class="row mb-0">
                            <div class="col s12 m4 xl5">
                                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--filled mdc-text-field--label-floating mdc-text-field--dense">
                                    <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_inicial" id="fecha_inicial" value="{{ date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $hoy)))) }}">
                                    <span class="mdc-notched-outline">
                                        <span class="mdc-notched-outline__leading"></span>
                                        <span class="mdc-notched-outline__notch">
                                            <span class="mdc-floating-label mdc-floating-label--float-above" id="lbl_fecha_inicial">Fecha Inicial</span>
                                        </span>
                                        <span class="mdc-notched-outline__trailing"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="col s12 m4 xl5 mt-1-s">
                                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--filled mdc-text-field--label-floating mdc-text-field--dense">
                                    <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_final" id="fecha_final" value="{{ $hoy->toDateString() }}">
                                    <span class="mdc-notched-outline">
                                        <span class="mdc-notched-outline__leading"></span>
                                        <span class="mdc-notched-outline__notch">
                                            <span class="mdc-floating-label mdc-floating-label--float-above" id="lbl_fecha_final">Fecha Final</span>
                                        </span>
                                        <span class="mdc-notched-outline__trailing"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="col s12 m4 xl5 mt-1-s">
                                <div class="mdc-select mdc-select--outlined mdc-select--dense full-width" id="mdc-select-estado">
                                    <div class="mdc-select__anchor" aria-labelledby="estado-select-label">
                                        <input type="hidden" name="estado" id="estado" class="mdc-select__input-value" value="">
                                        <span id="estado__selected-text" class="mdc-select__selected-text capitalize"></span>
                                        <span class="mdc-select__dropdown-icon">
                                            <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                            </svg>
                                        </span>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span id="estado-select-label" class="mdc-floating-label mdc-floating-label--float-above">Estado</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </div>
                                    <!-- Other elements from the select remain. -->
                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                        <ul class="mdc-list">
                                            <li class="mdc-list-item mdc-list-item--selected" aria-selected="true" data-value="0" role="option">
                                                <span class="mdc-list-item__ripple"></span>
                                                <span class="mdc-list-item__text">Todos</span>
                                            </li>
                                            <li class="mdc-list-item" data-value="1" role="option">
                                                <span class="mdc-list-item__ripple"></span>
                                                <span class="mdc-list-item__text">Pendiente</span>
                                            </li>
                                            <li class="mdc-list-item" data-value="2" role="option">
                                                <span class="mdc-list-item__ripple"></span>
                                                <span class="mdc-list-item__text">En Ruta</span>
                                            </li>
                                            <li class="mdc-list-item" data-value="3" role="option">
                                                <span class="mdc-list-item__ripple"></span>
                                                <span class="mdc-list-item__text">Entregado</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m4 xl2 mt-1">
                                <button class="mdc-button mdc-button--raised mdc-button--x-large full-width" id="buscar_pedidos" type="button">
                                    <span class="mdc-button__label mr-1">Buscar</span>
                                    <i class="fas fa-search send"></i>
                                    <i class="fas fa-spinner sending" style="display: none"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 l4 xl3">
                <div class="card mb-0 highlighted bg-primary white-text">
                    <div class="card-content px-0 pb-0">
                        <span class="card-title center mb-3 px-2">Pedidos Nuevos</span>
                        <div id="pedidos_nuevos" style="width:100%; text-align: center;" class="pb-2">
                            <p>Tienes <span id="numero_pedidos" class="px-1" style="font-size: 2em;font-size: 2em; background-color: #f00; border-radius: 50%;">-</span> pedidos sin entregar.</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col s12 l4 xl3">
                <div class="card mb-0 highlighted bg-primary white-text">
                    <div class="card-content full-height d-flex f-column justify-content-center" style="padding: 8px 24px;">
                        <label class="center">Total Vendido</label>
                        <span class="card-title highlighted center" id="total_ventas" style="font-size: 18px; line-height: 18px; margin-bottom: 4px;">N/A</span>
                        <div class="row mb-0">
                            <div class="col s6">
                                <label>Kilos</label>
                                <span class="card-subtitle subtitle-3 highlighted nowrap" id="total_kilos">N/A</span>
                            </div>
                            <div class="col s6 right-align">
                                <label>Unidades</label>
                                <span class="card-subtitle subtitle-3 highlighted right-align nowrap" id="total_unidades">N/A</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row mb-0 mt-3" id="listado_pedidos" class="display responsive" width="100%" style="width:100%">
            <div class="col s12">
                <div class="card mb-0">
                    <div class="card-content">
                        <table id="pedidos" class="hover" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th class="mdc-data-table__header-cell" role="columnheader" scope="col">
                                        @if($solicitudes->filter(function ($solicitud) { return $solicitud->estado == 2; })->count() && $aprueba)
                                            <div class="mdc-checkbox mdc-checkbox--touch mdc-checkbox--small">
                                                <input type="checkbox" class="mdc-checkbox__native-control" id="chk-all-solicitudes"/>
                                                <div class="mdc-checkbox__background">
                                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                    </svg>
                                                    <div class="mdc-checkbox__mixedmark"></div>
                                                </div>
                                                <div class="mdc-checkbox__ripple"></div>
                                            </div>
                                        @endif
                                    </th> --}}
                                    <th></th>
                                    <th>N° Orden</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Valor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col s12">
                <a class="mdc-button mdc-button--raised mdc-button--large mb-1 aprobar-varias" id="imprimir_pedidos" href="#" target="_blank">
                    <span class="mdc-button__label mr-1">Imprimir Pedidos</span>
                    <i class="fas fa-print"></i>
                </a>
                <button class="mdc-button mdc-button--raised mdc-button--large aprobar-varias mb-1" id="pedido_en_ruta" type="submit" disabled>
                    <span class="mdc-button__label mr-1">Pedidos En Ruta</span>
                    <i class="fal fa-motorcycle"></i>
                </button>
                <button class="mdc-button mdc-button--raised mdc-button--large aprobar-varias mb-1" id="pedido_despachado" type="submit" disabled>
                    <span class="mdc-button__label mr-1">Pedidos Entregados</span>
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="mdc-snackbar">
        <div class="mdc-snackbar__surface">
            <div class="mdc-snackbar__label" role="status" aria-live="polite">Hay errores en las fechas.</div>
            <div class="mdc-snackbar__actions">
                <button type="button" class="mdc-button mdc-snackbar__action">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label">
                        <i class="fas fa-times send"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#pedidos-misPedidos').addClass('mdc-list-item--active');

            const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                return new mdc.textField.MDCTextField(el);
            });

            const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));
            const selectEstado = new mdc.select.MDCSelect(document.querySelector('#mdc-select-estado'));

            /////////////////////// CARGA DE LA CARD PEDIDOS POR DESPACHAR ///////////////////////
            $('#numero_pedidos').text('-');

            var urlMisPedidos = '{!! route('ajax.misPedidos.dash.buscar') !!}';

            $.ajax({
                'url': urlMisPedidos
            }).done(function(response) {
                console.log(response);

                $('#numero_pedidos').text(response.pedidos[0].misPedidos);
            });

            function sendRequest() {
                $.ajax({
                    'url': urlMisPedidos
                }).done(function(response) {
                    console.log(response.pedidos[0]);

                    $('#numero_pedidos').text(response.pedidos[0].misPedidos);
                });
            };

            setInterval(sendRequest, 60000);
            ////////////////////////////////////////////////////////////////////////////////////////////

            // Asigna la fecha de entrega mínima para el siguiente día
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if(dd < 10){
                dd = '0' + dd;
            }
            if(mm < 10){
                mm = '0' + mm;
            }
            today = yyyy+'-'+mm+'-'+dd;
            // console.log(today);
            $('#fecha_inicial').attr('max', today);
            $('#fecha_final').attr('min', today);
            $('#fecha_final').attr('max', today);

            $('#fecha_inicial').change(function(){
                $('#fecha_final').attr('min', $('#fecha_inicial').val());
            });

            var pedidos = [];
            var urlBuscarMisPedidos = '{!! route('ajax.misPedidos.fechas.buscar', ['inicio' => 'incio', 'fin' => 'fin', 'estado' => 'estado']) !!}';
            var urlVerPedido = '{!! route('pedidos.show', ['id' => 'null']) !!}'.replace('/null', '/');

            @if($usuario->nivel == 'u_ventadirecta' || $usuario->nivel == 'u_callcenter' || $usuario->nivel == 'u_administrador')
                $('#buscar_pedidos').attr('disabled', 'disabled');
                $('#buscar_pedidos .send').hide();
                $('#buscar_pedidos .sending').show();
                $('#buscar_pedidos .cargando').show();
                obtenerPedidos();
            @endif

            function obtenerPedidos() {
                $('#listado_pedidos').show();
                let urlBuscar2 = urlBuscarMisPedidos.replace('incio', $('#fecha_inicial').val());
                urlBuscar2 = urlBuscar2.replace('fin', $('#fecha_final').val());
                urlBuscar2 = urlBuscar2.replace('estado', $('#estado').val());
                // console.log(urlBuscar2);
                $.ajax({
                    'url': urlBuscar2,
                    'context': document.body
                }).done(function(response) {
                    // console.log(response.pedidos);
                    $('#pedidos').DataTable({
                        destroy: true,
                        data: response.pedidos,
                        pageLength: 10,
                        order: [],
                        responsive: true,
                        columnDefs: [ {
                            orderable: false,
                            className: 'select-checkbox',
                            targets:   0
                        } ],
                        order: [[ 1, 'asc' ]],
                        columns: [
                            {
                                title: '',
                                data: 'id_comercial',
                                ordering: false,
                                render: function(data, type, row){
                                    return '<input type="checkbox" class="checkbox chk-pedido" data-pedido="' + data + '">';
                                }
                            },
                            {
                                title: 'N° Orden',
                                data: 'id_comercial',
                                render: function(data, type, row){
                                    if (data) {
                                        return ' <a href="' + urlVerPedido + data + '" class="link primary underline">' + data + '</a>';

                                    } else {
                                        return '';
                                    }
                                }
                            },
                            {
                                title: 'Estado',
                                data: 'estado',
                                render: function(data, type, row){
                                    if (data) {
                                        switch (data) {
                                            case '00' :
                                                return 'Pendiente';

                                            case '10' :
                                                return 'En Ruta';

                                            case '11' :
                                                return 'Entregado';
                                        }

                                    } else {
                                        return '';
                                    }
                                }
                            },
                            {
                                title: 'Fecha',
                                data: 'fecha_ingreso'
                            },
                            {
                                title: 'Cliente',
                                data: 'nombre_cliente_vd',
                                className: 'capitalize',
                                render: function(data, type, row){
                                    if (data) {
                                        return data.toLowerCase();
                                    } else {
                                        if (row.nombre_cliente) {
                                            return row.nombre_cliente.toLowerCase();
                                        } else {
                                            return '';
                                        }
                                    }
                                }
                            },
                            {
                                title: 'Valor',
                                data: 'total_pedido',
                                className: 'right-align',
                                render: function(data, type, row){
                                    if (!data) {
                                        data = 0;
                                    }
                                    return '$ ' + numeroMiles(data.toFixed(numDecimales));
                                }
                            }
                        ],
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

                    $('#total_ventas').text('$ ' + numeroMiles(response.ventas.toFixed(numDecimales)));
                    $('#total_kilos').text(numeroMiles(parseFloat(response.kilos.toFixed(2))) + ' Kg');
                    $('#total_unidades').text(numeroMiles(response.unidades) + ' Uds');

                    // console.log(response.pedidos);
                    $('#buscar_pedidos').removeAttr('disabled');
                    $('#buscar_pedidos .send').show();
                    $('#buscar_pedidos .sending').hide();

                    // Cambia la ruta de impresion cada que se hace clic en un checkbox

                    $('.chk-pedido').on('click', function(){

                        var urlPdfMulti = '{!! route('pedidos.multiPdf', ['pedidos' => 'idpedidos']) !!}';
                        var pedidosChk = [];
                        var urlpdfm;

                        $('.chk-pedido:checked').each( function() {
                            pedidosChk.push($(this).data('pedido'));
                        });

                        if (pedidosChk.length)
                        {
                            urlpdfm = urlPdfMulti.replace('idpedidos', pedidosChk);
                        } else {
                            urlpdfm = '#';
                        }


                        $('.imprimir_pedidos').attr('href', urlpdfm);
                    });
                });
            }

            if($('#fecha_inicial').val() && $('#fecha_final').val() && ($('#fecha_inicial').val() < $('#fecha_final').val())) {
                obtenerPedidos();
            }

            $('#buscar_pedidos').on('click', function(){
                if($('#fecha_inicial').val() && $('#fecha_final').val() && ($('#fecha_inicial').val() <= $('#fecha_final').val())) {
                    $(this).attr('disabled', 'disabled');
                    $('#buscar_pedidos .send').hide();
                    $('#buscar_pedidos .sending').show();
                    $('#buscar_pedidos .cargando').show();
                    obtenerPedidos();
                } else {
                    snackbar.open();
                }
            });

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

            //Trae los pedidos del día al cargar el módulo
            obtenerPedidos();
            //////////////////////////////////////////////
        });

        var urlPdfMulti = '{!! route('pedidos.multiPdf', ['pedidos' => 'idpedidos']) !!}';
        var pedidosChk = [];

        $(document).on('change', '.chk-pedido', function(){
            urlPdfMulti = '{!! route('pedidos.multiPdf', ['pedidos' => 'idpedidos']) !!}';
            pedidosChk = [];

            if($('.chk-pedido:checked').length > 0){
                $('.aprobar-varias').removeAttr('disabled');

                $('.chk-pedido:checked').each( function() {
                    pedidosChk.push($(this).data('pedido'));
                });
                urlpdfm = urlPdfMulti.replace('idpedidos', pedidosChk);
                $('#imprimir_pedidos').attr('href', urlpdfm);
            }
            else {
                $('.aprobar-varias').attr('disabled', 'disabled');
                $('#imprimir_pedidos').attr('href', '#');
            }
        });

        //pedidos en ruta
        var urlPedidoRutaMulti = '{!! route('misPedidos.enRutaMulti') !!}';
        var pedidosChk = []

        $('#pedido_en_ruta').on('click', function(){
            $('.chk-pedido:checked').each( function() {
                pedidosChk.push($(this).data('pedido'));
            });

            $.ajax({
                url : urlPedidoRutaMulti,
                method : 'POST',
                dataType: "json",
                data : {
                    'pedidos': JSON.stringify(pedidosChk)
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                location.reload();
            });

            pedidosChk = []
        });

        //pedidos entregados
        var urlPedidoEntregadoMulti = '{!! route('misPedidos.entregadosMulti') !!}';
        var pedidosChk = []

        $('#pedido_despachado').on('click', function(){
            $('.chk-pedido:checked').each( function() {
                pedidosChk.push($(this).data('pedido'));
            });

            $.ajax({
                url : urlPedidoEntregadoMulti,
                method : 'POST',
                dataType: "json",
                data : {
                    'pedidos': JSON.stringify(pedidosChk)
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(response) {
                location.reload();
            });

            pedidosChk = []
        });
    </script>
@endsection

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
    <div class="container-full">
        <div class="row">
            <div class="col s12 l6">
                <h1 class="title">Listado de Pedidos</h1>
                <div class="breadcrumbs full-width">
                    <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                    <a class="breadcrumb">Pedidos</a>
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
            <div class="col s12 l8 xl9">
                <div class="card mb-0">
                    <div class="card-content">
                        <div class="row mb-0">
                            <div class="col s12 m4 xl5">
                                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--filled mdc-text-field--label-floating mdc-text-field--dense">
                                    <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_inicial" id="fecha_inicial" value="{{ $hoy->toDateString() }}">
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
                            <div class="col s12 m4 xl2 mt-1-s">
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
            </div>
        </div>
        <div class="row mb-0 mt-3" id="listado_pedidos" class="display responsive" width="100%" style="width:100%">
            <div class="col s12">
                <div class="card mb-0">
                    <div class="card-content">
                        <table id="pedidos" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N° Orden</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    @if($usuario->nivel == 'u_administrador')
                                        <th class="center">Vendedor</th>
                                    @endif
                                    <th>Cliente</th>
                                    <th>Valor</th>
                                    <th>Abono</th>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('#pedidos-index').addClass('mdc-list-item--active');

            const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                return new mdc.textField.MDCTextField(el);
            });

            const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));

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
            console.log(today);
            $('#fecha_inicial').attr('max', today);
            $('#fecha_final').attr('min', today);
            $('#fecha_final').attr('max', today);

            $('#fecha_inicial').change(function(){
                $('#fecha_final').attr('min', $('#fecha_inicial').val());
            });

            var pedidos = [];
            var urlBuscarPedidos = '{!! route('ajax.pedidos.fechas.buscar', ['inicio' => 'incio', 'fin' => 'fin']) !!}';
            var urlBuscarTotales = '{!! route('ajax.pedidos.totales', ['inicio' => 'incio', 'fin' => 'fin']) !!}';
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
                let urlBuscar2 = urlBuscarPedidos.replace('incio', $('#fecha_inicial').val());
                urlBuscar2 = urlBuscar2.replace('fin', $('#fecha_final').val());
                $.ajax({
                    'url': urlBuscar2,
                    'context': document.body
                }).done(function(response) {
                    console.log(response.pedidos);
                    $('#pedidos').DataTable({
                        destroy: true,
                        data: response.pedidos,
                        pageLength: 10,
                        order: [],
                        responsive: true,
                        @if($usuario->nivel == 'u_administrador')
                            columnDefs: [
                                { responsivePriority: 1, targets: 0 },
                                { responsivePriority: 2, targets: 1 },
                                { responsivePriority: 3, targets: 3 },
                                { responsivePriority: 4, targets: 4 },
                                { responsivePriority: 5, targets: 5 },
                                { orderable: false, targets: [7] },
                                { searchable: false, targets: [7] },
                                { visible: false, targets: [7] }
                            ],
                        @else
                            columnDefs: [
                                { responsivePriority: 1, targets: 0 },
                                { responsivePriority: 2, targets: 1 },
                                { responsivePriority: 3, targets: 3 },
                                { responsivePriority: 4, targets: 4 },
                                { orderable: false, targets: [6] },
                                { searchable: false, targets: [6] },
                                { visible: false, targets: [6] }
                            ],
                        @endif
                        columns: [
                            {
                                title: 'N° Orden',
                                data: 'id_comercial'
                            },
                            {
                                title: 'Estado',
                                data: 'estado',
                                render: function(data, type, row){
                                    let icon = '';
                                    if (row.latitud != 0 && row.latitud != '' && row.longitud != 0 && row.longitud != '') {
                                        icon = ' <i class="fas fa-map-marker-alt ml-1"></i>';
                                    }
                                    if (data) {
                                        return 'Cerrado' + icon;
                                    } else {
                                        return 'Abierto' + icon;
                                    }
                                }
                            },
                            {
                                title: 'Fecha',
                                data: 'fecha_ingreso'
                            },
                            @if($usuario->nivel == 'u_administrador')
                                {
                                    title: 'Vendedor',
                                    data: 'codigo_vendedor',
                                    className: 'center'
                                },
                            @endif
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
                            },
                            {
                                title: 'Abono',
                                data: 'abono',
                                className: 'right-align',
                                render: function(data, type, row){
                                    if (!data) {
                                        data = 0;
                                    }
                                    return '$ ' + numeroMiles(data.toFixed(numDecimales));
                                }
                            },
                            {
                                title: '',
                                data: 'id_comercial',
                                ordering: false,
                                render: function(data, type, row){
                                    return '<a class="link_pedido" href="'+ urlVerPedido + data +'"></a>';
                                }
                            }
                        ],
                        rowCallback: function(row, data) {
                            $(row).addClass('clickable').attr('data-href', urlVerPedido + data['id_comercial']);
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

                    $('#total_ventas').text('$ ' + numeroMiles(response.ventas.toFixed(numDecimales)));
                    $('#total_kilos').text(numeroMiles(parseFloat(response.kilos.toFixed(2))) + ' Kg');
                    $('#total_unidades').text(numeroMiles(response.unidades) + ' Uds');

                    // console.log(response.pedidos);
                    $('#buscar_pedidos').removeAttr('disabled');
                    $('#buscar_pedidos .send').show();
                    $('#buscar_pedidos .sending').hide();
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

            $('#pedidos tbody').on('click', 'tr.clickable', function () {
                var link = $(this).data('href');
                window.location = link;
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
        });
    </script>
@endsection

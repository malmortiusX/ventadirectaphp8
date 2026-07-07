@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leafletjs/leaflet.css') }}">
    <style>
        #map {
            width: 100%;
            height: 180px;
            box-shadow: 5px 5px 5px #888;
        }

        #map_cliente {
            width: 100%;
            height: 150px;
        }
    </style>
@endsection

@section('content')
    @php
        setlocale(LC_ALL, 'es_ES', 'es', 'ES');
    @endphp
    <form action="
    @if ($pedido->estado == 1 && $pedido->en_ruta == 0 && $pedido->despachado == 0)
        {{ route('pedidos.enRuta', ['id' => $pedido->id_comercial]) }}
    @elseif ($pedido->estado == 1 && $pedido->en_ruta == 1 && $pedido->despachado == 0)
        {{ route('pedidos.despachado', ['id' => $pedido->id_comercial]) }}
    @endif
    " method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 l4">
                    <h1 class="title">Pedido N° {{ $pedido->id_comercial }}</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.index') }}" class="breadcrumb">Pedidos</a>
                        <a class="breadcrumb"># {{ $pedido->id_comercial }}</a>
                    </div>
                </div>
                <div class="col l8 right-align">
                    @if ($pedido->estado == 1 && $pedido->en_ruta == 0 && $pedido->despachado == 0)
                    <button class="mdc-button mdc-button--raised mdc-button--large pedido_en_ruta mb-1" id="pedido_en_ruta" type="submit">
                        <span class="mdc-button__label mr-1">Pedido En Ruta</span>
                        <i class="fal fa-motorcycle"></i>
                    </button>
                    @endif
                    @if ($pedido->estado == 1 && $pedido->despachado == 0)
                    <button class="mdc-button mdc-button--raised mdc-button--large pedido_despachado mb-1" id="pedido_despachado" type="submit">
                        <span class="mdc-button__label mr-1">Pedido Entregado</span>
                        <i class="fas fa-check"></i>
                    </button>
                    @endif
                    @if ($usuario->nivel == 'u_ventadirecta')
                        <a class="mdc-button mdc-button--raised mdc-button--large mb-1" href="{{ route('abonos.create', ['valor' => $pedido->valor_total]) }}">
                            <span class="mdc-button__label mr-1">Realizar Abono</span>
                            <i class="fas fa-dollar-sign"></i>
                        </a>
                    @endif
                    <a class="mdc-button mdc-button--raised mdc-button--large mb-1" href="{{ route('pedidos.pdf', ['id' => $pedido->id_comercial]) }}" target="_blank">
                        <span class="mdc-button__label mr-1">Imprimir</span>
                        <i class="fas fa-print"></i>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 l3">
                    <div class="row">
                        @if (!$pedido->clienteVd)
                            <div class="col s12">
                                <div class="card highlighted">
                                    <div class="card-content">
                                        <span class="card-title mb-1">Datos del Cliente</span>
                                        <div class="row mb-0">
                                            <input type="number" class="hide" name="estado" id="estado" value="0">
                                            <div class="col s12 mb-2">
                                                <label>Nombre Completo</label>
                                                <span class="card-subtitle highlighted capitalize">{{ ($pedido->nombre_cliente_vd == "" ? mb_strToLower($pedido->cliente->nombre_cliente) : mb_strToLower($pedido->nombre_cliente_vd)) }}</span>
                                            </div>
                                            <div class="col s4 xl5 mb-2">
                                                <label>Lista</label>
                                                <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $pedido->cliente->lista_precio }}</span>
                                            </div>
                                            <div class="col s8 xl7 mb-2">
                                                <label>Cupo</label>
                                                <span class="card-subtitle subtitle-3 highlighted capitalize">$ {{ number_format($pedido->cliente->cupo, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="col s12 xl6 mb-2">
                                                <label>CC / NIT</label>
                                                <span class="card-subtitle subtitle-3 highlighted capitalize">{{ ($pedido->cedula_cliente_vd == "" ? $pedido->cliente->cc_nit : mb_strToLower($pedido->cedula_cliente_vd)) }}</span>
                                            </div>
                                            <div class="col s12 xl6 mb-2">
                                                <label>Teléfono</label>
                                                <span class="card-subtitle subtitle-3 highlighted capitalize">{{ ($pedido->telefono_cliente_vd == "" ? $pedido->cliente->telefono : mb_strToLower($pedido->telefono_cliente_vd)) }}</span>
                                            </div>
                                            <div class="col s12 mb-0">
                                                <label>Dirección</label>
                                                <span class="card-subtitle subtitle-3 highlighted capitalize">{{ ($pedido->direccion_cliente_vd == "" ? mb_strToLower($pedido->cliente->direccion) : mb_strToLower($pedido->direccion_cliente_vd)) }}</span>
                                            </div>
                                            @if($pedido->cliente->longitud && $pedido->cliente->latitud)
                                                <div class="col s12 mt-1 mapa_cliente">
                                                    <div id="map_cliente"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($usuario->nivel == 'u_ventadirecta')
                        <div class="col s12 m12">
                            <div class="card highlighted bg-primary white-text">
                                <div class="card-content full-height d-flex f-column justify-content-center">
                                    <label class="center">Abono</label>
                                    <span class="card-title highlighted center" id="valor_pedido">$ {{ number_format($pedido->abono, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col {{ ($usuario->nivel == 'u_ventadirecta' || ($usuario->nivel == 'u_callcenter' && $pedido->clienteVd)) ? 's6 m12' : 's12' }}">
                            <div class="card highlighted">
                                <div class="card-content">
                                    <span class="card-title mb-2">Opciones del Pedido</span>
                                    <div class="row mb-0">
                                        <input type="number" class="hide" name="estado" id="estado" value="0">
                                        <div class="col s12 mb-1">
                                            <label>Centro de Distribución</label>
                                            <span class="card-subtitle highlighted capitalize">{{ strToLower($pedido->centroDist->nombre) }}</span>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <label>Enrutamiento</label>
                                            <span class="card-subtitle subtitle-3 highlighted">Cerrado {{ $pedido->en_ruta ? 'en Ruta' : 'Fuera de Ruta' }}</span>
                                        </div>
                                        <div class="col {{ $pedido->orden ? 's8' : 's12' }} mb-1">
                                            <label>Fecha de Entrega</label>
                                            <span class="card-subtitle subtitle-3 highlighted">
                                                    @switch(floor((time() - strtotime($pedido->fecha_entrega)) / (60 * 60 * 24)))
                                                        @case(-1)
                                                            <span class="hide">{{ date('Ymd' ,strtotime($pedido->fecha_entrega)) }}</span>Mañana
                                                            @break

                                                        @case(0)
                                                            <span class="hide">{{ date('Ymd' ,strtotime($pedido->fecha_entrega)) }}</span>Hoy
                                                            @break

                                                        @case(1)
                                                        <span class="hide">{{ date('Ymd' ,strtotime($pedido->fecha_entrega)) }}</span>Ayer
                                                            @break

                                                        @default
                                                            <span class="hide">{{ date('Ymd' ,strtotime($pedido->fecha_entrega)) }}</span>{{ $entrega->formatLocalized("%d de %B") }}
                                                    @endswitch
                                            </span>
                                        </div>
                                        @if ($pedido->orden)
                                            <div class="col s4 mb-1">
                                                <label>Orden</label>
                                                <span class="card-subtitle highlighted capitalize">{{ $pedido->orden }}</span>
                                            </div>
                                        @endif
                                        <div class="col s12">
                                            <label>Observaciones</label>
                                            <span class="card-subtitle subtitle-3 highlighted">{{ (!$pedido->observacion_pedido || $pedido->observacion_pedido == ' ' || strlen($pedido->observacion_pedido) == 0) ? 'No hay observaciones' : $pedido->observacion_pedido }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($usuario->nivel == 'u_ventadirecta' || $pedido->clienteVd)
                            <div class="col s6 m12">
                                <div class="card highlighted mb-0">
                                    <div class="card-content">
                                        <span class="card-title mb-3">Datos del Cliente</span>
                                        <div class="row mb-0" id="data_clientevd">
                                            <div class="col s12 mb-1">
                                                <label>Nombre</label>
                                                <span class="card-subtitle highlighted" id="nombre_clientevd">{{ $pedido->nombre_cliente_vd }}</span>
                                            </div>
                                            <div class="col {{ $pedido->cedula_cliente_vd ? 's12 m6' : 's12' }} mb-1" id="div-telefono_clientevd">
                                                <label>Teléfono</label>
                                                <span class="card-subtitle subtitle-3 highlighted" id="telefono_clientevd">{{ $pedido->telefono_cliente_vd }}</span>
                                            </div>
                                            <div class="col s12 m6 mb-1" id="div-cedula_clientevd" @if(!$pedido->cedula_cliente_vd) style="display: none;" @endif>
                                                <label>Cédula</label>
                                                <span class="card-subtitle subtitle-3 highlighted truncate" id="cedula_clientevd">{{ $pedido->cedula_cliente_vd ? $pedido->cedula_cliente_vd : '' }}</span>
                                            </div>
                                            <div class="col s12 mb-1">
                                                <label>Dirección</label>
                                                <span class="card-subtitle subtitle-3 highlighted" id="direccion_clientevd">{{ substr($pedido->direccion_cliente_vd, 0, strpos($pedido->direccion_cliente_vd, ' B. ')) }}</span>
                                                <span class="card-subtitle subtitle-3 highlighted" id="barrio_clientevd">{{ substr($pedido->direccion_cliente_vd, strpos($pedido->direccion_cliente_vd, ' B. ') + 3) }}</span>
                                            </div>
                                            <div class="col s12 {{ $pedido->clienteVd->correo_electronico ? 'mb-1' : ''}}">
                                                <label>Ciudad</label>
                                                <span class="card-subtitle subtitle-3 highlighted capitalize" id="ciudad_clientevd">{{ $pedido->ciudad_cliente_vd }}</span>
                                            </div>
                                            <div class="col s12" id="div-correo_electronico_clientevd" @if(!$pedido->clienteVd->correo_electronico) style="display: none;" @endif>
                                                <label>Correo Electrónico</label>
                                                <span style="color: rgba(0, 0, 0, 0.87);" class="card-subtitle subtitle-4 highlighted truncate" id="correo_electronico_clientevd">{{ $pedido->clienteVd->correo_electronico ? strToLower($pedido->clienteVd->correo_electronico) : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col s12 l9">
                    <div class="row mb-0 full-row">
                        <div class="col s12 l8">
                            <div class="card highlighted">
                                <div class="card-content full-height d-flex f-column justify-content-center">
                                    <label>Creador del Pedido</label>
                                    <span class="card-title highlighted capitalize">{{ strToLower($pedido->creador->nombres .' '. $pedido->creador->apellidos) }}</span>
                                    <div class="row mb-0">
                                        <div class="col s6">
                                            <label>Fecha de Ingreso</label>
                                            <span class="card-subtitle highlighted">{{ date('d/m h:i a', strtotime($pedido->fecha_ingreso)) }}</span>
                                        </div>
                                        <div class="col s6 right-align">
                                            <label>Fecha de Cierre</label>
                                            <span class="card-subtitle highlighted right-align">{{ date('d/m h:i a', strtotime($pedido->fecha_cierre)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <div class="card highlighted bg-primary white-text">
                                <div class="card-content full-height d-flex f-column justify-content-center">
                                    <label class="center">Valor del Pedido</label>
                                    <span class="card-title highlighted center" id="valor_pedido">$ {{ number_format($pedido->productos->sum('pivot.total'), App\Models\TblEmpresa::first()->decimales, ',', '.') }}</span>
                                    <div class="row mb-0">
                                        <div class="col s8">
                                            <label>Estado</label>
                                            <span class="card-subtitle highlighted" id="estado_pedido">Cerrado</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label># Items</label>
                                            <span class="card-subtitle highlighted right-align" id="items_pedido">{{ $pedido->productos->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 mb-0">
                            <div class="card mb-0" style="position: inherit">
                                <div class="card-content">
                                    <span class="card-title mb-3">Listado de Productos</span>
                                    <table id="productos" class="display responsive" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th></th>
                                                <th>Kg</th>
                                                <th>Uds</th>
                                                <th>UM</th>
                                                <th>Valor</th>
                                                <th>Dcto</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->productos as $producto)
                                                <tr class="item-producto">
                                                    <td>{{ $producto->codigo }}</td>
                                                    <td style="text-transform: capitalize;">{{ str_replace('+', ' + ', strtolower($producto->nombre)) }}</td>
                                                    <td>
                                                        @if($producto->pivot->obsequio)
                                                            <i aria-describedby="tooltip-obsequio_{{ $producto->codigo }}" class="fas fa-gift mr-1"></i><div id="tooltip-obsequio_{{ $producto->codigo }}" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">Este producto es un obsequio</div></div>
                                                        @endif
                                                        @if($producto->pivot->tiquetear)
                                                            <i aria-describedby="tooltip-tiquetear_{{ $producto->codigo }}" class="fas fa-tag mr-1"></i><div id="tooltip-tiquetear_{{ $producto->codigo }}" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">El producto se debe tiquetear</div></div>
                                                        @endif
                                                    </td>
                                                    <td class="center">{{ intval($producto->pivot->peso) == $producto->pivot->peso ? number_format($producto->pivot->peso, 0, ',', '.') : number_format($producto->pivot->peso, 2, ',', '.') }}</td>
                                                    <td class="center">{{ number_format($producto->pivot->unidades, 0, ',', '.') }}</td>
                                                    <td class="center">{{ $producto->pivot->venta_por }}</td>
                                                    <td class="right-align">$ {{ ($producto->pivot->venta_por == 'UN' || $producto->pivot->venta_por == 'UN ') ? number_format($producto->pivot->valor_un, App\Models\TblEmpresa::first()->decimales, ',', '.') : number_format($producto->pivot->valor_kg, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</td>
                                                    <td class="right-align">${{ number_format($producto->pivot->descuento, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</td>
                                                    <td class="subtotal-producto right-align">$ {{ number_format($producto->pivot->total, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($pedido->longitud && $pedido->latitud)
                        <div class="row mb-0">
                            <div class="col s12">
                                <div id="map"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/leafletjs/leaflet.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var latitud = {{ $pedido->latitud ? $pedido->latitud : 0 }};
            var longitud = {{ $pedido->longitud ? $pedido->longitud : 0 }};
            var precision = {{ $pedido->precision ? $pedido->precision : 0 }};
            $('#pedidos-index').addClass('mdc-list-item--active');
            $('#productos').DataTable({
                pageLength: 10,
                order: [],
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 1 },
                    { responsivePriority: 2, targets: 8 },
                    { responsivePriority: 3, targets: 0 },
                    { orderable: false, targets: [2] },
                    { searchable: false, targets: [2, 3, 4, 5, 6, 7, 8] }
                ],
                language: {
                    'sProcessing':    'Procesando...',
                    'sLengthMenu':    'Mostrar _MENU_ registros',
                    'sZeroRecords':   'No se encontraron resultados',
                    'sEmptyTable':    'No se han agregado productos',
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

            @if($pedido->longitud && $pedido->latitud)
                var map = L.map('map').setView([latitud, longitud], 13);
                L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                L.control.scale().addTo(map);
                L.marker([latitud, longitud]).addTo(map);
                if (precision >! 0) {
                    L.circle([latitud, longitud], precision).addTo(map);
                }
            @endif

            @if($pedido->cliente->longitud && $pedido->cliente->latitud)
                var mapCliente = L.map('map_cliente').setView([{{ $pedido->cliente->latitud }} , {{ $pedido->cliente->longitud }} ], 13);
                L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',).addTo(mapCliente);
                L.control.scale().addTo(mapCliente);
                L.marker([{{ $pedido->cliente->latitud }} , {{ $pedido->cliente->longitud }} ]).addTo(mapCliente);
                if ({{ $pedido->cliente->precision }} >! 0) {
                    L.circle([{{ $pedido->cliente->latitud }} , {{ $pedido->cliente->longitud }} ], {{ $pedido->cliente->precision }} ).addTo(mapCliente);
                }
            @endif


            // Cambiar el estado del pedido a despachado
            $('.pedido_en_ruta').click(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Cambiar estado del pedido?',
                    text: "Una vez modificado el estado del pedido no se podrá modificar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0000',
                    confirmButtonText: 'Si, cambiar estado del pedido!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form').submit();
                    }
                });
            });


            // Cambiar el estado del pedido a despachado
            $('.pedido_despachado').click(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Cambiar estado del pedido?',
                    text: "Una vez modificado el estado del pedido no se podrá modificar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff0000',
                    confirmButtonText: 'Si, cambiar estado del pedido!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form').submit();
                    }
                });
            });

        });
    </script>
@endsection

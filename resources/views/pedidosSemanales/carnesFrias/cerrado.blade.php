@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
    <style>
        #map { 
            width: 100%;
            height: 180px;
            box-shadow: 5px 5px 5px #888;
        }
    </style>
@endsection

@section('content')
    @php
        setlocale(LC_TIME, "spanish");
        setlocale(LC_MONETARY, 'it_IT');
    @endphp
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12">
                    <h1 class="title">P. Semanal Carnes Frías N° {{ $pedido->id_pedido }}</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.semanales.index') }}" class="breadcrumb">Pedidos Semanales</a>
                        <a class="breadcrumb">Carnes Frías Semana {{ $pedido->semana }} / {{ $pedido->ano }}</a>
                    </div>
                </div>
                <!--div class="col l6 right-align">
                    <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('pedidos.pdf', ['id' => $pedido->id_pedido]) }}" target="_blank">
                        <span class="mdc-button__label">Imprimir</span>
                        <i class="fas fa-print"></i>
                    </a>
                </div-->
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted">
                        <div class="card-content full-height">
                            <div class="row mb-0 full-row">
                                <div class="col s12 m6 center border-right pr-card noborder-s">
                                    <label>Vendedor del Pedido</label>
                                    <span class="card-title subtitle-1 highlighted capitalize">{{ $pedido->vendedor->codigo_vendedor .' - '. strToLower($pedido->vendedor->nombres .' '. $pedido->vendedor->apellidos) }}</span>
                                    <div class="row mb-0">
                                        <div class="col s8 left-align">
                                            <label>Creador</label>
                                            <span class="card-subtitle subtitle-3 highlighted capitalize">{{ strToLower($pedido->usuario->nombres .' '. $pedido->usuario->apellidos) }}</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label>Fecha de Ingreso</label>
                                            <span class="card-subtitle subtitle-3 highlighted right-align" id="estado_pedido">{{ date('d/m/Y', strtotime($pedido->fecha_ingreso)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 center border-left pl-card noborder-s">
                                    <label>Año - Semana</label>
                                    <span class="card-title subtitle-1 highlighted center">{{ $pedido->ano .' - '. $pedido->semana }}</span>
                                    <div class="row mb-0">
                                        <div class="col s8 left-align">
                                            <label>Planta</label>
                                            <span class="card-subtitle subtitle-3 highlighted capitalize">{{ strToLower($pedido->centroDist->nombre) }}</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label>Estado</label>
                                            <span class="card-subtitle subtitle-3 highlighted right-align" id="estado_pedido">{{ $pedido->estado ? 'Cerrado' : 'Abierto' }}</span>
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
                                    <table id="productos_semanales" class="display responsive" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th class="center">Factor</th>
                                                <th class="center">Lun</th>
                                                <th class="center">Mar</th>
                                                <th class="center">Mié</th>
                                                <th class="center">Jue</th>
                                                <th class="center">Vie</th>
                                                <th class="center">Sab</th>
                                                <th class="center">Dom</th>
                                                <th class="center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedido->productos as $producto)
                                                <tr class="item-producto">
                                                    <td> {{ $producto->codigo }}</td>
                                                    <td class="capitalize">{{ str_replace('+', ' + ', strtolower($producto->nombre)) }}</td>
                                                    <td class="center"> {{ $producto->peso_unidad }}</td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->ulu * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->ulu, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->uma * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->uma, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->umi * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->umi, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->uju * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->uju, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->uvi * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->uvi, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->usa * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->usa, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format($producto->pivot->udo * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format($producto->pivot->udo, 0, ',', '.') }} Un
                                                    </td>
                                                    <td class="right-align">
                                                        {{ number_format(($producto->pivot->ulu + $producto->pivot->uma + $producto->pivot->umi + $producto->pivot->uju + $producto->pivot->uvi + $producto->pivot->usa + $producto->pivot->udo) * $producto->peso_unidad, 1, ',', '.') }} Kg<br/>
                                                        {{ number_format(($producto->pivot->ulu + $producto->pivot->uma + $producto->pivot->umi + $producto->pivot->uju + $producto->pivot->uvi + $producto->pivot->usa + $producto->pivot->udo), 0, ',', '.') }} Un
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pedidos-semanales').addClass('mdc-list-item--active');
            $('#productos_semanales').DataTable({
                pageLength: 10,
                order: [],
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: 10 },
                    { orderable: false, targets: [3, 4, 5, 6, 7, 8, 9, 10] },
                    { searchable: false, targets: [3, 4, 5, 6, 7, 8, 9, 10] }
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
        });
    </script>
@endsection
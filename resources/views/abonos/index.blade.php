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
                <h1 class="title">Abonos</h1>
                <div class="breadcrumbs full-width">
                    <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                    <a class="breadcrumb">Abonos</a>
                </div>
            </div>
            <div class="col l6 right-align">
                <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('abonos.create') }}">
                    <span class="mdc-button__label mr-1">Nuevo Abono</span>
                    <i class="fas fa-dollar-sign"></i>
                </a>
            </div>
        </div>
        <div class="row mb-0 mt-3" id="listado_abonos" class="display responsive" width="100%" style="width:100%">
            <div class="col s12">
                <div class="card mb-0">
                    <div class="card-content">
                        <table id="abonos" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N° Abono</th>
                                    <th>Fecha</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuario->cliente->abonos as $abono)
                                    <tr>
                                        <td>{{ $abono->cop . "-" . $abono->prefijo . "-" .  $abono->factura }}</td>
                                        <td>{{ $abono->fecha_abono }}</td>
                                        <td>${{ number_format($abono->abono, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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
            $('#abonos').DataTable({
                destroy: true,
                pageLength: 10,
                responsive: true,
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

            $('#abonos-index').addClass('mdc-list-item--active');

        });
    </script>
@endsection

@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
@endsection

@section('content')
    @php
        setlocale(LC_TIME, "spanish");
        setlocale(LC_MONETARY, 'it_IT');
    @endphp
    <form action="{{ route('descuentos.index') }}" type="GET" id="mainForm">
        <input type="hidden" class="hide" name="perPage" id="perPage" value="{{ Session::get('pagination') }}">
        <div class="container-full">
            <div class="row">
                <div class="col s12 l6">
                    <h1 class="title">Solicitudes de Descuento</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Sol. Descuento</a>
                    </div>
                </div>
                <div class="col l6 right-align mt-2-m">
                    <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('descuentos.create') }}">
                        <span class="mdc-button__label mr-1">Nueva Solicitud</span>
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
            <!--div class="row mb-0">
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
            </div-->
            <div class="row mb-0 mt-3" id="listado_pedidos" class="display responsive" width="100%" style="width:100%">
                <div class="col s12">
                    <div class="card highlighted">
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
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item {{ $estado == 0 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 0 ? 'aria-selected="true"' : '' }} data-value="0" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">Pendiente</span>
                                                </li>
                                                <li class="mdc-list-item {{ $estado == 1 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 1 ? 'aria-selected="true"' : '' }} data-value="1" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">Revisada</span>
                                                </li>
                                                <li class="mdc-list-item {{ $estado == 2 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 2 ? 'aria-selected="true"' : '' }} data-value="2" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">Aprobada</span>
                                                </li>
                                                <li class="mdc-list-item {{ $estado == 3 ? 'mdc-list-item--selected' : '' }}" {{ $estado == 3 ? 'aria-selected="true"' : '' }} data-value="3" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text">Rechazada</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3 mb-2-s">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense" id="mdc-fecha_descuento">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_descuento" name="fecha_descuento" id="fecha_descuento" value="{{ $fechaDescuento }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_fecha_descuento">Fecha de Descuento</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s6 m3">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense {{ $cliente ? 'mdc-select--filled' : '' }}" id="mdc-select-cliente">
                                        <div class="mdc-select__anchor" aria-labelledby="cliente-select-label">
                                            <input type="hidden" name="cliente" id="cliente" class="mdc-select__input-value" value="{{ $cliente }}">
                                            <span id="cliente__selected-text" class="mdc-select__selected-text capitalize"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="cliente-select-label" class="mdc-floating-label {{ $cliente ? 'mdc-floating-label--float-above' : '' }}">Cliente</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                @foreach ($clientes as $index => $auxCliente)
                                                    <li class="mdc-list-item {{ $cliente == $auxCliente->id_cliente ? 'mdc-list-item--selected' : '' }}" {{ $cliente == $auxCliente->id_cliente ? 'aria-selected="true"' : '' }} data-value="{{ $auxCliente->id_cliente }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text capitalize">{{ mb_strtolower($auxCliente->cc_nit .' - '. $auxCliente->nombre_cliente) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3">
                                    <a class="mdc-button mdc-button--raised mdc-button--dense full-width" href="{{ route('descuentos.index', ['fecha_descuento' => date('Y-m-d')]) }}" {{ !$cliente && !$fechaDescuento && $estado > 3 ? 'disabled' : '' }}>
                                        <span class="mdc-button__label">Reiniciar Filtros</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="mdc-data-table mdc-data-table--dense full-width card">
                        <div class="mdc-data-table__table-container">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                    <tr class="mdc-data-table__header-row">
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Id</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Producto</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Cliente</th>
                                        @if ($usuario->nivel == 'u_administrador')
                                            <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Usuario</th>
                                        @endif
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Fecha Descuento</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">%</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Kgs</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Uds</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                    @forelse ($solicitudes as $solicitud)
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell" scope="row">{{ $solicitud->id_solicitud_descuento }}</th>
                                            <td class="mdc-data-table__cell capitalize">{{ mb_strtolower($solicitud->codigo_producto .' - '. $solicitud->nombre_producto) }}</td>
                                            <td class="mdc-data-table__cell capitalize">{{ mb_strtolower($solicitud->nombre_cliente) }}</td>
                                            @if ($usuario->nivel == 'u_administrador')
                                                <td class="mdc-data-table__cell capitalize">{{ mb_strtolower($solicitud->nombre_usuario_solicita) }}</td>
                                            @endif
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric">{{ date('d/m/Y', strtotime($solicitud->fecha)) }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric">{{ number_format($solicitud->porcentaje, 2, ',', '.') }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric">{{ $solicitud->kilos ? number_format($solicitud->kilos, 2, ',', '.') : '---' }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric">{{ $solicitud->unidades ? number_format($solicitud->unidades, 0, ',', '.') : '---' }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__cell--numeric">
                                                @switch($solicitud->estado)
                                                    @case(1)
                                                        <div class="chip-estado noselect white-text center blue" style="min-width: 80px;">Revisada</div>
                                                        @break
                                                    @case(2)
                                                        <div class="chip-estado noselect white-text center green" style="min-width: 80px;">Aprobada</div>
                                                        @break
                                                    @case(3)
                                                        <div class="chip-estado noselect white-text center red" style="min-width: 80px;">Rechazada</div>
                                                        @break
                                                    @default
                                                        <div class="chip-estado noselect white-text center grey" style="min-width: 80px;">Pendiente</div>
                                                @endswitch
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell center" scope="row" colspan="{{ $usuario->nivel == 'u_administrador' ? 9 : 8 }}">No has creado solicitudes de descuento</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($solicitudes->count() > 0)
                            <div class="mdc-data-table__pagination">
                                <div class="mdc-data-table__pagination-trailing full-width row no-margin">
                                    <div class="mdc-data-table__pagination-rows-per-page col s12 m6 mr-0">
                                        <div class="mdc-data-table__pagination-rows-per-page-label">Filas por página</div>
                                        <div class="mdc-select mdc-select--outlined mdc-select--no-label mdc-data-table__pagination-rows-per-page-select" id="select-datatable">
                                            <div class="mdc-select__anchor" role="button" aria-haspopup="listbox" aria-labelledby="demo-pagination-select" tabindex="0">
                                                <span class="mdc-select__selected-text-container">
                                                    <span id="demo-pagination-select" class="mdc-select__selected-text">10</span>
                                                </span>
                                                <span class="mdc-select__dropdown-icon">
                                                    <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                        <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                        <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                    </svg>
                                                </span>
                                                <span class="mdc-notched-outline mdc-notched-outline--notched">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </div>
                                            <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth" role="listbox">
                                                <ul class="mdc-list">
                                                    <li class="mdc-list-item {{ Session::get('pagination') == 10 ? 'mdc-list-item--selected' : '' }}" aria-selected="true" role="option" data-value="10">
                                                        <span class="mdc-list-item__text">10</span>
                                                    </li>
                                                    <li class="mdc-list-item {{ Session::get('pagination') == 25 ? 'mdc-list-item--selected' : '' }}" role="option" data-value="25">
                                                        <span class="mdc-list-item__text">25</span>
                                                    </li>
                                                    <li class="mdc-list-item {{ Session::get('pagination') == 100 ? 'mdc-list-item--selected' : '' }}" role="option" data-value="100">
                                                        <span class="mdc-list-item__text">100</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mdc-data-table__pagination-total">{{ $solicitudes->firstItem() }} ‑ {{ $solicitudes->lastItem() }} de {{ $solicitudes->total() }}</div>
                                    </div>
                                    <div class="mdc-data-table__pagination-navigation col s12 m6 mb-1-s">
                                        @if($solicitudes->hasPages())
                                            <a class="mdc-icon-button mdc-data-table__pagination-button  {{ $solicitudes->onFirstPage() ? 'disabled' : '' }}" href="{{ $solicitudes->withQueryString()->url(1) }}" data-first-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-step-backward"></i></div>
                                            </a>
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $solicitudes->onFirstPage() ? 'disabled' : '' }}" href="{{ $solicitudes->withQueryString()->previousPageUrl() }}" data-prev-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-chevron-left"></i></div>
                                            </a>
                                            @for ($i = $solicitudes->currentPage() - 2; $i <= $solicitudes->currentPage() + 2; $i++)
                                                @if ($i > 0 && $i <= $solicitudes->lastPage())
                                                    <a class="mdc-icon-button mdc-data-table__pagination-button {{ $i == $solicitudes->currentPage() ? 'disabled current' : '' }}" href="{{ $solicitudes->withQueryString()->url($i) }}">
                                                        <div class="mdc-button__icon">{{ $i }}</div>
                                                    </a>
                                                @endif
                                            @endfor
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $solicitudes->hasMorePages() ? '' : 'disabled' }}" href="{{ $solicitudes->withQueryString()->nextPageUrl() }}" data-next-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-chevron-right"></i></div>
                                            </a>
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $solicitudes->hasMorePages() ? '' : 'disabled' }}" href="{{ $solicitudes->withQueryString()->url($solicitudes->lastPage()) }}" data-last-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-step-forward"></i></div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
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
        $('#descuentos').addClass('mdc-list-item--active');

        const dataTable = new mdc.dataTable.MDCDataTable(document.querySelector('.mdc-data-table'));
        @if($solicitudes->count() > 0)
            const selectDatable = new mdc.select.MDCSelect(document.querySelector('#select-datatable'));
            selectDatable.listen('MDCSelect:change', (el) => {
                $('#perPage').val(selectDatable.value);
                $('#mainForm').submit();
            });
        @endif

        const selectEstado = new mdc.select.MDCSelect(document.querySelector('#mdc-select-estado'));
        selectEstado.listen('MDCSelect:change', (el) => {
            $('#estado').val(selectEstado.value);
            $('#mainForm').submit();
        });

        const fechaDescuento = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_descuento'));
        $('.mdc-text-field').on('change', 'input', function() {
            $('#mainForm').submit();
        });

        const selectCliente = new mdc.select.MDCSelect(document.querySelector('#mdc-select-cliente'));
        selectCliente.listen('MDCSelect:change', (el) => {
            $('#cliente').val(selectCliente.value);
            $('#mainForm').submit();
        });

        // Muestra el error de duplicidad
        @if (Session::has('error_solicitud') && \Carbon\Carbon::now()->diffInSeconds(Session::get('error_solicitud')['fecha']) < 10)
            Swal.fire({
                title: '{{ Session::get('error_solicitud')['titulo'] }}',
                text: '{{ Session::get('error_solicitud')['mensaje'] }}',
                icon: 'error'
            });
            @php
                Session::forget('error_solicitud');
            @endphp
        @endif

        //$('.tooltipped').tooltip();
    </script>
@endsection
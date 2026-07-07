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
    <form action="{{ route('sondeos.index') }}" type="GET" id="mainForm">
        <input type="hidden" class="hide" name="perPage" id="perPage" value="{{ Session::get('pagination') }}">
        <div class="container-full">
            <div class="row">
                <div class="col s12 l6">
                    <h1 class="title">Sondeos de Precios</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Sondeos de Precios</a>
                    </div>
                </div>
                <div class="col l6 right-align mt-2-m">
                    <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('sondeos.create') }}">
                        <span class="mdc-button__label mr-1">Nuevo Sondeo</span>
                        <i class="fas fa-search-dollar"></i>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-2">Filtros</span>
                            <div class="row mb-0">
                                <div class="col s6 m3 mb-2 no-line-height">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense full-width {{ $marca ? 'mdc-select--filled' : '' }}" id="mdc-select-marca">
                                        <div class="mdc-select__anchor" aria-labelledby="marca-select-label">
                                            <input type="hidden" name="marca" id="marca" class="mdc-select__input-value" value="{{ $marca ? $marca : '' }}">
                                            <span id="marca__selected-text" class="mdc-select__selected-text capitalize">{{ $marca ? $marca : '' }}</span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="marca-select-label" class="mdc-floating-label {{ $marca ? 'mdc-floating-label--float-above' : '' }}">Marca</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item {{ $marca ? '' : 'mdc-list-item--selected' }}" {{ $marca ? '' : 'aria-selected="true"' }} data-value="" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text"></span>
                                                </li>
                                                @foreach ($marcas as $AuxMarca)
                                                    <li class="mdc-list-item capitalize {{ $marca == $AuxMarca->id ? 'mdc-list-item--selected' : '' }}" {{ $marca == $AuxMarca->id ? 'aria-selected="true"' : '' }} data-value="{{ $AuxMarca->id }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text capitallize">{{ mb_strtolower($AuxMarca->nombre) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3 mb-2 no-line-height">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense full-width {{ $canal ? 'mdc-select--filled' : '' }}" id="mdc-select-canal">
                                        <div class="mdc-select__anchor" aria-labelledby="canal-select-label">
                                            <input type="hidden" name="canal" id="canal" class="mdc-select__input-value" value="{{ $canal ? $canal : '' }}">
                                            <span id="canal__selected-text" class="mdc-select__selected-text capitalize">{{ $canal ? $canal : '' }}</span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="canal-select-label" class="mdc-floating-label {{ $canal ? 'mdc-floating-label--float-above' : '' }}">Canal de Ventas</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item {{ $canal ? '' : 'mdc-list-item--selected' }}" {{ $canal ? '' : 'aria-selected="true"' }} data-value="" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text"></span>
                                                </li>
                                                @foreach ($canales as $AuxCanal)
                                                    <li class="mdc-list-item capitalize {{ $canal == $AuxCanal->id ? 'mdc-list-item--selected' : '' }}" {{ $canal == $AuxCanal->id ? 'aria-selected="true"' : '' }} data-value="{{ $AuxCanal->id }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text capitallize">{{ mb_strtolower($AuxCanal->nombre) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3 mb-2">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--label-floating" id="mdc-fecha_inicial">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_inicial" id="fecha_inicial" name="fecha_inicial" max="{{ $hoy->toDateString() }}" value="{{ $fecha_inicial }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label mdc-floating-label--float-above" id="lbl_fecha_inicial">Fecha Inicial</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s6 m3 mb-2">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--label-floating" id="mdc-fecha_final">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_final" id="fecha_final" name="fecha_final" max="{{ $hoy->toDateString() }}" value="{{ $fecha_final }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label mdc-floating-label--float-above" id="lbl_fecha_final">Fecha Final</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s12 m6 mb-2-s">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense" id="mdc-producto">
                                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_producto" name="producto" id="producto" value="{{ $producto }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_producto">Código o Descripción</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s6 m3 mb-2-s">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense full-width {{ $orden ? 'mdc-select--filled' : '' }}" id="mdc-select-orden">
                                        <div class="mdc-select__anchor" aria-labelledby="orden-select-label">
                                            <input type="hidden" name="orden" id="orden" class="mdc-select__input-value" value="{{ $orden ? $orden .'|'. $sort : '' }}">
                                            <span id="orden__selected-text" class="mdc-select__selected-text capitalize"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="orden-select-label" class="mdc-floating-label {{ $orden ? 'mdc-floating-label--float-above' : '' }}">Ordenar Por</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item capitalize {{ $orden .'|'. $sort == 'pro.codigo|asc' ? 'mdc-list-item--selected' : '' }}" {{ $orden .'|'. $sort == 'pro.codigo|asc' ? 'aria-selected="true"' : '' }} data-value="pro.codigo|asc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Producto</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden .'|'. $sort == 'precio|asc' ? 'mdc-list-item--selected' : '' }}" {{ $orden .'|'. $sort == 'precio|asc' ? 'aria-selected="true"' : '' }} data-value="precio|asc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Precio x Kilo (Asc)</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden .'|'. $sort == 'precio|desc' ? 'mdc-list-item--selected' : '' }}" {{ $orden .'|'. $sort == 'precio|desc' ? 'aria-selected="true"' : '' }} data-value="precio|desc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Precio x Kilo (Desc)</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden .'|'. $sort == 'fecha_sondeo|asc' ? 'mdc-list-item--selected' : '' }}" {{ $orden .'|'. $sort == 'fecha_sondeo|asc' ? 'aria-selected="true"' : '' }} data-value="fecha_sondeo|asc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Más Antiguos Primero</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden .'|'. $sort == 'fecha_sondeo|desc' ? 'mdc-list-item--selected' : '' }}" {{ $orden .'|'. $sort == 'fecha_sondeo|desc' ? 'aria-selected="true"' : '' }} data-value="fecha_sondeo|desc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Más Recientes Primero</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3">
                                    <a class="mdc-button mdc-button--raised mdc-button--dense full-width" href="{{ route('sondeos.index') }}">
                                        <span class="mdc-button__label">Reiniciar Filtros</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-0" id="listado_pedidos" class="display responsive" width="100%" style="width:100%">
                <div class="col s12">
                    <div class="mdc-data-table mdc-data-table--dense full-width card">
                        <div class="mdc-data-table__table-container">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                    <tr class="mdc-data-table__header-row">
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Id</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Producto</th>
                                        @if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_suervisor')
                                            <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Usuario</th>
                                        @endif
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Marca</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Canal</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Fecha</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric nowrap" role="columnheader" scope="col">$ Precio</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric nowrap" role="columnheader" scope="col">$ Gr</th>
                                    </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                    @forelse ($sondeos as $sondeo)
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell" scope="row">{{ $sondeo->id_sondeo }}</th>
                                            <td class="mdc-data-table__cell capitalize">{!! mb_strtolower($sondeo->codigo_producto .'<br>'. $sondeo->producto->nombre) !!}</td>
                                            @if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_suervisor')
                                                <td class="mdc-data-table__cell">{{ $sondeo->usuario->codigo_vendedor ? $sondeo->usuario->codigo_vendedor . ' - ' : '' }}<span class="capitalize">{{ mb_strtolower($sondeo->usuario->nombres .' '. $sondeo->usuario->apellidos) }}</span></td>
                                            @endif
                                            <td class="mdc-data-table__cell capitalize">{{ mb_strtolower($sondeo->marca->nombre) }}</td>
                                            <td class="mdc-data-table__cell capitalize">{{ mb_strtolower($sondeo->canal->nombre) }}</td>
                                            <td class="mdc-data-table__cell">{{ date('d/m/Y', strtotime($sondeo->fecha_sondeo)) }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric nowrap">$ {{ number_format($sondeo->precio, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric nowrap">$ {{ number_format($sondeo->precio_gramo, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell center" scope="row" colspan="{{ $usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_suervisor' ? '8' : '7' }}">No se han encontrado sondeos de precios</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($sondeos->count() > 0)
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
                                        <div class="mdc-data-table__pagination-total">{{ $sondeos->firstItem() }} ‑ {{ $sondeos->lastItem() }} de {{ $sondeos->total() }}</div>
                                    </div>
                                    <div class="mdc-data-table__pagination-navigation col s12 m6 mb-1-s">
                                        @if($sondeos->hasPages())
                                            <a class="mdc-icon-button mdc-data-table__pagination-button  {{ $sondeos->onFirstPage() ? 'disabled' : '' }}" href="{{ $sondeos->withQueryString()->url(1) }}" data-first-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-step-backward"></i></div>
                                            </a>
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $sondeos->onFirstPage() ? 'disabled' : '' }}" href="{{ $sondeos->withQueryString()->previousPageUrl() }}" data-prev-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-chevron-left"></i></div>
                                            </a>
                                            @for ($i = $sondeos->currentPage() - 2; $i <= $sondeos->currentPage() + 2; $i++)
                                                @if ($i > 0 && $i <= $sondeos->lastPage())
                                                    <a class="mdc-icon-button mdc-data-table__pagination-button {{ $i == $sondeos->currentPage() ? 'disabled current' : '' }}" href="{{ $sondeos->withQueryString()->url($i) }}">
                                                        <div class="mdc-button__icon">{{ $i }}</div>
                                                    </a>
                                                @endif
                                            @endfor
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $sondeos->hasMorePages() ? '' : 'disabled' }}" href="{{ $sondeos->withQueryString()->nextPageUrl() }}" data-next-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-chevron-right"></i></div>
                                            </a>
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $sondeos->hasMorePages() ? '' : 'disabled' }}" href="{{ $sondeos->withQueryString()->url($sondeos->lastPage()) }}" data-last-page="true">
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
    <script type="text/javascript">
        $('#sondeos').addClass('mdc-list-item--active');

        const dataTable = new mdc.dataTable.MDCDataTable(document.querySelector('.mdc-data-table'));
        const selectOrden = new mdc.select.MDCSelect(document.querySelector('#mdc-select-orden'));
        const selectMarca = new mdc.select.MDCSelect(document.querySelector('#mdc-select-marca'));
        const selectCanal = new mdc.select.MDCSelect(document.querySelector('#mdc-select-canal'));
        const producto = new mdc.textField.MDCTextField(document.querySelector('#mdc-producto'));
        const fecha_inicial = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_inicial'));
        const fecha_final = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_final'));

        /* Filtros */
        $('#producto').on('change', function() {
            $('#mainForm').submit();
        });

        $('#fecha_inicial').on('change', function() {
            $('#mainForm').submit();
        });

        $('#fecha_final').on('change', function() {
            $('#mainForm').submit();
        });

        selectOrden.listen('MDCSelect:change', (el) => {
            $('#orden').val(selectOrden.value);
            $('#mainForm').submit();
        });

        selectMarca.listen('MDCSelect:change', (el) => {
            $('#marca').val(selectMarca.value);
            $('#mainForm').submit();
        });

        selectCanal.listen('MDCSelect:change', (el) => {
            $('#canal').val(selectCanal.value);
            $('#mainForm').submit();
        });

        @if($sondeos->count() > 0)
            const selectDatable = new mdc.select.MDCSelect(document.querySelector('#select-datatable'));
            selectDatable.listen('MDCSelect:change', (el) => {
                $('#perPage').val(selectDatable.value);
                $('#mainForm').submit();
            });
        @endif

        // Muestra el error de duplicidad
        @if (Session::has('sondeo_creado'))
            let dataSession = JSON.parse('{!! Session::get('sondeo_creado') !!}');
            Swal.fire({
                title: 'Sondeo #' + dataSession.sondeo.id_sondeo + ' creado',
                text: 'El sondeo #' + dataSession.sondeo.id_sondeo + ' del producto ' + dataSession.producto.nombre + ' se ha creado exitosamente.',
                icon: 'success'
            });
            @php
                Session::forget('sondeo_creado');
            @endphp
        @endif

        //$('.tooltipped').tooltip();
    </script>
@endsection
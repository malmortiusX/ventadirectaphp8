@extends('layouts.app')

@section('content')
    <form action="{{ route('productos.index') }}" type="GET" id="mainForm">
        <input type="hidden" class="hide" name="perPage" id="perPage" value="{{ Session::get('pagination') }}">
        <div class="container-full">
            <div class="row">
                <div class="col s12 l6">
                    <h1 class="title">Listado de Productos</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Productos</a>
                    </div>
                </div>
                <div class="col l6 right-align">
                    <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('pedidos.create') }}">
                        <span class="mdc-button__label mr-1">Nuevo Pedido</span>
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
            <div class="row mb-0 mt-3">
                <div class="col s12">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-2">Filtros</span>
                            <div class="row mb-0">
                                <div class="col s6 m4 no-line-height mb-2">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense full-width {{ $orden ? 'mdc-select--filled' : '' }}" id="mdc-select-orden">
                                        <div class="mdc-select__anchor" aria-labelledby="orden-select-label">
                                            <input type="hidden" name="orden" id="orden" class="mdc-select__input-value" value="{{ $orden ? $orden . ',' . $orden2 : '' }}">
                                            <span id="orden__selected-text" class="mdc-select__selected-text capitalize">{{ $orden ? $orden . ',' . $orden2 : '' }}</span>
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
                                                <li class="mdc-list-item capitalize {{ $orden == 'pro.codigo' ? 'mdc-list-item--selected' : '' }}" {{ $orden == 'pro.codigo' ? 'aria-selected="true"' : '' }} data-value="pro.codigo" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Código de Producto</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden == 'pro.nombre' ? 'mdc-list-item--selected' : '' }}" {{ $orden == 'pro.nombre' ? 'aria-selected="true"' : '' }} data-value="pro.nombre" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Nombre de Producto</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden == 'pro.desclinea' ? 'mdc-list-item--selected' : '' }}" {{ $orden == 'pro.desclinea' ? 'aria-selected="true"' : '' }} data-value="pro.desclinea" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Linea de Producto</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden == 'unidades' ? 'mdc-list-item--selected' : '' }}" {{ $orden == 'unidades' ? 'aria-selected="true"' : '' }} data-value="unidades,desc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Unidades Vendidas (Desc)</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden == 'peso' ? 'mdc-list-item--selected' : '' }}" {{ $orden == 'peso' ? 'aria-selected="true"' : '' }} data-value="peso,desc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Kilos Vendidos (Desc)</span>
                                                </li>
                                                <li class="mdc-list-item capitalize {{ $orden == 'total' ? 'mdc-list-item--selected' : '' }}" {{ $orden == 'total' ? 'aria-selected="true"' : '' }} data-value="total,desc" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text capitallize">Total Vendido (Desc)</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m4 mb-2">
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
                                <div class="col s6 m4 mb-2">
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
                                <div class="col s6 m4 mb-2">
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense full-width {{ $linea ? 'mdc-select--filled' : '' }}" id="mdc-select-linea">
                                        <div class="mdc-select__anchor" aria-labelledby="linea-select-label">
                                            <input type="hidden" name="linea" id="linea" class="mdc-select__input-value" value="{{ $linea ? $linea : '' }}">
                                            <span id="linea__selected-text" class="mdc-select__selected-text capitalize">{{ $linea ? $linea : '' }}</span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="linea-select-label" class="mdc-floating-label {{ $linea ? 'mdc-floating-label--float-above' : '' }}">Línea de Producto</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item {{ $linea ? '' : 'mdc-list-item--selected' }}" {{ $linea ? '' : 'aria-selected="true"' }} data-value="" role="option">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__text"></span>
                                                </li>
                                                @foreach ($lineas as $lineaPro)
                                                    <li class="mdc-list-item capitalize {{ $linea == $lineaPro->codlinea ? 'mdc-list-item--selected' : '' }}" {{ $linea == $lineaPro->codlinea ? 'aria-selected="true"' : '' }} data-value="{{ $lineaPro->codlinea }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text capitallize">{{ $lineaPro->desclinea ? mb_strtolower($lineaPro->desclinea) : $lineaPro->codlinea }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m4 mb-2-s">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense" id="mdc-nombre">
                                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_nombre" name="nombre" id="nombre" value="{{ $nombre }}">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_nombre">Código o Nombre</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s12 m4">
                                    <a class="mdc-button mdc-button--raised mdc-button--dense full-width" href="{{ route('productos.index') }}">
                                        <span class="mdc-button__label">Reiniciar Filtros</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="mdc-data-table mdc-data-table--dense full-width">
                        <div class="mdc-data-table__table-container">
                            <table class="mdc-data-table__table" aria-label="Listado de Productos">
                                <thead>
                                    <tr class="mdc-data-table__header-row">
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Código</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Nombre</th>
                                        <th class="mdc-data-table__header-cell hide-on-small-only" role="columnheader" scope="col">Linea</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Uds</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Kgs</th>
                                        <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                    @forelse ($productos as $index => $producto)
                                        <tr class="mdc-data-table__row">
                                            <td class="mdc-data-table__cell noselect">{{ $producto->codigo }}</td>
                                            <td class="mdc-data-table__cell noselect capitalize">{{ mb_strtolower($producto->nombre) }}</td>
                                            <td class="mdc-data-table__cell noselect capitalize hide-on-small-only">{{ mb_strtolower($producto->desclinea) }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric noselect">{{ number_format($producto->unidades, 0, ',', '.') }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric noselect">{{ number_format($producto->peso, 2, ',', '.') }}</td>
                                            <td class="mdc-data-table__cell mdc-data-table__header-cell--numeric nowrap noselect">$ {{ number_format($producto->total, App\Models\TblEmpresa::first()->decimales, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell center" scope="row" colspan="7">No hay informción de productos.</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($productos->count() > 0)
                            <div class="mdc-data-table__pagination">
                                <div class="mdc-data-table__pagination-trailing full-width row no-margin">
                                    <div class="mdc-data-table__pagination-rows-per-page col s12 m6 mr-0">
                                        <div class="mdc-data-table__pagination-rows-per-page-label">Filas por página</div>
                                        <div>
                                            <div class="mdc-select mdc-select--outlined mdc-select--no-label mdc-data-table__pagination-rows-per-page-select" id="select-datatable">
                                                <div class="mdc-select__anchor" role="button" aria-haspopup="listbox" aria-labelledby="demo-pagination-select" tabindex="0">
                                                    <span class="mdc-notched-outline mdc-notched-outline--notched">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                    <span class="mdc-select__selected-text-container">
                                                        <span id="demo-pagination-select" class="mdc-select__selected-text">{{ Session::get('pagination') }}</span>
                                                    </span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
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
                                                        <li class="mdc-list-item {{ Session::get('pagination') == 50 ? 'mdc-list-item--selected' : '' }}" role="option" data-value="50">
                                                            <span class="mdc-list-item__text">50</span>
                                                        </li>
                                                        <li class="mdc-list-item {{ Session::get('pagination') == 100 ? 'mdc-list-item--selected' : '' }}" role="option" data-value="100">
                                                            <span class="mdc-list-item__text">100</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mdc-data-table__pagination-total">{{ $productos->firstItem() }} ‑ {{ $productos->lastItem() . ' de ' . $productos->total() }}</div>
                                    </div>
                                    <div class="mdc-data-table__pagination-navigation col s12 m6 mb-1-s">
                                        @if($productos->hasPages())
                                            <a class="mdc-icon-button mdc-data-table__pagination-button  {{ $productos->onFirstPage() ? 'disabled' : '' }}" href="{{ $productos->withQueryString()->url(1) }}" data-first-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-step-backward"></i></div>
                                            </a>
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $productos->onFirstPage() ? 'disabled' : '' }}" href="{{ $productos->withQueryString()->previousPageUrl() }}" data-prev-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-chevron-left"></i></div>
                                            </a>
                                            @for ($i = $productos->currentPage() - 2; $i <= $productos->currentPage() + 2; $i++)
                                                @if ($i > 0 && $i <= $productos->lastPage())
                                                    <a class="mdc-icon-button mdc-data-table__pagination-button {{ $i == $productos->currentPage() ? 'disabled current' : '' }}" href="{{ $productos->withQueryString()->url($i) }}">
                                                        <div class="mdc-button__icon">{{ $i }}</div>
                                                    </a>
                                                @endif
                                            @endfor
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $productos->hasMorePages() ? '' : 'disabled' }}" href="{{ $productos->withQueryString()->nextPageUrl() }}" data-next-page="true">
                                                <div class="mdc-button__icon"><i class="fas fa-chevron-right"></i></div>
                                            </a>
                                            <a class="mdc-icon-button mdc-data-table__pagination-button {{ $productos->hasMorePages() ? '' : 'disabled' }}" href="{{ $productos->withQueryString()->url($productos->lastPage()) }}" data-last-page="true">
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
    <div class="mdc-dialog" id="dialog-producto">
        <div class="mdc-dialog__container">
            <div class="mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="dialog-producto-title" aria-describedby="dialog-producto-content">
                <div class="mdc-dialog__spinner">
                    <div class="center">
                        <div id="html-spinner" class="mx-auto mb-1"></div>
                        <span class="title"></span>
                    </div>
                </div>
                <h2 class="mdc-dialog__title" id="dialog-producto-title"></h2>
                <div class="mdc-dialog__content pb-0" id="dialog-producto-content">
                    <p class="mb-0"></p>
                    <div id="input-default" class="mt-3">
                        <label class="mdc-text-field mdc-text-field--outlined mdc-text-field" id="mdc-valor">
                            <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_valor" name="valor" id="valor" value="">
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                    <span class="mdc-floating-label" id="lbl_valor">{{ __('parametros/configuracion/productos.dialog-input-valor') }}</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                        </label>
                        <div class="mdc-text-field-helper-line">
                            <div class="mdc-text-field-helper-text nowrap mdc-text-field-helper-text--validation-msg" id="mdc-helper-valor" aria-hidden="true"></div>
                        </div>
                    </div>
                    <div id="input-boolean" class="mt-1" style="height: 48px; align-items: center; display: flex; justify-content: space-between;">
                        <label class="mr-3 capitalize" for="valor-2">{{ __('generales/otros.falso') .'/'. __('generales/otros.verdadero') }}</label>
                        <div class="mdc-switch" id="mdc-valor-2">
                            <div class="mdc-switch__track"></div>
                            <div class="mdc-switch__thumb-underlay">
                                <div class="mdc-switch__thumb"></div>
                                <input type="checkbox" id="valor-2" class="mdc-switch__native-control" role="switch" aria-checked="false">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdc-dialog__actions">
                    <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="close">
                        <div class="mdc-button__ripple"></div>
                        <span class="mdc-button__label">{{ __('generales/botones.cancelar') }}</span>
                    </button>
                    <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-button-default id="dialog-producto-guardar">
                        <div class="mdc-button__ripple"></div>
                        <span class="mdc-button__label">{{ __('generales/botones.guardar') }}</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mdc-dialog__scrim"></div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#productos-index').addClass('mdc-list-item--active');

        /* Elementos de Material.io */
        const dataTable = new mdc.dataTable.MDCDataTable(document.querySelector('.mdc-data-table'));
        const selectOrden = new mdc.select.MDCSelect(document.querySelector('#mdc-select-orden'));
        selectOrden.value = '{{ $orden }}';
        const fecha_inicial = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_inicial'));
        const fecha_final = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_final'));
        const selectLinea = new mdc.select.MDCSelect(document.querySelector('#mdc-select-linea'));
        const nombre = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombre'));
        @if($productos->count() > 0)
            const selectDatable = new mdc.select.MDCSelect(document.querySelector('#select-datatable'));
        @endif

        /* productos Globales a utilizar */

        /* Url necesarias */

        /* Filtros */
        $('#fecha_inicial').on('change', function() {
            $('#mainForm').submit();
        });

        $('#fecha_final').on('change', function() {
            $('#mainForm').submit();
        });

        $('#nombre').on('change blur', function() {
            $('#mainForm').submit();
        });

        selectOrden.listen('MDCSelect:change', (el) => {
            $('#orden').val(selectOrden.value);
            $('#mainForm').submit();
        });

        selectLinea.listen('MDCSelect:change', (el) => {
            $('#linea').val(selectLinea.value);
            $('#mainForm').submit();
        });

        @if($productos->count() > 0)
            selectDatable.listen('MDCSelect:change', (el) => {
                $('#perPage').val(selectDatable.value);
                $('#mainForm').submit();
            });
        @endif

        /* Acciones de botones */

        /* Interacción de los diálogos */

        /* Funciones de la vista */
    </script>
@endsection
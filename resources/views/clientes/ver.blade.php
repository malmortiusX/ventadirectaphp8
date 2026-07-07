@extends('layouts.app')
@php
    setlocale(LC_ALL, 'es_ES');
    \Carbon\Carbon::setLocale('es');
@endphp

@section('styles')
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
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m8 mb-1-m">
                    <h1 class="title uppercase font-gilroy nowrap">{{ mb_strToLower($cliente->nombre_cliente) }}</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('clientes.rutero') }}" class="breadcrumb">Rutero</a>
                        <a class="breadcrumb">{{ $cliente->cc_nit }}</a>
                    </div>
                </div>
                <div class="col m4 right-align">
                    <a class="mdc-button mdc-button--raised mdc-button--large" href="{" target="_blank">
                        <span class="mdc-button__label mr-1">Imprimir</span>
                        <i class="fas fa-print"></i>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 m6">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-1">Datos del Cliente</span>
                            <div class="row mb-0">
                                <input type="number" class="hide" name="estado" id="estado" value="0">
                                <div class="col s12 mb-2">
                                    <label>Nombre Completo</label>
                                    <span class="card-subtitle highlighted capitalize">{{ mb_strToLower($cliente->nombre_cliente) }}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>CC / NIT</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $cliente->cc_nit }}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Teléfono</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">{!! $cliente->telefono ? $cliente->telefono : '&nbsp;' !!}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Cupo</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">$ {{ number_format($cliente->cupo, 0, ',', '.') }}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Lista de Precio</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $cliente->lista_precio .' - '. mb_strToLower($cliente->listaPrecio->nombre) }}</span>
                                </div>
                                <div class="col s12 mb-2">
                                    <label>Días de Visita - Secuencia</label>
                                    <div class="mdc-chip-set mdc-chip-set--choice mdc-chip-set-dense" role="grid" id="mdc-dias_visita">
                                        @if($cliente->lu)
                                            <div class="mdc-chip noselect" id="mdc-lu" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="checkbox" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Lunes - {{ $cliente->sec_lu }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->ma)
                                            <div class="mdc-chip noselect" id="mdc-ma" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="checkbox" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Martes - {{ $cliente->sec_ma }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->mi)
                                            <div class="mdc-chip noselect" id="mdc-mi" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">Miércoles - {{ $cliente->sec_mi }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->ju)
                                            <div class="mdc-chip noselect" id="mdc-ju" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">Jueves - {{ $cliente->sec_ju }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->vi)
                                            <div class="mdc-chip noselect" id="mdc-vi" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">Viernes - {{ $cliente->sec_vi }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->sa)
                                            <div class="mdc-chip noselect" id="mdc-sa" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">Sábado - {{ $cliente->sec_sa }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->do)
                                            <div class="mdc-chip noselect" id="mdc-do" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">Domingo - {{ $cliente->sec_do }}°</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col s12 mb-2">
                                    <label>Semanas de Visita</label>
                                    <div class="mdc-chip-set mdc-chip-set--choice mdc-chip-set-dense" role="grid" id="mdc-semanas_visita">
                                        @if($cliente->s1)
                                            <div class="mdc-chip noselect" id="mdc-s1" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="checkbox" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">1° Sem</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->s2)
                                            <div class="mdc-chip noselect" id="mdc-s2" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="checkbox" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">2° Sem</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->s3)
                                            <div class="mdc-chip noselect" id="mdc-s3" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">3° Sem</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->s4)
                                            <div class="mdc-chip noselect" id="mdc-s4" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">4° Sem</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                        @if($cliente->s5)
                                            <div class="mdc-chip noselect" id="mdc-s5" role="row">
                                                <div class="mdc-chip__ripple"></div>
                                                <span role="gridcell">
                                                    <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                    <span class="mdc-chip__text">5° Sem</span>
                                                    </span>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col s12 mb-0">
                                    <label>Dirección</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">{{ mb_strToLower($cliente->direccion .' - '. ($cliente->ciudadCl ? $cliente->ciudadCl->ciudad : $cliente->ciudad)) }}</span>
                                    @if($cliente->longitud && $cliente->latitud)
                                        <div id="map" class="mt-1"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="mdc-data-table mdc-data-table--dense full-width card">
                        <div class="card-content">
                            <span class="card-title mb-1">Últimas No Compras</span>
                        </div>
                        <div class="mdc-data-table__table-container">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                    <tr class="mdc-data-table__header-row">
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Fecha</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Motivo</th>
                                    </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                    @forelse ($cliente->noCompras->take(3) as $noCompra)
                                        <tr class="mdc-data-table__row" id="{{ $noCompra->id_no_compra }}">
                                            <th class="mdc-data-table__cell" scope="row">
                                                @switch(\Carbon\Carbon::parse($noCompra->fecha_no_compra)->startOfDay()->diffInDays($hoy->startOfDay(), false))
                                                    @case(0)
                                                        Hoy
                                                        @break
                                                    @case(1)
                                                        Ayer
                                                        @break
                                                    @default
                                                        @if (\Carbon\Carbon::parse($noCompra->fecha_no_compra)->startOfDay()->diffInDays($hoy->startOfDay(), false) < 7)
                                                            {{ ucfirst(\Carbon\Carbon::parse($noCompra->fecha_no_compra)->dayName) }} pasado
                                                        @else
                                                            {{ ucfirst(\Carbon\Carbon::parse($noCompra->fecha_no_compra)->dayName) .', '. \Carbon\Carbon::parse($noCompra->fecha_no_compra)->day . ' de '. ucfirst(\Carbon\Carbon::parse($noCompra->fecha_no_compra)->monthName) }}  
                                                        @endif
                                                @endswitch
                                            </th>
                                            <th class="mdc-data-table__cell" scope="row">{{ $noCompra->motivo }}</th>
                                        </tr>
                                    @empty
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell center" scope="row" colspan="2">Este cliente no tiene no compras registradas</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="mdc-data-table mdc-data-table--dense full-width card">
                        <div class="card-content">
                            <span class="card-title mb-1">Últimos Pedidos</span>
                        </div>
                        <div class="mdc-data-table__table-container">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                    <tr class="mdc-data-table__header-row">
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Id</th>
                                        <th class="mdc-data-table__header-cell hide-on-med-and-down" role="columnheader" scope="col">Fecha</th>
                                        <th class="mdc-data-table__header-cell hide-on-large-only" role="columnheader" scope="col">Fecha</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Estado</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                    @forelse ($cliente->pedidos->take(6) as $pedido)
                                        <tr class="mdc-data-table__row" id="{{ $pedido->id_comercial }}">
                                            <th class="mdc-data-table__cell" scope="row"><a class="link color-primary" href="{{ route('pedidos.show', ['id' => $pedido->id_comercial]) }}">{{ $pedido->id_comercial }}</a></th>
                                            <th class="mdc-data-table__cell hide-on-med-and-down" scope="row">
                                                @switch(\Carbon\Carbon::parse($pedido->fecha_ingreso)->startOfDay()->diffInDays($hoy->startOfDay(), false))
                                                    @case(0)
                                                        Hoy
                                                        @break
                                                    @case(1)
                                                        Ayer
                                                        @break
                                                    @default
                                                        @if (\Carbon\Carbon::parse($pedido->fecha_ingreso)->startOfDay()->diffInDays($hoy->startOfDay(), false) < 7)
                                                            {{ ucfirst(\Carbon\Carbon::parse($pedido->fecha_ingreso)->dayName) }} pasado
                                                        @else
                                                            {{ ucfirst(\Carbon\Carbon::parse($pedido->fecha_ingreso)->dayName) .', '. \Carbon\Carbon::parse($pedido->fecha_ingreso)->day . ' de '. ucfirst(\Carbon\Carbon::parse($pedido->fecha_ingreso)->monthName) }}  
                                                        @endif
                                                @endswitch
                                            </th>
                                            <th class="mdc-data-table__cell hide-on-large-only" scope="row">
                                                @switch(\Carbon\Carbon::parse($pedido->fecha_ingreso)->startOfDay()->diffInDays($hoy->startOfDay(), false))
                                                    @case(0)
                                                        Hoy
                                                        @break
                                                    @case(1)
                                                        Ayer
                                                        @break
                                                    @default
                                                        {{ \Carbon\Carbon::parse($pedido->fecha_ingreso)->day . ' de '. ucfirst(\Carbon\Carbon::parse($pedido->fecha_ingreso)->monthName) }}  
                                                @endswitch
                                            </th>
                                            <th class="mdc-data-table__cell" scope="row">{{ $pedido->estado ? 'Cerrado' : 'Abierto' }}</th>
                                            <th class="mdc-data-table__cell nowrap" scope="row">$ {{ number_format($pedido->productos->sum('pivot.total'), App\Models\TblEmpresa::first()->decimales, ',', '.') }}</th>
                                        </tr>
                                    @empty
                                        <tr class="mdc-data-table__row">
                                            <th class="mdc-data-table__cell center" scope="row" colspan="4">Este cliente no pedidos registrados</th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/leafletjs/leaflet.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pedidos-index').addClass('mdc-list-item--active');
            var latitud = {{ $cliente->latitud ? $cliente->latitud : 0 }};
            var longitud = {{ $cliente->longitud ? $cliente->longitud : 0 }};
            var precision = {{ $cliente->precision ? $cliente->precision : 0 }};

            @if($cliente->longitud && $cliente->latitud)
                var map = L.map('map').setView([latitud, longitud], 13);
                L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                L.control.scale().addTo(map);
                L.marker([latitud, longitud]).addTo(map);
                if (precision >! 0) {
                    L.circle([latitud, longitud], precision).addTo(map);
                }
            @endif
        });
    </script>
@endsection
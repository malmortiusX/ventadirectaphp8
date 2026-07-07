@extends('layouts.app')

@php
    $empresa = \App\Models\TblEmpresa::first();
@endphp

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
    <form action="{{ route('pedidos.update', ['id' => $pedido->id_comercial]) }}" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Pedido N° {{ $pedido->id_comercial }}</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.index') }}" class="breadcrumb">Pedidos</a>
                        <a class="breadcrumb"># {{ $pedido->id_comercial }}</a>
                    </div>
                </div>
                <div class="col s12 m6 right-align hide-on-small-only">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('dashboard')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    @if(date("d-m-Y", strtotime($pedido->fecha_ingreso)) == date("d-m-Y", time()))
                    <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="enviar_pedido" type="submit" disabled>
                        <span class="mdc-button__label mr-1">Cerrar Pedido</span>
                        <i class="fal fa-truck"></i>
                    </button>
                    @endif
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 l3">
                    <div class="row mb-0">
                        <div class="col s12 m6 l12">
                            <div class="card highlighted">
                                <div class="card-content">
                                    <span class="card-title mb-1">Datos del Cliente</span>
                                    <div class="row mb-0">
                                        <div class="col s12 mb-1">
                                            <label>Nombre Completo</label>
                                            <span class="card-subtitle highlighted capitalize">{{ mb_strtolower($pedido->cliente->nombre_cliente) }}</span>
                                        </div>
                                        <div class="col s3 mb-1">
                                            <label>Lista</label>
                                            <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $pedido->cliente->lista_precio }}</span>
                                        </div>
                                        <div class="col s9 mb-1">
                                            <label>CC / NIT</label>
                                            <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $pedido->cliente->cc_nit }}</span>
                                        </div>
                                        <div class="col s6 l12 xl6 mb-1">
                                            <label>Valor Facturado</label>
                                            <span class="card-subtitle subtitle-3 highlighted nowrap">$ {{ number_format($pedido->cliente->valor_facturado, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col s6 l12 xl6 mb-1">
                                            <label>Cupo</label>
                                            <span class="card-subtitle subtitle-3 highlighted nowrap">$ {{ number_format($pedido->cliente->cupo, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <label>Teléfono</label>
                                            <a href="tel:+57{{ $pedido->cliente->telefono }}" class="card-subtitle subtitle-3 highlighted capitalize">{{ $pedido->cliente->telefono }}</a>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <label>Dirección</label>
                                            <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $pedido->cliente->ciudadCl ? mb_strtolower($pedido->cliente->direccion .' - '. $pedido->cliente->ciudadCl->ciudad) : mb_strtolower($pedido->cliente->direccion) }}</span>
                                        </div>
                                        <div class="col s12 mb-1 mapa_cliente" style="{{ ($pedido->cliente->longitud && $pedido->cliente->latitud) ? '' : 'display: none;' }}">
                                            <div id="map_cliente"></div>
                                        </div>
                                        <div class="col s12 right-align mt-1 mapa_cliente" style="{{ ($pedido->cliente->longitud && $pedido->cliente->latitud) ? '' : 'display: none;' }}">
                                            <button class="mdc-button mdc-button--outlined mdc-button--dense obtener-coordenadas" data-target="buscar_cliente_modal" id="cambiar_cliente" type="button">
                                                <span class="mdc-button__label">Actualizar <i class="fas fa-map-marker-alt"></i></span>
                                            </button>
                                        </div>
                                        <div class="col s12 right-align mt-1 geolocalizar" style="{{ ($pedido->cliente->longitud && $pedido->cliente->latitud) ? 'display: none;' : '' }}">
                                            <button class="mdc-button mdc-button--raised mdc-button--dense obtener-coordenadas" id="editar_cliente" type="button">
                                                <span class="mdc-button__label">Geolocalizar <i class="fas fa-map-marker-alt"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6 l12">
                            <div class="card highlighted">
                                <div class="card-content">
                                    <span class="card-title mb-2">Opciones del Pedido</span>
                                    <div class="row mb-0">
                                        <input type="number" class="hide" name="estado" id="estado" value="0">
                                        <div class="col s12 mb-2">
                                            <div class="mdc-select mdc-select--outlined mdc-select--filled mdc-select--dense" id="mdc-select__cop">
                                                <div class="mdc-select__anchor" aria-labelledby="outlined-select-label">
                                                    <input type="text" name="cop" id="cop" class="mdc-select__input-value" value="{{ $pedido->cop }}">
                                                    <span id="cop__selected-text" class="mdc-select__selected-text">{{ $pedido->centroDist->nombre }}</span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
                                                    </span>
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span id="outlined-select-label" class="mdc-floating-label mdc-floating-label--float-above">Centro de Distribución</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                </div>
                                                <!-- Other elements from the select remain. -->
                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox">
                                                    <ul class="mdc-list">
                                                        @if ($usuario->nivel == 'u_administrador' || $usuario->nivel == 'u_movil_especial')
                                                            @forelse ($pedido->vendedor->centrosDist as $centro)
                                                                <li class="mdc-list-item {{ $centro->cop == $pedido->cop ? 'mdc-list-item--selected' : '' }}" data-value="{{ $centro->cop }}" role="option" {{ $centro->cop == $pedido->cop ? 'aria-selected="true"' : '' }}>
                                                                    <span class="mdc-list-item__ripple"></span>
                                                                    <span class="mdc-list-item__text">{{ ucfirst(strtolower($centro->nombre)) }}</span>
                                                                </li>
                                                            @empty
                                                                @if ($pedido->vendedor->cop)
                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="{{ $pedido->vendedor->centroDist->cop }}" role="option" aria-selected="true">
                                                                        <span class="mdc-list-item__ripple"></span>
                                                                        <span class="mdc-list-item__text">{{ ucfirst(strtolower($pedido->vendedor->centroDist->nombre)) }}</span>
                                                                    </li>
                                                                @endif
                                                            @endforelse
                                                        @else
                                                            @forelse ($usuario->centrosDist as $centro)
                                                                <li class="mdc-list-item {{ $centro->cop == $pedido->cop ? 'mdc-list-item--selected' : '' }}" data-value="{{ $centro->cop }}" role="option" {{ $centro->cop == $pedido->cop ? 'aria-selected="true"' : '' }}>
                                                                    <span class="mdc-list-item__ripple"></span>
                                                                    <span class="mdc-list-item__text">{{ ucfirst(strtolower($centro->nombre)) }}</span>
                                                                </li>
                                                            @empty
                                                                @if ($usuario->cop)
                                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="{{ $usuario->centroDist->cop }}" role="option" aria-selected="true">
                                                                        <span class="mdc-list-item__ripple"></span>
                                                                        <span class="mdc-list-item__text">{{ ucfirst(strtolower($usuario->centroDist->nombre)) }}</span>
                                                                    </li>
                                                                @endif
                                                            @endforelse
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-2">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-fecha_entrega">
                                                <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_entrega" name="fecha_entrega" id="fecha_entrega" value="{{ $pedido->fecha_entrega }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_fecha_entrega">Fecha de Entrega</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col s12 mb-2">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-orden">
                                                <input type="number" class="mdc-text-field__input" aria-labelledby="lbl_orden" name="orden" id="orden" value="{{ $pedido->orden }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_orden">Orden de Entrega</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        @if($usuario->mostrar_orden_compra)
                                        <div class="col s12 mb-2">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-orden_compra">
                                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_orden_compra" name="orden_compra" id="orden_compra" value="{{ $pedido->orden_compra }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_orden_compra">Orden de Compra</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        @endif
                                        <div class="col s12">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--textarea-dense">
                                                <span class="mdc-text-field__resizer">
                                                    <textarea class="mdc-text-field__input" rows="2" cols="40" aria-label="Label" name="observacion_pedido" id="observacion_pedido">{{ $pedido->observacion_pedido == ' ' ? '' : $pedido->observacion_pedido }}</textarea>
                                                </span>
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_usuario">Observaciones</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 l9">
                    <div class="row mb-0 full-row">
                        <div class="col s12 m8">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title mb-3">Buscar Productos</span>
                                    <div class="row mb-0">
                                        <div class="col s12">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="buscar_producto">
                                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_buscar_producto" name="buscar_producto" autocomplete="off">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_buscar_producto">Buscar por Código o por Nombre</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" id="mdc-menu__buscar_producto">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 hide-on-small-only">
                            <div class="card highlighted bg-primary white-text">
                                <div class="card-content full-height d-flex f-column justify-content-center" style="padding: 19.5px 24px;">
                                    <label class="center">Valor de tu Pedido</label>
                                    <span class="card-title highlighted center" id="valor_pedido">$ {{ number_format($pedido->productos->sum('pivot.total'), $empresa->decimales, ',', '.') }}</span>
                                    <div class="row mb-0">
                                        <div class="col s8">
                                            <label>Estado</label>
                                            <span class="card-subtitle highlighted" id="estado_pedido">Abierto</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label># Items</label>
                                            <span class="card-subtitle highlighted right-align" id="items_pedido">{{ number_format($pedido->productos->count(), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="card highlighted relative">
                                <div class="card-content full-height d-flex f-column justify-content-center">
                                    <div class="row mb-0">
                                        <div class="col s12 m8 border-right noborder-s">
                                            @if ($pedido->cliente->listaPrecio->promocion)
                                                <div class="row mb-0">
                                                    <div class="col s12 mb-1">
                                                        <div class="mdc-touch-target-wrapper">
                                                            <div class="mdc-checkbox mdc-checkbox__dense mdc-checkbox--touch no-margin pl-0">
                                                                <input type="checkbox" class="mdc-checkbox__native-control" id="obsequio" name="obsequio" disabled/>
                                                                <div class="mdc-checkbox__background">
                                                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                                    </svg>
                                                                    <div class="mdc-checkbox__mixedmark"></div>
                                                                </div>
                                                                <div class="mdc-checkbox__ripple"></div>
                                                            </div>
                                                            <label for="obsequio" class="ml-1 noselect nowrap mdc-checkbox__dense">Ingresar como producto de obsequio</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($empresa->nombre == 'San Marino')
                                                <div class="row mb-0">
                                                    <div class="col s12 mb-1">
                                                        <div class="mdc-touch-target-wrapper">
                                                            <div class="mdc-checkbox mdc-checkbox__dense mdc-checkbox--touch no-margin pl-0">
                                                                <input type="checkbox" class="mdc-checkbox__native-control" id="tiquetear" name="tiquetear"/>
                                                                <div class="mdc-checkbox__background">
                                                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                                    </svg>
                                                                    <div class="mdc-checkbox__mixedmark"></div>
                                                                </div>
                                                                <div class="mdc-checkbox__ripple"></div>
                                                            </div>
                                                            <label for="tiquetear" class="ml-1 noselect nowrap mdc-checkbox__dense">Tiquetear producto</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-0">
                                                <div class="col {{ $pedido->cliente->listaPrecio->iva_incluido ? 's12' : 's9' }} m6">
                                                    <label>Código: <span id="codigo_producto_add"></span></label>
                                                    <span class="card-subtitle subtitle-3 highlighted capitalize" id="nombre_producto_add"></span>
                                                </div>
                                                @if (!$pedido->cliente->listaPrecio->iva_incluido)
                                                    <div class="col s3 hide-on-med-and-up right-align">
                                                        <label>Iva</label>
                                                        <span class="card-subtitle subtitle-3 highlighted" style="line-height: 30px!important"><span id="porciva_add_mv"></span> %</span>
                                                    </div>
                                                    <div class="col s4 m2 mt-1-s hide-on-small-only right-align">
                                                        <label>Iva</label>
                                                        <span class="card-subtitle subtitle-3 highlighted right-align" style="line-height: 30px!important"><span id="porciva_add"></span> %</span>
                                                    </div>
                                                @endif
                                                <div class="col s4 {{ $pedido->cliente->listaPrecio->iva_incluido ? 'm3' : 'm2' }} mt-1-s hide-on-small-only right-align">
                                                    <label>Valor x Kil</label>
                                                    <span class="card-subtitle subtitle-3 highlighted right-align" style="line-height: 30px!important">
                                                    @if ($empresa->nombre == "Cadasa")
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label" id="valor_kg_add" style="display: block;">
                                                        <input class="mdc-text-field__input valor_kg_add" type="number" aria-labelledby="my-label-id" name="valor_kg_add[]" min="1" step="0.01">
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                    @else
                                                        $ <span id="valor_kg_add"></span>
                                                    @endif
                                                    </span>
                                                </div>
                                                <div class="col s4 {{ $pedido->cliente->listaPrecio->iva_incluido ? 'm3' : 'm2' }} mt-1-s hide-on-small-only right-align">
                                                    <label>Valor x Und</label>
                                                    <span class="card-subtitle subtitle-3 highlighted right-align" style="line-height: 30px!important">
                                                        @if ($empresa->nombre == "Cadasa")
                                                        <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label" id="valor_un_add" style="display: block;">
                                                            <input class="mdc-text-field__input valor_un_add" type="number" aria-labelledby="my-label-id" name="valor_un_add[]" min="1" step="0.01">
                                                            <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                                <span class="mdc-notched-outline__leading"></span>
                                                                <span class="mdc-notched-outline__trailing"></span>
                                                            </span>
                                                        </label>
                                                        @else
                                                        $ <span id="valor_un_add"></span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="col s4 m3 mt-1-s hide-on-med-and-up">
                                                    <label>Valor x Kil</label>
                                                    <span class="card-subtitle subtitle-3 highlighted" style="line-height: 30px!important">$
                                                        <span id="valor_kg_add_mv"></span>
                                                    </span>
                                                </div>
                                                <div class="col s4 m3 mt-1-s hide-on-med-and-up">
                                                    <label>Valor x Und</label>
                                                    <span class="card-subtitle subtitle-3 highlighted" style="line-height: 30px!important">$ <span id="valor_un_add_mv"></span></span>
                                                </div>
                                                <div class="col {{ $empresa->nombre == 'San Marino' ? 's4 m-5 mt-1' : 's4 m3 mt-1' }}">
                                                    <label>Facturar Por</label>
                                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense mdc-select--no-label mdc-select--disabled" id="unmed_producto_add">
                                                        <div class="mdc-select__anchor" aria-disabled="true">
                                                            <span class="mdc-select__selected-text"></span>
                                                            <span class="mdc-select__dropdown-icon" style="margin-left: 0px;">
                                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                                </svg>
                                                            </span>
                                                            <span class="mdc-notched-outline">
                                                                <span class="mdc-notched-outline__leading"></span>
                                                                <span class="mdc-notched-outline__trailing"></span>
                                                            </span>
                                                        </div>
                                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth mdc-menu--dense">
                                                            <ul class="mdc-list">
                                                                <li class="mdc-list-item mdc-list-item--selected mdc-list-item--disabled" aria-selected="true" aria-disabled="true" data-value="" role="option" style="display: none;"></li>
                                                                <li class="mdc-list-item" data-value="KIL" id="unmed_producto_add_kg">
                                                                    <span class="mdc-list-item__ripple"></span>
                                                                    <span class="mdc-list-item__text">KIL</span>
                                                                </li>
                                                                <li class="mdc-list-item" data-value="UND" id="unmed_producto_add_un">
                                                                    <span class="mdc-list-item__ripple"></span>
                                                                    <span class="mdc-list-item__text">UND</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mt-1 {{ $empresa->nombre == 'San Marino' ? 's3 m-5' : 's4 m3' }}">
                                                    <label>Kilogramos</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_kg_producto_add" style="display: block;">
                                                        <input class="mdc-text-field__input cantidad_producto" type="number" step="0.01" aria-labelledby="my-label-id" name="cantidad_producto[]" min="0.01" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 m-5 mt-1 {{ $empresa->nombre == 'San Marino' ? '' : 'hide' }}">
                                                    <label>Factor</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_fa_producto_add" style="display: block;">
                                                        <input class="mdc-text-field__input cantidad_producto" type="number" step="0.01" aria-labelledby="my-label-id" name="cantidad_producto[]" min="0.01" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col mt-1 {{ $empresa->nombre == 'San Marino' ? 's3 m-5' : 's4 m3' }}">
                                                    <label>Unidades</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_un_producto_add" style="display: block;">
                                                        <input class="mdc-text-field__input cantidad_producto" type="number" aria-labelledby="my-label-id" name="cantidad_producto[]" min="1" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col mt-1 {{ $empresa->nombre == 'San Marino' ? 's3 m-5' : 's4 m3' }}">
                                                    @if ($empresa->nombre == 'San Marino')
                                                        <label>Descuento</label>
                                                        <div class="row">
                                                            <div class="col pr-0 pl-0">
                                                                <label>$</label>
                                                            </div>
                                                            <div class="col pl-0" style="width: 89%;">
                                                                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="dcto_producto_add" style="display: block;">
                                                                    <input class="mdc-text-field__input cantidad_producto" type="number" step="0.01" aria-labelledby="my-label-id" id="cantidad_producto[]" name="descuento_producto" max="{{ ($pedido->cliente->descuento_c < $usuario->porcentaje_maximo) ? $pedido->cliente->descuento_c : $usuario->porcentaje_maximo }}" min="0" disabled {{ $usuario->bloquear_descuento || !$usuario->porcentaje_maximo ? 'readonly' : '' }}>
                                                                    <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                                        <span class="mdc-notched-outline__leading"></span>
                                                                        <span class="mdc-notched-outline__trailing"></span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <label>% Dcto</label>
                                                        <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="dcto_producto_add" style="display: block;">
                                                            <input class="mdc-text-field__input cantidad_producto" name="porcentaje_d" type="number" step="0.01" aria-labelledby="my-label-id" name="descuento_producto[]" max="{{ ($pedido->cliente->descuento_c < $usuario->porcentaje_maximo) ? $pedido->cliente->descuento_c : $usuario->porcentaje_maximo }}" min="0" disabled {{ $usuario->bloquear_descuento || !$usuario->porcentaje_maximo ? 'readonly' : '' }}>
                                                            <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                                <span class="mdc-notched-outline__leading"></span>
                                                                <span class="mdc-notched-outline__trailing"></span>
                                                            </span>
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($pedido->cliente->listaDescuento)
                                                <div class="row mb-0 mt-1" id="alerta_lista_descuentos" style="display: none;">
                                                    <div class="col s12">
                                                        <a href="#">
                                                            <span class="font-poppins fz-12 color-primary"><i class="fas fa-info-circle"></i> Este producto está en la lista de descuentos '{{ $pedido->cliente->lista_descuento .' - '. ($pedido->cliente->listaDescuento ? $pedido->cliente->listaDescuento->nombre : '') }}'.</span class="">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col s12 m4 center mt-4-s border-left noborder-s">
                                            <div class="row mb-0">
                                                @if ($pedido->cliente->listaPrecio->iva_incluido)
                                                    <div class="col s6 left-align">
                                                        <label>Valor</label>
                                                        <span class="card-subtitle subtitle-4 highlighted mb-1">$ <span id="valor_producto_add"></span></span>
                                                    </div>
                                                    <div class="col s6 right-align">
                                                        <label>Descuento</label>
                                                        <span class="card-subtitle subtitle-4 highlighted mb-1">- $ <span id="descuento_producto_add"></span></span>
                                                    </div>
                                                @else
                                                    <div class="col s6 hide">
                                                        <label>Valor</label>
                                                        <span class="card-subtitle subtitle-4 highlighted mb-1">$ <span id="valor_producto_add"></span></span>
                                                    </div>
                                                    <div class="col s6 left-align">
                                                        <label>Descuento</label>
                                                        <span class="card-subtitle subtitle-4 highlighted mb-1">- $ <span id="descuento_producto_add"></span></span>
                                                    </div>
                                                    <div class="col s6 right-align">
                                                        <label>Iva</label>
                                                        <span class="card-subtitle subtitle-4 highlighted mb-1">$ <span id="valor_iva_producto_add"></span></span>
                                                    </div>
                                                @endif
                                            </div>
                                            <label class="center">Subtotal</label>
                                            <span class="card-title subtitle-2 highlighted center">$ <b id="subtotal_producto_add"></b></span>
                                            <button class="mdc-button mdc-button--outlined mt-1-s" type="button" id="quitar_producto_lista" disabled>
                                                <span class="mdc-button__label">Quitar</span>
                                            </button>
                                            <button class="mdc-button mdc-button--raised mt-1-s" type="button" id="agregar_producto_lista" disabled>
                                                <span class="mdc-button__label">Agregar</span>
                                            </button>
                                            <button class="mdc-button mdc-button--raised mt-1-s" type="button" id="actualizar_producto_lista" disabled style="display: none;">
                                                <span class="mdc-button__label">Actualizar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="alerta-superpuesta blanca px-2 py-2" id="alerta_producto_por_agregar">
                                    <span class="subtitle-1">Primero debes buscar un producto.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12">
                            <div class="card" style="position: inherit">
                                <div class="card-content">
                                    <span class="card-title mb-3">Listado de Productos</span>
                                    <table id="productos" class="display responsive" width="100%" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th></th>
                                                <th>Kil</th>
                                                <th>Und</th>
                                                <th>UM</th>
                                                <th>Valor</th>
                                                <th>Dcto</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 hide-on-med-and-up">
                            <div class="card highlighted bg-primary white-text">
                                <div class="card-content full-height d-flex f-column justify-content-center" style="padding: 19.5px 24px;">
                                    <label class="center">Valor de tu Pedido</label>
                                    <span class="card-title highlighted center" id="valor_pedido_mv">$ {{ number_format($pedido->productos->sum('pivot.total'), 0, ',', '.') }}</span>
                                    <div class="row mb-0">
                                        <div class="col s8">
                                            <label>Estado</label>
                                            <span class="card-subtitle highlighted" id="estado_pedido_mv">Abierto</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label># Items</label>
                                            <span class="card-subtitle highlighted right-align" id="items_pedido_mv">{{ number_format($pedido->productos->count(), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('dashboard')}}">
                                <span class="mdc-button__label">Salir</span>
                            </a>
                            @if(date("d-m-Y", strtotime($pedido->fecha_ingreso)) == date("d-m-Y", time()))
                            <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="enviar_pedido_mv" type="submit" disabled>
                                <span class="mdc-button__label mr-1">Cerrar Pedido</span>
                                <i class="fas fa-truck"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if ($pedido->cliente->listaDescuento)
        <div id="mdc-dialog-lista_descuentos" class="mdc-dialog highlighted">
            <div class="mdc-dialog__container">
                <div class="mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
                    <div class="mdc-dialog__content" id="my-dialog-content">
                        <div class="row mb-0 black-text" style="max-width: 320px;">
                            <div class="col s12 center">
                                <label class="">Lista de Descuento</label>
                                <span class="card-title subtitle-1 d-block capitalize font-gilroy mb-1">{{ $pedido->cliente->lista_descuento .' - '. ($pedido->cliente->listaDescuento ? $pedido->cliente->listaDescuento->nombre : '') }}</span>
                            </div>
                            <div class="col s12 mt-2">
                                <label>Código: <span id="codigo_producto_lista_descuento"></span></label>
                                <span class="card-subtitle subtitle-3 highlighted d-block" id="nombre_producto_lista_descuento"></span>
                            </div>
                            <div class="col s8 mt-2">
                                <label>Facturado Por</label>
                                <span class="card-subtitle subtitle-3 highlighted d-block" id="undmed_producto_lista_descuento"></span>
                            </div>
                            <div class="col s4 mt-2">
                                <label>Cantidad</label>
                                <span class="card-subtitle subtitle-3 highlighted d-block" id="cantidad_producto_lista_descuento"></span>
                            </div>
                        </div>
                        <div class="row mb-0 mt-3">
                            <div class="col s12">
                                <div class="mdc-data-table mdc-data-table--dense full-width" id="mdc-table-lista_descuentos">
                                    <div class="mdc-data-table__table-container">
                                        <table class="mdc-data-table__table">
                                            <thead>
                                                <tr class="mdc-data-table__header-row">
                                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col" rowspan="2">Rango</th>
                                                    <th class="mdc-data-table__header-cell py-0" role="columnheader" scope="col" colspan="2" style="height: 28px; text-align: center;">Cantidad</th>
                                                    <th class="mdc-data-table__header-cell mdc-data-table__header-cell--numeric" role="columnheader" scope="col" rowspan="2">Dcto.</th>
                                                </tr>
                                                <tr class="mdc-data-table__header-row">
                                                    <th class="mdc-data-table__header-cell py-0" role="columnheader" scope="col" style="height: 28px; text-align: center;">Kg</th>
                                                    <th class="mdc-data-table__header-cell py-0" role="columnheader" scope="col" style="height: 28px; text-align: center;">Un</th>
                                                </tr>
                                            </thead>
                                            <tbody class="mdc-data-table__content">
                                                <tr class="mdc-data-table__row">
                                                    <th class="mdc-data-table__cell" scope="row">1</th>
                                                    <th class="mdc-data-table__cell mdc-data-table__header-cell--numeric" scope="row">5</th>
                                                    <th class="mdc-data-table__cell mdc-data-table__header-cell--numeric" scope="row">12</th>
                                                    <th class="mdc-data-table__cell mdc-data-table__header-cell--numeric" scope="row">5 %</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-dialog__actions">
                        <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="cancel">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label">Cerrar</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mdc-dialog__scrim"></div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/leafletjs/leaflet.js') }}"></script>
    <script type="text/javascript">
        var pedido = @json($pedido);
        var cliente = @json($pedido->cliente);
        $(document).ready(async function() {
            // Variables que guardan la información de la vista
            var productosListado = [];
            @if(isset($productos))
                var productosPedido = @json($productos);
                // console.log(productosPedido);
            @else
                var productosPedido = @json($pedido->productos);
            @endif
            var productoPorAgregar = [];
            var bloquearDescuento = {{ $usuario->bloquear_descuento ? $usuario->bloquear_descuento : '0' }};
            var porcentajeMaximo = {{ $pedido->cliente->descuento_c && $usuario->porcentaje_maximo ? ($pedido->cliente->descuento_c < $usuario->porcentaje_maximo ? $pedido->cliente->descuento_c : $usuario->porcentaje_maximo) : '0' }};
            var mapCliente;
            var markerCliente = null;
            var circleCliente = null;

            // Rutas de ajax
            var urlBuscarProductos = '{!! route('ajax.pedido.productos.buscar', ['pedido' => $pedido->id_comercial, 'busqueda' => 'null']) !!}';
            var urlGuardarProducto = '{!! route('ajax.pedidos.gurdarProducto') !!}';
            var urlActualizarProducto = '{!! route('ajax.pedidos.actualizarProducto') !!}';
            var urlEliminarProducto = '{!! route('ajax.pedidos.eliminarProducto') !!}';
            var urlCoordenadas = '{!! route('ajax.pedidos.coordenadas') !!}';
            var urlCoordenadasClientes = '{!! route('ajax.clientes.coordenadas') !!}';
            var urlCambiarFechaEntrega = '{!! route('ajax.pedido.cambiarFechaEntrega', ['pedido' => $pedido->id_comercial, 'fecha_entrega' => 'null']) !!}';

            $('#pedidos-index').addClass('mdc-list-item--active');

            // Inicialización de elementos de Material.io
            const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                return new mdc.textField.MDCTextField(el);
            });
            const selects = [].map.call(document.querySelectorAll('.mdc-select'), function(el) {
                return new mdc.select.MDCSelect(el);
            });
            const selectCop = new mdc.select.MDCSelect(document.querySelector('#mdc-select__cop'));
            const selectUnmed = new mdc.select.MDCSelect(document.querySelector('#unmed_producto_add'));
            const fechaEntrega = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_entrega'));
            @if ($pedido->cliente->listaDescuento)
                const dialogListaDescuentos = new mdc.dialog.MDCDialog(document.querySelector('#mdc-dialog-lista_descuentos'));
                const tableListaDescuentos = new mdc.dataTable.MDCDataTable(document.querySelector('#mdc-table-lista_descuentos'));
            @endif

            const tooltips = [].map.call(document.querySelectorAll('.mdc-tooltip'), function(el) {
                return new mdc.tooltip.MDCTooltip(el);
            });

            // Funciones iniciales
            datatableProductos();
            validarDatosEscenciales();
            fechaMinima();
            obtenerCoordenadas(urlCoordenadas);

            // Se inicializa el mapa
            mapCliente = L.map('map_cliente');
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapCliente);
            L.control.scale().addTo(mapCliente);
            if (cliente.latitud && cliente.longitud) {
                graficarMapa();
            }

            // Muestra el error de tope
            @if (Session::has('error_tope') && \Carbon\Carbon::now()->diffInSeconds(Session::get('error_tope')['fecha']) < 10)
                Swal.fire({
                    title: '{{ Session::get('error_tope')['titulo'] }}',
                    text: '{{ Session::get('error_tope')['mensaje'] }}',
                    icon: 'error'
                });
                @php
                    Session::forget('error_tope');
                @endphp
            @endif

            // Muestra el error de pedido mínimo
            @if (Session::has('error_pedido_minmo') && \Carbon\Carbon::now()->diffInSeconds(Session::get('error_pedido_minmo')['fecha']) < 10)
                Swal.fire({
                    title: '{{ Session::get('error_pedido_minmo')['titulo'] }}',
                    text: '{{ Session::get('error_pedido_minmo')['mensaje'] }}',
                    icon: 'error'
                });
                @php
                    Session::forget('error_pedido_minmo');
                @endphp
            @endif

            // Detectar el cambio de centro de operaciones
            selectCop.listen('MDCSelect:change', (el) => {
                if (selectCop.value) {
                    $('#cop').val(selectCop.value);
                    validarDatosEscenciales();
                }
            });

            // Detectar cuando se cambia la fecha de entrega
            $('#fecha_entrega').on('change', function(){
                validarDatosEscenciales();
            });

            $('.obtener-coordenadas').click(function() {
                if (navigator.geolocation) {
                    if (cliente.latitud && cliente.longitud) {
                        Swal.fire({
                            title: '¿Actualizar Coordenadas?',
                            text: "Esta acción reemplazará las coordenadas del cliente por las de tu ubicación actual.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '{{ $empresa->color }}',
                            confirmButtonText: 'Si, actualizar!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                navigator.geolocation.getCurrentPosition(showPosition, error, {maximumAge:0.001, timeout:5000, enableHighAccuracy: true});
                            }
                        });
                    } else {
                        navigator.geolocation.getCurrentPosition(showPosition, error, {maximumAge:0.001, timeout:5000, enableHighAccuracy: true});
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
                            cliente = response.cliente;
                            graficarMapa();
                            Swal.fire({
                                title: 'COORDENADAS ASIGNADAS!',
                                text: "Las coordenadas del cliente "+ cliente.nombre_cliente +' se han asignado correctamente.',
                                icon: 'success'
                            });
                        }).fail(function(error){
                            console.error(error);
                            Swal.fire({
                                title: 'ERROR!',
                                text: "La localización no está habilitada.",
                                icon: 'error'
                            });
                        });
                    }
                }

                function error(error) {
                    console.error(error);
                }
            });

            $('#fecha_entrega').change(function() {
                let nuevaFecha = $('#fecha_entrega').val();
                let url = urlCambiarFechaEntrega.replace('null', nuevaFecha);
                $.ajax({
                    method: 'GET',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function(response){
                    productosPedido = response.productos;
                    actualizarTotales();
                    datatableProductos();
                }).fail(function(error){
                    console.error(error);
                });
            });

            // Buscar productos por nombre y código
            $('#buscar_producto input').keyup(function(e){
                var nombreProducto = $(this).val().toUpperCase();
                var key = e.keyCode || e.charCode;
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if (!productoPorAgregar) {
                        $('#list_product_item-0').trigger('click');
                        $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                    } else {
                        $('#agregar_producto_lista').trigger('click');
                    }
                } else {
                    if(nombreProducto.length > 2){
                        buscarProductos(nombreProducto);
                    } else {
                        $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                    }
                }
            });

            // Ocultar los resultados de la búsqueda de productos
            $('#buscar_producto input').blur(function(){
                if ($('#mdc-menu__buscar_producto').hasClass('mdc-menu-surface--open')) {
                    $(document).click(function(){
                        $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                    });
                }
            });

            // Añadir el producto seleccionado al div de transición
            $('#mdc-menu__buscar_producto').on('click', '.mdc-list-item', function(){
                let index = $(this).data('index');
                productoPorAgregar = productosListado[index];
                // console.log(productoPorAgregar);
                if(productoPorAgregar) {
                    let validacion = productosPedido.filter(function (producto) {
                        return producto.id_producto == productoPorAgregar.id_producto;
                    });
                    if (validacion.length) {
                        @if ($pedido->cliente->listaPrecio->promocion)
                            Swal.fire({
                                title: 'El Producto ya está Agregado',
                                text: productoPorAgregar.nombre + ' ya está en el listado de productos del pedido. ¿Desea editarlo o agregar una nueva instancia?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '{{ $empresa->color }}',
                                confirmButtonText: 'Editar',
                                cancelButtonText: 'Nuevo'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    editarProducto(validacion[0]);
                                } else {
                                    nuevoProducto();
                                }
                            });
                        @else
                            if (productoPorAgregar.precio_unidad_inventario) {
                                Swal.fire({
                                    title: 'El Producto ya está Agregado',
                                    text: productoPorAgregar.nombre + ' ya está en el listado de productos del pedido. ¿Desea editarlo o agregar una nueva instancia?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '{{ $empresa->color }}',
                                    confirmButtonText: 'Editar',
                                    cancelButtonText: 'Nuevo'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        editarProducto(validacion[0]);
                                    } else {
                                        nuevoProducto();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'El Producto ya está Agregado',
                                    text: productoPorAgregar.nombre + ' ya está en el listado de productos del pedido. Solo se puede editar.' ,
                                    icon: 'warning'
                                });
                                editarProducto(validacion[0]);
                            }
                        @endif
                    } else {
                        nuevoProducto();
                    }
                }
                obtenerCoordenadas(urlCoordenadas);
            });

            // Detectar cuando se cambia la fecha de entrega
            $('#obsequio').on('change', function(){
                if ($(this).is(':checked')) {
                    @if(!$pedido->cliente->listaPrecio->iva_incluido)
                        $('#valor_iva_producto_add').text(parseFloat(0).toFixed(numDecimales));
                        productoPorAgregar.valorIva = 0;
                    @endif
                    $('#valor_producto_add').text(parseFloat(0).toFixed(numDecimales));
                    $('#subtotal_producto_add').text(parseFloat(0).toFixed(numDecimales));
                    $('#descuento_producto_add').text(parseFloat(0).toFixed(numDecimales));
                    productoPorAgregar.total = 0;
                    productoPorAgregar.totald = 0;
                    productoPorAgregar.subtotal = 0;
                } else {
                    calcularTotal();
                }
            });

            // Recalcular el subtotal del producto al cambiar el peso
            $('#cant_kg_producto_add input').change(function(){
                // console.log($('#cant_kg_producto_add input').val());
                console.log(productoPorAgregar);
                
                if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                    productoPorAgregar.undmed = 'KIL';
                    productoPorAgregar.peso = $('#cant_kg_producto_add input').val();
                    if ((productoPorAgregar.peso / productoPorAgregar.peso_unidad) > productoPorAgregar.unidades) {
                        productoPorAgregar.unidades = Math.ceil(parseFloat((productoPorAgregar.peso / productoPorAgregar.peso_unidad)));
                        $('#cant_un_producto_add input').val(productoPorAgregar.unidades);
                    }
                    @if($empresa->nombre == "Cadasa")
                        productoPorAgregar.precio_unidad_inventario = $('#valor_kg_add input').val();
                    @endif
                    productoPorAgregar.total = parseFloat((productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario).toFixed(numDecimales));
                    $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                    calcularTotal();
                }
            });

            @if ($empresa->nombre == "Cadasa")
                // Recalcular el subtotal del producto al cambiar el peso
                $('#valor_kg_add input').change(function(){
                    if ( parseFloat($('#valor_kg_add input').val()) < parseFloat($('#valor_kg_add input').attr('min')) || parseFloat($('#valor_kg_add input').val()) > parseFloat($('#valor_kg_add input').attr('max')) )
                    {
                        $('#valor_kg_add input').val($('#valor_kg_add input').attr('max'));
                    }

                    if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                        // console.log(productoPorAgregar);
                        productoPorAgregar.undmed = 'KG';
                        productoPorAgregar.peso = $('#cant_kg_producto_add input').val();
                        productoPorAgregar.precio_unidad_inventario = $('#valor_kg_add input').val();
                        productoPorAgregar.total = parseFloat((productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario).toFixed(numDecimales));
                        $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                        calcularTotal();
                    }
                });

                // Recalcular el subtotal del producto al cambiar el peso
                $('#valor_un_add input').change(function(){
                    if ( parseFloat($('#valor_un_add input').val()) < parseFloat($('#valor_un_add input').attr('min')) || parseFloat($('#valor_un_add input').val()) > parseFloat($('#valor_un_add input').attr('max')) )
                    {
                        $('#valor_un_add input').val($('#valor_un_add input').attr('max'));
                    }

                    if (selectUnmed.value == 'UND' || selectUnmed.value == 'UND ') {
                        // console.log(productoPorAgregar);
                        productoPorAgregar.undmed = 'UND';
                        productoPorAgregar.unidades = $('#cant_un_producto_add input').val();
                        productoPorAgregar.precio_unidad_empaque = $('#valor_un_add input').val();
                        productoPorAgregar.total = parseFloat((productoPorAgregar.peso * productoPorAgregar.precio_unidad_empaque).toFixed(numDecimales));
                        $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                        calcularTotal();
                    }
                });
            @endif

            @if ($empresa->nombre == 'San Marino')
                // Recalcular los kilogrmamos y el subtotal del producto al cambiar el factor
                $('#cant_fa_producto_add input').change(function(){
                    console.log($('#cant_fa_producto_add input').val());
                    if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                        productoPorAgregar.undmed = 'KG';
                        productoPorAgregar.peso = parseFloat(($('#cant_fa_producto_add input').val() * $('#cant_un_producto_add input').val()).toFixed(2));
                        productoPorAgregar.total = parseFloat((productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario).toFixed(numDecimales));
                        $('#cant_kg_producto_add input').val(productoPorAgregar.peso);
                        $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                        calcularTotal();
                    }
                });
            @endif

            // Recalcula el subtotal y el peso del producto al cambiar las unidades
            $('#cant_un_producto_add input').change(function(){
                productoPorAgregar.unidades = $('#cant_un_producto_add input').val();
                if (selectUnmed.value == 'UND' || selectUnmed.value == 'UND ') {
                    productoPorAgregar.undmed = 'UND';
                    productoPorAgregar.peso = parseFloat((productoPorAgregar.unidades * productoPorAgregar.peso_unidad).toFixed(2));
                    productoPorAgregar.total = parseFloat((productoPorAgregar.unidades * productoPorAgregar.precio_unidad_empaque).toFixed(numDecimales));
                    $('#cant_kg_producto_add input').val(productoPorAgregar.peso);
                    $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                    calcularTotal();
                }
                @if ($empresa->nombre == 'San Marino')
                    if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                        productoPorAgregar.undmed = 'KG';
                        productoPorAgregar.peso = parseFloat(($('#cant_fa_producto_add input').val() * $('#cant_un_producto_add input').val()).toFixed(2));
                        productoPorAgregar.total = parseFloat((productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario).toFixed(numDecimales));
                        $('#cant_kg_producto_add input').val(productoPorAgregar.peso);
                        $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                        calcularTotal();
                    }
                @endif
            });

            // Recalcular el subtotal del producto al cambiar la unidad de medida
            selectUnmed.listen('MDCSelect:change', (el) => {
                if (selectUnmed.value) {
                    productoPorAgregar.undmed = selectUnmed.value.replace(' ','');
                    if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                        productoPorAgregar.peso = $('#cant_kg_producto_add input').val();
                        productoPorAgregar.total = parseFloat((productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario).toFixed(2));
                        $('#cant_kg_producto_add input').removeAttr('readonly');
                    } else {
                        productoPorAgregar.peso = parseFloat((productoPorAgregar.unidades * productoPorAgregar.peso_unidad).toFixed(2));
                        productoPorAgregar.total = parseFloat((productoPorAgregar.unidades * productoPorAgregar.precio_unidad_empaque).toFixed(2));
                        $('#cant_kg_producto_add input').val(productoPorAgregar.peso).attr('readonly', 'readonly');
                    }
                    @if ($empresa->nombre == 'San Marino')
                        //$('#cant_kg_producto_add input').attr('readonly', 'readonly');
                    @endif
                    $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                    calcularTotal();
                }
            });

            $('#dcto_producto_add input').change(function(){
                calcularTotal();
            });

            // Añadir el producto que está en transición al listado de productos del pedido
            $('#agregar_producto_lista').click(function(){
                if (productoPorAgregar && pedido) {
                    // console.log($('#obsequio').is(':checked'));
                    // console.log(productoPorAgregar);
                    var totalPedido = 0;
                    for (let index = 0; index < productosPedido.length; index++) {
                        const producto = productosPedido[index];
                        totalPedido += producto.pivot.total;
                    }
                    $.ajax({
                        method: 'POST',
                        url: urlGuardarProducto,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id_comercial: pedido.id_comercial,
                            id_producto: productoPorAgregar.id_producto,
                            unidades: productoPorAgregar.unidades,
                            peso: productoPorAgregar.peso,
                            valor_un: productoPorAgregar.precio_unidad_empaque,
                            valor_kg: productoPorAgregar.precio_unidad_inventario,
                            venta_por: productoPorAgregar.undmed,
                            totald: productoPorAgregar.totald,
                            @if(!$pedido->cliente->listaPrecio->iva_incluido)
                                valor_iva: productoPorAgregar.valorIva,
                            @endif
                            total: productoPorAgregar.subtotal,
                            porcentaje_d: function(){
                                if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                                    @if ($empresa->nombre == 'San Marino')
                                        return ($('#dcto_producto_add input').val() * 100) / productoPorAgregar.precio_unidad_inventario;
                                    @else
                                        return $('#dcto_producto_add input').val()
                                    @endif
                                } else {
                                    @if ($empresa->nombre == 'San Marino')
                                        return ($('#dcto_producto_add input').val() * 100) / productoPorAgregar.precio_unidad_empaque;
                                    @else
                                        return $('#dcto_producto_add input').val();
                                    @endif
                                }
                            },
                            valor_total: productoPorAgregar.subtotal + totalPedido,
                            descuento: function() {
                                if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                                    @if ($empresa->nombre == 'San Marino')
                                        return $('#dcto_producto_add input').val();
                                    @else
                                        return parseFloat(((productoPorAgregar.precio_unidad_inventario * $('#dcto_producto_add input').val()) / 100).toFixed(2));
                                    @endif
                                } else {
                                    @if ($empresa->nombre == 'San Marino')
                                        return $('#dcto_producto_add input').val();
                                    @else
                                    return parseFloat(((productoPorAgregar.precio_unidad_empaque * $('#dcto_producto_add input').val()) / 100).toFixed(2));
                                    @endif
                                }
                            },
                            @if ($pedido->cliente->listaPrecio->promocion)
                                obsequio: function() {
                                    if ($('#obsequio').is(':checked')) {
                                        return 1;
                                    } else {
                                        return 0;
                                    }
                                },
                            @endif
                            @if ($empresa->nombre == 'San Marino')
                                tiquetear: function() {
                                    if ($('#tiquetear').is(':checked')) {
                                        return 1;
                                    } else {
                                        return 0;
                                    }
                                },
                            @endif
                        }
                    }).done(function(response){
                        //console.log(response);
                        productosPedido = response.productos;
                        actualizarTotales();
                        datatableProductos();
                    }).fail(function(error){
                        console.error(error);
                    });
                }
                reiniciarEdicion();
            });

            // Actualizar el producto que está en transición al listado de productos del pedido
            $('#actualizar_producto_lista').click(function(){
                if (productoPorAgregar && pedido) {
                    $.ajax({
                        method: 'POST',
                        url: urlActualizarProducto,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id_reg_comercial: productoPorAgregar.id_reg_comercial,
                            id_comercial: pedido.id_comercial,
                            id_producto: productoPorAgregar.id_producto,
                            unidades: productoPorAgregar.unidades,
                            peso: productoPorAgregar.peso,
                            venta_por: productoPorAgregar.undmed,
                            totald: productoPorAgregar.totald,
                            @if(!$pedido->cliente->listaPrecio->iva_incluido)
                                valor_iva: productoPorAgregar.valorIva,
                            @endif
                            total: productoPorAgregar.subtotal,
                            porcentaje_d: function(){
                                if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                                    @if ($empresa->nombre == 'San Marino')
                                        return ($('#dcto_producto_add input').val() * 100) / productoPorAgregar.precio_unidad_inventario;
                                    @else
                                        return $('#dcto_producto_add input').val()
                                    @endif
                                } else {
                                    @if ($empresa->nombre == 'San Marino')
                                        return ($('#dcto_producto_add input').val() * 100) / productoPorAgregar.precio_unidad_empaque;
                                    @else
                                        return $('#dcto_producto_add input').val();
                                    @endif
                                }
                            },
                            descuento: function() {
                                if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                                    @if ($empresa->nombre == 'San Marino')
                                        return $('#dcto_producto_add input').val();
                                    @else
                                    return parseFloat(((productoPorAgregar.precio_unidad_inventario * $('#dcto_producto_add input').val()) / 100).toFixed(2));
                                    @endif
                                } else {
                                    @if ($empresa->nombre == 'San Marino')
                                        return $('#dcto_producto_add input').val();
                                    @else
                                    return parseFloat(((productoPorAgregar.precio_unidad_empaque * $('#dcto_producto_add input').val()) / 100).toFixed(2));
                                    @endif
                                }
                            },
                            @if ($pedido->cliente->listaPrecio->promocion)
                                obsequio: function() {
                                    if ($('#obsequio').is(':checked')) {
                                        return 1;
                                    } else {
                                        return 0;
                                    }
                                },
                            @endif
                            @if ($empresa->nombre == 'San Marino')
                                tiquetear: function() {
                                    if ($('#tiquetear').is(':checked')) {
                                        return 1;
                                    } else {
                                        return 0;
                                    }
                                },
                            @endif
                        }
                    }).done(function(response){
                        productosPedido = response.productos;
                        actualizarTotales();
                        datatableProductos();
                    }).fail(function(error){
                        console.error(error);
                    });
                }
                reiniciarEdicion();
            });

            // Quitar producto del div de transición
            $('#quitar_producto_lista').click(function() {
                reiniciarEdicion();
            });

            // Eliminar el producto del pedido
            $('#productos').on('click', '.eliminar-producto', function(){
                let id_producto = $(this).data('id_producto');
                let id_reg_comercial = $(this).data('id_reg_comercial');
                let subtotal = $(this).data('subtotal');
                if (id_reg_comercial && pedido) {
                    $.ajax({
                        method: 'DELETE',
                        url: urlEliminarProducto,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id_reg_comercial: id_reg_comercial,
                            id_comercial: pedido.id_comercial,
                            id_producto: id_producto,
                            subtotal: subtotal
                        }
                    }).done(function(response){
                        productosPedido = response.productos;
                        actualizarTotales();
                        datatableProductos();
                    }).fail(function(error){
                        console.error(error);
                    });
                }
            });

            // Editar un producto del pedido
            $('#productos').on('click', '.editar-producto', function(){
                let index = $(this).data('index');
                let producto = productosPedido[index];
                productoPorAgregar = producto;
                productoPorAgregar.undmed = producto.pivot.venta_por;
                productoPorAgregar.precio_unidad_empaque = producto.pivot.valor_un;
                productoPorAgregar.precio_unidad_inventario = producto.pivot.valor_kg;
                productoPorAgregar.subtotal = producto.pivot.total;
                productoPorAgregar.totald = producto.pivot.totald;
                productoPorAgregar.total = producto.pivot.total + producto.pivot.totald;
                productoPorAgregar.unidades = producto.pivot.unidades;
                productoPorAgregar.peso = producto.pivot.peso;
                productoPorAgregar.valorIva = producto.pivot.valor_iva;
                productoPorAgregar.minimocant = producto.minimocant;
                editarProducto(producto);
            });

            // Enviar el pedido y cerrarlo
            $('.enviar_pedido').click(function(e){
                e.preventDefault();
                if (cliente.estado_cliente) {
                    if (pedido.latitud == '0' || pedido.longitud == '0' || !pedido.latitud || !pedido.longitud) {
                        Swal.fire({
                            title: '¿Cerrar Pedido Sin Ubicación?',
                            text: "La ubicación es un dato impórtante y no pudo ser tomada. Una vez cerrado el pedido no se podrá modificar ni cancelar.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '{{ $empresa->color }}',
                            confirmButtonText: 'Si, cerrar pedido!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#estado').val(1);
                                $('form').submit();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: '¿Cerrar Pedido?',
                            text: "Una vez cerrado el pedido no se podrá modificar ni cancelar.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '{{ $empresa->color }}',
                            confirmButtonText: 'Si, cerrar pedido!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#estado').val(1);
                                $('form').submit();
                            }
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'El pedido no se puede cerrar',
                        text: 'El cliente ' +cliente.nombre_cliente+ ' aún no ha sido creado en el sistema UNO. Comuníquese con el departamento de cartera para más información.' ,
                        icon: 'error'
                    });
                }
            });

            // Buscar productos por nombre o código
            function buscarProductos(busqueda) {
                let urlBuscar = urlBuscarProductos.replace('null', busqueda);
                $('#mdc-menu__buscar_producto').addClass('mdc-menu-surface--open');
                $('#mdc-menu__buscar_producto').empty();
                $('#mdc-menu__buscar_producto').append('<li class="mdc-list-item mdc-list-item--disabled" role="option"><span class="mdc-list-item__text">Buscando</span></li>');
                console.log(urlBuscar);
                $.ajax({
                    'url': urlBuscar,
                    'context': document.body
                }).done(function(response) {
                    // console.log(response);
                    $('#mdc-menu__buscar_producto').empty();
                    var productos = response.productos;
                    productosListado = response.productos;
                    if(productos.length) {
                        for (let index = 0; index < productos.length; index++) {
                            const producto = productos[index];
                            let tipoFila;
                            if (index % 2) {
                                tipoFila = 'odd';
                            } else {
                                tipoFila = 'pair';
                            }
                            if (producto.porcentaje == null || producto.porcentaje == 0) {
                                $('#mdc-menu__buscar_producto').append('<li tabindex="0" class="mdc-list-item mdc-list-item-'+ tipoFila +'" data-index="'+ index +'" role="option"><span class="mdc-list-item__text">'+ producto.codigo +' - '+ producto.nombre.toLowerCase() +'</span></li>');
                            } else {
                                $('#mdc-menu__buscar_producto').append('<li tabindex="0" class="mdc-list-item mdc-list-item-'+ tipoFila +'" data-index="'+ index +'" role="option"><span class="mdc-list-item__text">('+ producto.porcentaje +'% dto.) '+ producto.codigo +' - '+ producto.nombre.toLowerCase() +'</span></li>');
                            }
                        }
                    } else {
                        $('#mdc-menu__buscar_producto').append('<li class="mdc-list-item mdc-list-item--disabled" role="option"><span class="mdc-list-item__text">No hay productos</span></li>');
                    }
                });
            }

            function validarDatosEscenciales() {
                fechaMinima();
                let cop = $('#cop').val();
                if(cop && fechaEntrega.value && fechaEntrega.valid && productosPedido.length) {
                    $('.enviar_pedido').removeAttr('disabled');
                    return true;
                } else {
                    $('.enviar_pedido').attr('disabled', 'disabled');
                    return false;
                }
            }

            // Actualizar totales del pedido
            function actualizarTotales() {
                var totalPedido = 0;
                var totalItems = 0;
                for (let index = 0; index < productosPedido.length; index++) {
                    const producto = productosPedido[index];
                    totalItems++;
                    totalPedido += producto.pivot.total;
                }
                $('#valor_pedido').text('$ ' + numeroMiles(totalPedido.toFixed(numDecimales)));
                $('#valor_pedido_mv').text('$ ' + numeroMiles(totalPedido.toFixed(numDecimales)));
                $('#items_pedido').text(numeroMiles(totalItems));
                $('#items_pedido_mv').text(numeroMiles(totalItems));
                validarDatosEscenciales()
                return true;
            }

            // Imprimir número en formato de miles
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

            // Crear o rehacer el listado de productos del pedido
            function datatableProductos() {
                // console.log(productosPedido);
                $('#productos').DataTable({
                    destroy: true,
                    data: productosPedido,
                    pageLength: 10,
                    order: [],
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 1 },
                        { responsivePriority: 2, targets: 8 },
                        { responsivePriority: 3, targets: 0 },
                        { orderable: false, targets: [2, 9] },
                        { searchable: false, targets: [2, 3, 4, 5, 6, 7, 8, 9] }
                    ],
                    columns: [
                        {
                            title: 'Código',
                            data: 'codigo'
                        },
                        {
                            title: 'Nombre',
                            data: 'nombre',
                            className: 'capitalize',
                            render: function(data, type, row){
                                if (data) {
                                    return data.toLowerCase();
                                } else {
                                    return 'Producto Sin Nombre';
                                }
                            }
                        },
                        {
                            title: '',
                            data: 'codigo',
                            className: 'px-0',
                            render: function(data, type, row){
                                let iconoObsequio = '';
                                let iconoTiquetear = '';
                                if (row.pivot['obsequio']) {
                                    iconoObsequio = '<i aria-describedby="tooltip-obsequio_'+ row.codigo +'" class="fas fa-gift mr-1"></i><div id="tooltip-obsequio_'+ row.codigo +'" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">Eeste producto es un obsequio</div></div>';
                                }
                                if (row.pivot['tiquetear']) {
                                    iconoTiquetear = '<i aria-describedby="tooltip-tiquetear_'+ row.codigo +'" class="fas fa-tag mr-1"></i><div id="tooltip-tiquetear_'+ row.codigo +'" class="mdc-tooltip" role="tooltip" aria-hidden="true"><div class="mdc-tooltip__surface mdc-tooltip__surface-animation black">El producto se debe tiquetear</div></div>';
                                }
                                return iconoObsequio + iconoTiquetear;
                            }
                        },
                        {
                            title: 'Kil',
                            data: 'pivot.peso',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(parseFloat(data.toFixed(2)));
                            }
                        },
                        {
                            title: 'Und',
                            data: 'pivot.unidades',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'UM',
                            data: 'pivot.venta_por',
                            className: 'center'
                        },
                        {
                            title: 'Valor',
                            data: 'pivot',
                            className: 'right-align nowrap',
                            render: function(data, type, row){
                                if (data['venta_por'] == 'UN') {
                                    return '$ ' + numeroMiles(data['valor_un'].toFixed(numDecimales));
                                } else {
                                    return '$ ' + numeroMiles(data['valor_kg'].toFixed(numDecimales));
                                }
                            }
                        },
                        {
                            title: 'Dcto',
                            data: 'pivot.totald',
                            className: 'right-align nowrap',
                            render: function(data, type, row){
                                return '$ ' + numeroMiles(data.toFixed(numDecimales));
                            }
                        },
                        {
                            title: 'Subtotal',
                            data: 'pivot.total',
                            className: 'right-align nowrap',
                            render: function(data, type, row){
                                return '$ ' + numeroMiles(data.toFixed(numDecimales));
                            }
                        },
                        {
                            title: '',
                            data: 'pivot.id_reg_comercial',
                            ordering: false,
                            render: function(data, type, row, dataRow){
                                let buttonPc = '<button type="button" class="eliminar-producto eliminar-producto-pc btn-icon mr-1" data-subtotal='+ row.pivot.total +' data-id_producto='+ row.id_producto +' data-id_reg_comercial='+ data +'><i class="fas fa-trash-alt white-text"></i></button>';
                                let buttonEditarPc = '<button type="button" class="editar-producto eliminar-producto-pc btn-icon" data-index='+ dataRow.row +'><i class="fas fa-pen white-text"></i></button>';
                                let buttonMv = '<button class="mdc-button mdc-button--raised mdc-button--dense eliminar-producto eliminar-producto-mv mr-1" type="button" data-subtotal='+ row.pivot.total +' data-id_producto='+ row.id_producto +' data-id_reg_comercial='+ data +'><span class="mdc-button__label">Quitar</span></button>';
                                let buttonEditarMv = '<button class="mdc-button mdc-button--raised mdc-button--dense editar-producto eliminar-producto-mv" type="button" data-index='+ dataRow.row +'><span class="mdc-button__label">Editar</span></button>';
                                return  buttonPc + buttonEditarPc + buttonMv + buttonEditarMv;
                            }
                        }
                    ],
                    rowCallback: function(row, data) {
                        $(row).addClass('primary-on-hover').attr('data-id_producto', data['id_producto']);
                    },
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
            }

            // Reiniciar el panel de transición de productos
            function reiniciarEdicion() {
                // Reiniciando campos del div de edición
                $('#codigo_producto_add').text('');
                $('#nombre_producto_add').text('');
                selectUnmed.value = '';
                $('#unmed_producto_add_kg').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                $('#unmed_producto_add_un').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                $('#unmed_txt_producto_add').text('');
                $('#cant_kg_producto_add input').val(null);
                $('#cant_fa_producto_add input').val(null);
                $('#cant_un_producto_add input').val(null);
                $('#dcto_producto_add input').val(null);
                $('#valor_kg_add').text('');
                $('#valor_kg_add_mv').text('');
                $('#valor_un_add').text('');
                $('#valor_un_add_mv').text('');
                $('#valor_producto_add').text('');
                $('#descuento_producto_add').text('');
                $('#porciva_add').text('');
                $('#subtotal_producto_add').text('');
                @if(!$pedido->cliente->listaPrecio->iva_incluido)
                    $('#valor_iva_producto_add').text('');
                @endif

                // Desactivando campos del div de edición
                $('#alerta_lista_descuentos').hide();
                $('#alerta_producto_por_agregar').show();
                $('#cant_kg_producto_add').addClass('mdc-text-field--disabled');
                $('#cant_kg_producto_add input').attr('disabled', 'disabled');
                $('#cant_fa_producto_add').addClass('mdc-text-field--disabled');
                $('#cant_fa_producto_add input').attr('disabled', 'disabled');
                $('#cant_un_producto_add').addClass('mdc-text-field--disabled');
                $('#cant_un_producto_add input').attr('disabled', 'disabled');
                $('#dcto_producto_add').addClass('mdc-text-field--disabled');
                $('#dcto_producto_add input').attr('disabled', 'disabled');
                $('#unmed_producto_add').addClass('mdc-select--disabled');
                $('#unmed_producto_add .mdc-select__anchor').attr('aria-disabled', true);
                $('#quitar_producto_lista').attr('disabled', 'disabled');
                $('#agregar_producto_lista').attr('disabled', 'disabled').show();
                $('#actualizar_producto_lista').attr('disabled', 'disabled').hide();

                @if ($pedido->cliente->listaPrecio->promocion)
                    $('#obsequio').prop('checked', false).attr('disabled', 'disabled');
                @endif
                @if ($empresa->nombre == 'San Marino')
                    $('#tiquetear').prop('checked', false);
                @endif
            }

            function graficarMapa() {
                $('.geolocalizar').hide();
                $('.mapa_cliente').show();
                if (markerCliente != null) {
                    mapCliente.removeLayer(markerCliente);
                }
                if (circleCliente != null) {
                    mapCliente.removeLayer(circleCliente);
                }
                mapCliente.setView([cliente.latitud, cliente.longitud], 13);
                markerCliente = L.marker([cliente.latitud, cliente.longitud]);
                mapCliente.addLayer(markerCliente);
                if (cliente.precision > 40) {
                    circleCliente = L.circle([cliente.latitud, cliente.longitud], Math.round(cliente.precision));
                    mapCliente.addLayer(circleCliente);
                } else {
                    circleCliente = null;
                }
            }

            function obtenerCoordenadas(urlCoordenadas) {
                if (pedido.latitud == '0' || pedido.longitud == '0' || !pedido.latitud || !pedido.longitud) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(guardarPosicion, verError, {maximumAge:0.001, timeout:5000, enableHighAccuracy: true});
                    } else {
                        Swal.fire({
                            title: 'ALERTA!',
                            text: "La localización es obligatoria para cerrar el pedido. Intente cerrar el pedido en otro dispositivo.",
                            icon: 'error'
                        });
                    }
                }

                function guardarPosicion(position) {
                    $.ajax({
                        method: 'POST',
                        url: urlCoordenadas,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id_comercial: pedido.id_comercial,
                            longitud: position.coords.longitude,
                            latitud: position.coords.latitude,
                            precision: Math.round(position.coords.accuracy)
                        }
                    }).done(function(response){
                        pedido = response.pedido;
                    }).fail(function(error){
                        console.error(error);
                    });
                }

                function verError(error) {
                    console.error(error);
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            Swal.fire({
                                title: 'ALERTA!',
                                text: "Has bloqueado la localización. Debes permitirla, para poner tomar las coordenadas",
                                icon: 'error'
                            });
                            break;
                        case error.POSITION_UNAVAILABLE:
                            Swal.fire({
                                title: 'ALERTA!',
                                text: "La localización está deshabilitada. Revise la configuración de su dispositivo.",
                                icon: 'error'
                            });
                            break;
                        case error.TIMEOUT:
                            Swal.fire({
                                title: 'ALERTA!',
                                text: "La localización está deshabilitada. Revise la señal del dispositivo.",
                                icon: 'error'
                            });
                            break;
                        case error.UNKNOWN_ERROR:
                            Swal.fire({
                                title: 'ALERTA!',
                                text: "La localización está deshabilitada. Revise la configuración de su dispositivo.",
                                icon: 'error'
                            });
                            break;
                    }
                }
            }

            // Asigna la fecha de entrega mínima para el siguiente día
            @if($limite > 0)
                function fechaMinima() {
                    let hoy = new Date();
                    let limite =  new Date().setHours({{ date('H', strtotime($usuario->limite_mismo_dia)) }},{{ date('i', strtotime($usuario->limite_mismo_dia)) }},0,0);
                    let fechaMinima = new Date();
                    if (hoy.getTime() > limite) {
                        fechaMinima = addDays(fechaMinima, 1);
                    }
                    let dd = fechaMinima.getDate();
                    let mm = fechaMinima.getMonth() + 1;
                    let yyyy = fechaMinima.getFullYear();
                    if(dd < 10){
                        dd = '0' + dd;
                    }
                    if(mm < 10){
                        mm = '0' + mm;
                    }
                    fechaMinima = yyyy+'-'+mm+'-'+dd;
                    $('#fecha_entrega').attr('min', fechaMinima);
                }
            @else
                function fechaMinima() {
                    var today = new Date();
                    var dd = today.getDate() + 1;
                    var mm = today.getMonth() + 1;
                    var yyyy = today.getFullYear();
                    if(dd < 10){
                        dd = '0' + dd;
                    }
                    if(mm < 10){
                        mm = '0' + mm;
                    }
                    today = yyyy+'-'+mm+'-'+dd;
                    $('#fecha_entrega').attr('min', today);
                }
            @endif

            function addDays(date, days) {
                var result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
            }

            // Recalcula los totales del producto por agregar
            function calcularTotal() {
                @if($pedido->cliente->listaPrecio->promocion)
                    if ($('#obsequio').is(':checked')) {
                        @if(!$pedido->cliente->listaPrecio->iva_incluido)
                            $('#valor_iva_producto_add').text(parseFloat(0).toFixed(numDecimales));
                            productoPorAgregar.valorIva = 0;
                        @endif
                        $('#valor_producto_add').text(parseFloat(0).toFixed(numDecimales));
                        $('#subtotal_producto_add').text(parseFloat(0).toFixed(numDecimales));
                        $('#descuento_producto_add').text(parseFloat(0).toFixed(numDecimales));
                        productoPorAgregar.total = 0;
                        productoPorAgregar.totald = 0;
                        productoPorAgregar.subtotal = 0;
                        return true;
                    }
                @endif
                let porcentajeDescuento = $('#dcto_producto_add input').val();
                if (productoPorAgregar.rangos.length) {
                    // console.log(productoPorAgregar.rangos);
                    var cantidadAnterior;
                    var porcentajeAnterior;
                    for (let index = 0; index < productoPorAgregar.rangos.length; index++) {
                        const element = productoPorAgregar.rangos[index];
                        @if ($empresa->nombre == 'San Marino')

                            if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ')
                            {
                                if(index == 0) // comprueba que sea la primer iteracion.
                                {
                                    if (element.pivot.cantidad_kg && $('#cant_kg_producto_add input').val() < element.pivot.cantidad_kg)
                                    {
                                        porcentajeDescuento = 0;
                                        break;
                                    }
                                    else
                                    {
                                        cantidadAnterior = element.pivot.cantidad_kg;
                                        porcentajeAnterior = element.pivot.porcentaje;
                                    }
                                }
                                else if (index == (productoPorAgregar.rangos.length - 1)) //comprueba la última iteración
                                {
                                    if (element.pivot.cantidad_kg && $('#cant_kg_producto_add input').val() >= element.pivot.cantidad_kg)
                                    {
                                        porcentajeDescuento = element.pivot.porcentaje;
                                    }
                                    else
                                    {
                                        porcentajeDescuento = porcentajeAnterior;
                                    }

                                }
                                else
                                {
                                    if (element.pivot.cantidad_kg && $('#cant_kg_producto_add input').val() >= cantidadAnterior && $('#cant_kg_producto_add input').val() < element.pivot.cantidad_kg)
                                    {
                                        porcentajeDescuento = porcentajeAnterior;
                                        break;
                                    }
                                    else
                                    {
                                        cantidadAnterior = element.pivot.cantidad_kg;
                                        porcentajeAnterior = element.pivot.porcentaje;
                                    }
                                }

                            }
                            else
                            {
                                if(index == 0) // comprueba que sea la primer iteracion.
                                {
                                    if (element.pivot.cantidad_un && $('#cant_un_producto_add input').val() < element.pivot.cantidad_un)
                                    {
                                        porcentajeDescuento = 0;
                                        break;
                                    }
                                    else
                                    {
                                        cantidadAnterior = element.pivot.cantidad_un;
                                        porcentajeAnterior = element.pivot.porcentaje;
                                    }
                                }
                                else if (index == (productoPorAgregar.rangos.length - 1)) //comprueba la última iteración
                                {
                                    if (element.pivot.cantidad_un && $('#cant_un_producto_add input').val() >= element.pivot.cantidad_un)
                                    {
                                        porcentajeDescuento = element.pivot.porcentaje;
                                    }
                                    else
                                    {
                                        porcentajeDescuento = porcentajeAnterior;
                                    }

                                }
                                else
                                {
                                    if (element.pivot.cantidad_un && $('#cant_un_producto_add input').val() >= cantidadAnterior && $('#cant_un_producto_add input').val() < element.pivot.cantidad_un)
                                    {
                                        porcentajeDescuento = porcentajeAnterior;
                                        break;
                                    }
                                    else
                                    {
                                        cantidadAnterior = element.pivot.cantidad_un;
                                        porcentajeAnterior = element.pivot.porcentaje;
                                    }
                                }
                            }

                        @else

                        if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                            if (element.pivot.cantidad_kg && $('#cant_kg_producto_add input').val() <= element.pivot.cantidad_kg) {
                                    // console.log('kg: ' + $('#cant_kg_producto_add input').val());
                                    // console.log(element);
                                    if ($('#dcto_producto_add input').val() != element.pivot.porcentaje) {
                                        porcentajeDescuento = element.pivot.porcentaje;
                                    }
                                    break;
                                }
                            } else {
                                if (element.pivot.cantidad_un && $('#cant_un_producto_add input').val() <= element.pivot.cantidad_un) {
                                    // console.log('Ug: ' + $('#cant_un_producto_add input').val());
                                    // console.log(element);
                                    if ($('#dcto_producto_add input').val() != element.pivot.porcentaje) {
                                        porcentajeDescuento = element.pivot.porcentaje;
                                    }
                                    break;
                                }
                            }

                        @endif
                    }
                } else {
                    if (productoPorAgregar.porcentaje == null || productoPorAgregar.porcentaje == 0) {
                        if (porcentajeDescuento > porcentajeMaximo) {
                            porcentajeDescuento = porcentajeMaximo;
                        } else if (porcentajeDescuento < 0) {
                            porcentajeDescuento = 0;
                        }
                    }
                }
                $('#dcto_producto_add input').val(porcentajeDescuento);
                @if ($empresa->nombre == 'San Marino')
                    if(productoPorAgregar.undmed == "KG")
                    {
                        productoPorAgregar.totald = parseFloat(((productoPorAgregar.peso * porcentajeDescuento)).toFixed(numDecimales));
                    } else {
                        productoPorAgregar.totald = parseFloat(((productoPorAgregar.unidades * porcentajeDescuento)).toFixed(numDecimales));
                    }
                @else
                    productoPorAgregar.totald = parseFloat(((productoPorAgregar.total * porcentajeDescuento) / 100).toFixed(numDecimales));
                @endif
                productoPorAgregar.subtotal = productoPorAgregar.total - productoPorAgregar.totald;
                @if(!$pedido->cliente->listaPrecio->iva_incluido)
                    productoPorAgregar.valorIva = (productoPorAgregar.total - productoPorAgregar.totald) * productoPorAgregar.porciva / 100;
                    productoPorAgregar.subtotal = (productoPorAgregar.total - productoPorAgregar.totald) + productoPorAgregar.valorIva;
                    $('#valor_iva_producto_add').text(numeroMiles(productoPorAgregar.valorIva.toFixed(numDecimales)));
                @endif
                $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.subtotal.toFixed(numDecimales)));
                $('#descuento_producto_add').text(numeroMiles(productoPorAgregar.totald.toFixed(numDecimales)));
            }

            function iniciarDivTrancision() {
                $('#alerta_producto_por_agregar').hide();
                $('#cant_kg_producto_add').removeClass('mdc-text-field--disabled');
                $('#cant_kg_producto_add input').removeAttr('disabled');
                $('#cant_un_producto_add').removeClass('mdc-text-field--disabled');
                $('#cant_un_producto_add input').removeAttr('disabled');
                $('#cant_fa_producto_add').removeClass('mdc-text-field--disabled');
                $('#cant_fa_producto_add input').removeAttr('disabled');
                $('#dcto_producto_add').removeClass('mdc-text-field--disabled');
                $('#dcto_producto_add input').removeAttr('disabled');
                $('#quitar_producto_lista').removeAttr('disabled');
                @if ($pedido->cliente->listaPrecio->promocion && in_array($usuario->nivel, ['u_movil_especial', 'u_movil']))
                    $('#obsequio').removeAttr('disabled');
                @endif
                selectUnmed.disabled = false;
            }

            function nuevoProducto() {
                productoPorAgregar.unidades = 1;
                console.log(productoPorAgregar);
                console.log(productoPorAgregar.undmed);
                $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                $('#mdc-menu__buscar_producto').empty();
                $('#buscar_producto input').val('');

                $('#codigo_producto_add').text(productoPorAgregar.codigo);
                $('#nombre_producto_add').text(productoPorAgregar.nombre.toLowerCase());
                $('#porciva_add').text(productoPorAgregar.porciva);
                $('#porciva_add_mv').text(productoPorAgregar.porciva);
                @if ($empresa->nombre == "Cadasa")
                    $('#valor_kg_add input').val(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_kg_add_mv input').val(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));

                    $('#valor_un_add input').val(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                    $('#valor_un_add_mv input').val(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));

                    $('#valor_kg_add input').attr('min', numeroMiles(productoPorAgregar.minimocant.toFixed(numDecimales)));
                    $('#valor_kg_add_mv input').attr('min', numeroMiles(productoPorAgregar.minimocant.toFixed(numDecimales)));
                    $('#valor_kg_add input').attr('max', numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_kg_add_mv input').attr('max', numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));

                    $('#valor_un_add input').attr('min', numeroMiles(productoPorAgregar.minimoemp.toFixed(numDecimales)));
                    $('#valor_un_add_mv input').attr('min', numeroMiles(productoPorAgregar.minimoemp.toFixed(numDecimales)));
                    $('#valor_un_add input').attr('max', numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                    $('#valor_un_add_mv input').attr('max', numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                @else
                    $('#valor_kg_add').text(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_kg_add_mv').text(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_un_add').text(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                    $('#valor_un_add_mv').text(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                @endif
                $('#cant_fa_producto_add input').val(productoPorAgregar.peso_unidad).attr('readonly', 'readonly');

                if(productoPorAgregar.precio_unidad_empaque > 1 && productoPorAgregar.precio_unidad_inventario > 1) {
                    selectUnmed.value = productoPorAgregar.undmed.replace(' ', '');
                    $('#unmed_producto_add_kg').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_producto_add_un').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_txt_producto_add').text(productoPorAgregar.undmed.toLowerCase());
                    $('#cant_un_producto_add input').val(1);
                    if (selectUnmed.value == 'KIL' || selectUnmed.value == 'KIL ') {
                        productoPorAgregar.peso = productoPorAgregar.peso_unidad;
                        productoPorAgregar.subtotal = productoPorAgregar.precio_unidad_inventario * productoPorAgregar.peso;
                        productoPorAgregar.total = productoPorAgregar.precio_unidad_inventario * productoPorAgregar.peso;
                        $('#cant_kg_producto_add input').val(productoPorAgregar.peso_unidad);
                        $('#cant_kg_producto_add input').removeAttr('readonly');
                        @if ($empresa->nombre == "Cadasa")
                            $('#valor_kg_add input').removeAttr('readonly');
                        @endif
                        @if ($empresa->nombre == 'San Marino')
                            $('#cant_fa_producto_add input').removeAttr('readonly');
                        @else
                            $('#cant_fa_producto_add input').attr('readonly', 'readonly');
                        @endif
                        $('#valor_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    } else {
                        productoPorAgregar.subtotal = productoPorAgregar.precio_unidad_empaque;
                        productoPorAgregar.total = productoPorAgregar.precio_unidad_empaque;
                        $('#cant_kg_producto_add input').val(productoPorAgregar.peso_unidad).attr('readonly', 'readonly');
                        $('#valor_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                        @if ($empresa->nombre == "Cadasa")
                            $('#valor_kg_add input').removeAttr('readonly');
                        @endif
                    }
                } else if (productoPorAgregar.precio_unidad_inventario > 1) {
                    selectUnmed.value = 'KIL';
                    productoPorAgregar.undmed = 'KIL';
                    productoPorAgregar.peso = productoPorAgregar.peso_unidad;
                    productoPorAgregar.subtotal = productoPorAgregar.precio_unidad_inventario * productoPorAgregar.peso;
                    productoPorAgregar.total = productoPorAgregar.precio_unidad_inventario * productoPorAgregar.peso;
                    // console.log(productoPorAgregar);
                    $('#unmed_producto_add_kg').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_producto_add_un').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                    $('#cant_kg_producto_add input').val(productoPorAgregar.peso_unidad);
                    $('#cant_un_producto_add input').val(1);
                    $('#cant_kg_producto_add input').removeAttr('readonly');
                    @if ($empresa->nombre == "Cadasa")
                        $('#valor_kg_add input').removeAttr('readonly');
                    @endif
                    @if ($empresa->nombre == 'San Marino')
                        $('#cant_fa_producto_add input').removeAttr('readonly');
                        //$('#cant_kg_producto_add input').attr('readonly', 'readonly');
                    @else
                        $('#cant_fa_producto_add input').attr('readonly', 'readonly');
                    @endif
                    $('#valor_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                } else {
                    selectUnmed.value = 'UND';
                    productoPorAgregar.undmed = 'UND';
                    productoPorAgregar.peso = productoPorAgregar.peso_unidad;
                    productoPorAgregar.subtotal = productoPorAgregar.precio_unidad_empaque;
                    productoPorAgregar.total = productoPorAgregar.precio_unidad_empaque;
                    // console.log(productoPorAgregar);
                    $('#unmed_producto_add_un').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_producto_add_kg').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                    $('#cant_kg_producto_add input').val(productoPorAgregar.peso_unidad);
                    if (productoPorAgregar.peso_unidad > 0.01) {
                        $('#cant_kg_producto_add input').attr('readonly', 'readonly');
                    } else {
                        $('#cant_kg_producto_add input').removeAttr('readonly');
                    }
                    @if ($empresa->nombre == "Cadasa")
                        $('#valor_kg_add input').removeAttr('readonly');
                    @endif
                    @if ($empresa->nombre == 'San Marino')
                        //$('#cant_kg_producto_add input').attr('readonly', 'readonly');
                    @else
                        // nada
                    @endif
                    $('#cant_un_producto_add input').val(1);
                    $('#valor_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                }
                productoPorAgregar.totald = 0;
                // console.log(porcentajeMaximo);
                if (productoPorAgregar.porcentaje == null || productoPorAgregar.porcentaje == 0) {
                    // $('#dcto_producto_add input').attr('max', porcentajeMaximo).val(porcentajeMaximo);
                    // productoPorAgregar.totald = productoPorAgregar.subtotal * porcentajeMaximo / 100;
                    $('#dcto_producto_add input').attr('max', porcentajeMaximo).val(0);
                    productoPorAgregar.totald = 0;
                } else {
                    $('#dcto_producto_add input').attr('max', productoPorAgregar.porcentaje).val(productoPorAgregar.porcentaje);
                    productoPorAgregar.totald = productoPorAgregar.subtotal * productoPorAgregar.porcentaje / 100;
                }
                productoPorAgregar.subtotal = productoPorAgregar.subtotal - productoPorAgregar.totald;
                @if(!$pedido->cliente->listaPrecio->iva_incluido)
                    productoPorAgregar.valorIva = productoPorAgregar.subtotal * productoPorAgregar.porciva / 100;
                    productoPorAgregar.subtotal = productoPorAgregar.subtotal + productoPorAgregar.valorIva;
                    $('#valor_iva_producto_add').text(numeroMiles(productoPorAgregar.valorIva.toFixed(numDecimales)));
                @endif
                $('#descuento_producto_add').text(numeroMiles(productoPorAgregar.totald.toFixed(numDecimales)));
                $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.subtotal.toFixed(numDecimales)));
                if (productoPorAgregar.rangos.length) {
                    // console.log(productoPorAgregar.rangos);
                    $('#alerta_lista_descuentos').show();
                    calcularTotal();
                } else {
                    $('#alerta_lista_descuentos').hide();
                }
                iniciarDivTrancision();
                $('#dcto_producto_add input').removeAttr('disabled');
                $('#agregar_producto_lista').removeAttr('disabled').show();
                $('#actualizar_producto_lista').attr('disabled', 'disabled').hide();
            }

            function editarProducto(producto) {
                $('#cant_un_producto_add input').focus();
                $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                $('#mdc-menu__buscar_producto').empty();
                $('#buscar_producto input').val('');

                $('#codigo_producto_add').text(producto.codigo);
                $('#nombre_producto_add').text(producto.nombre.toLowerCase());
                $('#porciva_add').text(productoPorAgregar.porciva);
                $('#porciva_add_mv').text(productoPorAgregar.porciva);
                $('#cant_fa_producto_add input').val(productoPorAgregar.peso_unidad).attr('readonly', 'readonly');
                productoPorAgregar.peso = producto.pivot.peso;
                productoPorAgregar.id_reg_comercial = producto.pivot.id_reg_comercial;
                productoPorAgregar.unidades = producto.pivot.unidades;
                productoPorAgregar.subtotal = producto.pivot.total;
                productoPorAgregar.totald = producto.pivot.totald;
                productoPorAgregar.valorIva = producto.pivot.valor_iva;
                productoPorAgregar.total = producto.pivot.total + producto.pivot.totald;
                productoPorAgregar.undmed = producto.pivot.venta_por.replace(' ', '');
                productoPorAgregar.minimocant = producto.minimocant;
                @if ($empresa->nombre == "Cadasa")
                    $('#valor_kg_add input').val(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_kg_add_mv input').val(numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_un_add input').val(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));
                    $('#valor_un_add_mv input').val(numeroMiles(productoPorAgregar.precio_unidad_empaque.toFixed(numDecimales)));

                    $('#valor_kg_add input').attr('min', numeroMiles(productoPorAgregar.minimocant.toFixed(numDecimales)));
                    $('#valor_kg_add_mv input').attr('min', numeroMiles(productoPorAgregar.minimocant.toFixed(numDecimales)));
                    $('#valor_kg_add input').attr('max', numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                    $('#valor_kg_add_mv input').attr('max', numeroMiles(productoPorAgregar.precio_unidad_inventario.toFixed(numDecimales)));
                @else
                    $('#valor_kg_add').text(numeroMiles(producto.pivot.valor_kg.toFixed(numDecimales)));
                    $('#valor_kg_add_mv').text(numeroMiles(producto.pivot.valor_kg.toFixed(numDecimales)));
                    $('#valor_un_add').text(numeroMiles(producto.pivot.valor_un.toFixed(numDecimales)));
                    $('#valor_un_add_mv').text(numeroMiles(producto.pivot.valor_un.toFixed(numDecimales)));
                @endif
                if(producto.pivot.valor_kg > 1 && producto.pivot.valor_un > 1) {
                    productoPorAgregar.undmed = producto.pivot.venta_por.replace(' ', '');
                    $('#unmed_producto_add_kg').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_producto_add_un').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    if (productoPorAgregar.undmed == 'KG') {
                        $('#cant_kg_producto_add input').removeAttr('readonly');
                        @if ($empresa->nombre == "Cadasa")
                            $('#valor_kg_add input').removeAttr('readonly');
                        @endif
                        @if ($empresa->nombre == 'San Marino')
                            $('#cant_fa_producto_add input').removeAttr('readonly').val(parseFloat((productoPorAgregar.peso / productoPorAgregar.unidades).toFixed(2)));
                        @else
                            $('#cant_fa_producto_add input').attr('readonly', 'readonly');
                        @endif
                    } else {
                        $('#cant_kg_producto_add input').attr('readonly', 'readonly');
                    }
                } else if (producto.pivot.valor_kg > 1) {
                    productoPorAgregar.undmed = 'KG';
                    $('#unmed_producto_add_kg').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_producto_add_un').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                    $('#cant_kg_producto_add input').removeAttr('readonly');
                    @if ($empresa->nombre == "Cadasa")
                        $('#valor_kg_add input').removeAttr('readonly');
                    @endif
                    @if ($empresa->nombre == 'San Marino')
                        $('#cant_fa_producto_add input').removeAttr('readonly').val(parseFloat((productoPorAgregar.peso / productoPorAgregar.unidades).toFixed(2)));
                    @else
                        $('#cant_fa_producto_add input').attr('readonly', 'readonly');
                    @endif
                } else {
                    productoPorAgregar.undmed = 'UN';
                    $('#unmed_producto_add_un').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                    $('#unmed_producto_add_kg').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                    if (productoPorAgregar.peso_unidad > 0.01) {
                        $('#cant_kg_producto_add input').attr('readonly', 'readonly');
                    } else {
                        $('#cant_kg_producto_add input').removeAttr('readonly');
                        @if ($empresa->nombre == "Cadasa")
                            $('#valor_kg_add input').removeAttr('readonly');
                        @endif
                    }
                }
                if (productoPorAgregar.porcentaje == null || productoPorAgregar.porcentaje == 0) {
                    $('#dcto_producto_add input').attr('max', porcentajeMaximo).val(0);
                    let desc;
                    if (producto.pivot.valor_kg) {
                        desc = producto.pivot.descuento * 100 / producto.pivot.valor_kg;
                        $('#cant_kg_producto_add input').val(parseFloat(producto.pivot.peso.toFixed(2)));
                    } else {
                        productoPorAgregar.peso = producto.peso_unidad * producto.pivot.unidades;
                        desc = producto.pivot.descuento * 100 / producto.pivot.valor_un;
                        $('#cant_kg_producto_add input').val(parseFloat((producto.peso_unidad * producto.pivot.unidades).toFixed(2)));
                    }
                    $('#dcto_producto_add input').val(desc);
                } else {
                    $('#dcto_producto_add input').attr('max', productoPorAgregar.porcentaje).val(productoPorAgregar.porcentaje);
                    productoPorAgregar.totald = productoPorAgregar.total * productoPorAgregar.porcentaje / 100;
                    productoPorAgregar.subtotal = productoPorAgregar.total - productoPorAgregar.totald;
                }
                @if(!$pedido->cliente->listaPrecio->iva_incluido)
                    $('#valor_iva_producto_add').text(numeroMiles(productoPorAgregar.valorIva.toFixed(numDecimales)));
                @endif
                selectUnmed.value = productoPorAgregar.undmed;
                $('#cant_un_producto_add input').val(numeroMiles(producto.pivot.unidades));
                $('#valor_producto_add').text(numeroMiles(productoPorAgregar.total.toFixed(numDecimales)));
                $('#descuento_producto_add').text(numeroMiles(productoPorAgregar.totald.toFixed(numDecimales)));
                $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.subtotal.toFixed(numDecimales)));
                @if ($pedido->cliente->listaPrecio->promocion)
                    if (productoPorAgregar.pivot.obsequio) {
                        $('#obsequio').prop('checked', true);
                    }
                @endif
                @if ($empresa->nombre == 'San Marino')
                    if (productoPorAgregar.pivot.tiquetear) {
                        $('#tiquetear').prop('checked', true);
                    }
                @endif
                if (productoPorAgregar.rangos.length) {
                    $('#alerta_lista_descuentos').show();
                    calcularTotal();
                } else {
                    $('#alerta_lista_descuentos').hide();
                }
                iniciarDivTrancision();
                $('#actualizar_producto_lista').removeAttr('disabled').show();
                $('#agregar_producto_lista').attr('disabled', 'disabled').hide();
            }

            @if ($pedido->cliente->listaDescuento)
                $('#alerta_lista_descuentos').on('click', 'a', function() {
                    $('#mdc-table-lista_descuentos .mdc-data-table__content').empty();
                    let col = '<th class="mdc-data-table__cell" scope="row">-----</th>';
                    let colNumeic = '<th class="mdc-data-table__cell mdc-data-table__header-cell--numeric" scope="row">-----</th>';
                    for (let index = 0; index < productoPorAgregar.rangos.length; index++) {
                        const element = productoPorAgregar.rangos[index];
                        @if ($empresa->nombre == 'San Marino')
                        const elementRow = '<tr class="mdc-data-table__row">' + col.replace('-----', element.pivot.rango) + colNumeic.replace('-----', numeroMiles(element.pivot.cantidad_kg)) + colNumeic.replace('-----', numeroMiles(element.pivot.cantidad_un)) + colNumeic.replace('-----', ('$' + numeroMiles(element.pivot.porcentaje))) + '</tr>';
                        @else
                        const elementRow = '<tr class="mdc-data-table__row">' + col.replace('-----', element.pivot.rango) + colNumeic.replace('-----', numeroMiles(element.pivot.cantidad_kg)) + colNumeic.replace('-----', numeroMiles(element.pivot.cantidad_un)) + colNumeic.replace('-----', numeroMiles(element.pivot.porcentaje) + ' %') + '</tr>';
                        @endif
                        $('#mdc-table-lista_descuentos .mdc-data-table__content').append(elementRow);
                    }
                    $('#codigo_producto_lista_descuento').text(productoPorAgregar.codigo);
                    $('#nombre_producto_lista_descuento').text(productoPorAgregar.nombre);
                    $('#undmed_producto_lista_descuento').text(selectUnmed.value);
                    if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                        $('#cantidad_producto_lista_descuento').text($('#cant_kg_producto_add input').val());
                    } else {
                        $('#cantidad_producto_lista_descuento').text($('#cant_un_producto_add input').val());
                    }
                    dialogListaDescuentos.open();
                });
            @endif

            const coordenadas = await geolocalizar();
            // console.log(coordenadas);
            @if($pedido->cliente->tope && $pedido->cliente->valor_facturado >= 46000000 && $pedido->cliente->valor_facturado + $pedido->productos->sum('pivot.total') <= $pedido->cliente->tope)
                Swal.fire({
                    title: 'El Cliente se acerca al Tope Anual',
                    text: `El cliente {{ $pedido->cliente->nombre_cliente }} se acerca al tope de compras SAGRILAFT ($ ${numeroMiles({{ $pedido->cliente->tope }})}), por favor solicitar la informacion correspondiente. Evite el bloqueo del pedido`,
                    icon: 'warning'
                });
            @endif
        });
    </script>
@endsection

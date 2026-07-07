@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
@endsection

@section('content')
    <form action="" method="POST" id="main-form">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m4">
                    <h1 class="title">Nuevo Pedido</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.index') }}" class="breadcrumb">Pedidos</a>
                        <a class="breadcrumb current-breadcrumb">Nuevo</a>
                    </div>
                </div>
                <div class="col s12 m8 right-align hide-on-small-only">
                    @if($usuario->nivel == "u_callcenter")
                    <a class="mdc-button mdc-button--raised mdc-button--large mb-1" href="{{ route('pedidos.createLlamada') }}">
                        <span class="mdc-button__label mr-1">Pedido en Llamada</span>
                        <i class="fas fa-phone"></i>
                    </a>
                    @endif
                    <a class="mdc-button mdc-button--outlined mdc-button--large mb-1" href="{{route('dashboard')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large mb-1 enviar_pedido" id="enviar_pedido" type="submit" disabled>
                        <span class="mdc-button__label mr-1">Cerrar Pedido</span>
                        <i class="fas fa-truck"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                @if (!$usuario->cliente)
                    <div class="col s12">
                        <div class="card highlighted bg-primary white-text">
                            <div class="card-content center">
                                <span class="card-title highlighted center mb-1">USUARIO SIN NIT PREDETERMINADO</span>
                                <span class="card-subtitle subtitle-2 highlighted mb-0">Comunícate con departamento de Sistemas para solucionar este problema</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col s12 l3">
                    <div class="row mb-0">
                        <div class="col s12 m6 l12">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title mb-3">Opciones del Pedido</span>
                                    <div class="row mb-0">
                                        <input type="number" class="hide" name="estado" id="estado" value="0">
                                        <input type="text" class="hide" name="id_comercial" id="id_comercial" value="">
                                        <div class="col s12 mb-2">
                                            <div class="mdc-select mdc-select--outlined mdc-select--dense" id="mdc-select__cop">
                                                <div class="mdc-select__anchor" aria-labelledby="outlined-select-label">
                                                    <input type="text" name="cop" id="cop" class="mdc-select__input-value" value="">
                                                    <span id="cop__selected-text" class="mdc-select__selected-text"></span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
                                                    </span>
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span id="outlined-select-label" class="mdc-floating-label">Centro de Distribución</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                </div>
                                                <!-- Other elements from the select remain. -->
                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox">
                                                    <ul class="mdc-list">
                                                        @if ($usuario->nivel == 'u_ventadirecta')
                                                            <li class="mdc-list-item" data-value="{{ $usuario->centroDist->cop }}" role="option">
                                                                <span class="mdc-list-item__text">{{ ucfirst(strtolower($usuario->centroDist->nombre)) }}</span>
                                                            </li>
                                                        @else
                                                            @forelse ($usuario->centrosDist as $centro)
                                                                <li class="mdc-list-item" data-value="{{ $centro->cop }}" role="option">
                                                                    <span class="mdc-list-item__text">{{ ucfirst(strtolower($centro->nombre)) }}</span>
                                                                </li>
                                                            @empty
                                                                @if ($usuario->cop)
                                                                    <li class="mdc-list-item" data-value="{{ $usuario->centroDist->cop }}" role="option">
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
                                                @if ($usuario->nivel == 'u_ventadirecta')
                                                <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_entrega" name="fecha_entrega" id="fecha_entrega" value="2022-12-01">
                                                @else
                                                <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_entrega" name="fecha_entrega" id="fecha_entrega">
                                                @endif
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_fecha_entrega">Fecha de Entrega</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col s12">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--textarea-dense">
                                                <span class="mdc-text-field__resizer">
                                                    <textarea class="mdc-text-field__input" rows="2" cols="40" aria-label="Label" name="observacion_pedido" id="observacion_pedido"></textarea>
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
                        <div class="col s12 m6 l12">
                            <div class="card highlighted mb-0">
                                <div class="card-content">
                                    <span class="card-title mb-3">Datos del Cliente</span>
                                    <div class="row mb-0" id="no_clientevd">
                                        <div class="col s12">
                                            <button class="mdc-button mdc-button--raised full-width modal-trigger mb-1" data-target="buscar_cliente_modal" id="agregar_cliente" type="button">
                                                <span class="mdc-button__label mr-1">Buscar cliente</span>
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button class="mdc-button mdc-button--outlined full-width modal-trigger" data-target="nuevo_cliente_modal" id="nuevo_cliente" type="button">
                                                <span class="mdc-button__label mr-1">Nuevo cliente</span>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-0" id="data_clientevd" style="display: none;">
                                        <input type="text" class="hide" value="" name="id_cliente_vd" id="id_cliente_vd">
                                        <input type="text" class="hide" value="" name="tipo_cliente" id="tipo_cliente">
                                        <div class="col s12 mb-1">
                                            <label>Nombre</label>
                                            <span class="card-subtitle highlighted" id="nombre_clientevd"></span>
                                        </div>
                                        <div class="col s6 mb-1" id="div-telefono_clientevd">
                                            <label>Teléfono</label>
                                            <a class="card-subtitle subtitle-3 highlighted" id="telefono_clientevd" style="cursor: pointer;"></a>
                                            <a id="href-telefono_clientevd" href="" style="display: none"></a>
                                        </div>
                                        <div class="col s6 mb-1" id="div-cedula_clientevd">
                                            <label>Cédula</label>
                                            <span class="card-subtitle subtitle-3 highlighted" id="cedula_clientevd"></span>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <label>Dirección</label>
                                            <span class="card-subtitle subtitle-3 highlighted" id="direccion_clientevd"></span>
                                            <span class="card-subtitle subtitle-3 highlighted" id="barrio_clientevd"></span>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <label>Ciudad</label>
                                            <span class="card-subtitle subtitle-3 highlighted capitalize" id="ciudad_clientevd"></span>
                                        </div>
                                        <div class="col s12 mb-1" id="div-correo_electronico_clientevd">
                                            <label>Correo Electrónico</label>
                                            <span style="color: rgba(0, 0, 0, 0.87);" class="card-subtitle subtitle-4 highlighted" id="correo_electronico_clientevd"></span>
                                        </div>
                                        <div class="col s12 right-align mt-1">
                                            <button class="mdc-button mdc-button--outlined mdc-button--dense modal-trigger" data-target="buscar_cliente_modal" id="cambiar_cliente" type="button">
                                                <span class="mdc-button__label">Cambiar</span>
                                            </button>
                                            <button class="mdc-button mdc-button--raised mdc-button--dense" id="editar_cliente" type="button">
                                                <span class="mdc-button__label">Editar</span>
                                            </button>
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
                                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_buscar_producto" name="buscar_producto" autocomplete="off" disabled>
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
                                    <span class="card-title highlighted center" id="valor_pedido">$ 0</span>
                                    <div class="row mb-0">
                                        <div class="col s8">
                                            <label>Estado</label>
                                            <span class="card-subtitle highlighted" id="estado_pedido">Borrador</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label># Items</label>
                                            <span class="card-subtitle highlighted right-align" id="items_pedido">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="card highlighted relative">
                                <div class="card-content full-height d-flex f-column justify-content-center">
                                    <div class="row mb-0">
                                        <div class="col s12 m8 xl9 border-right">
                                            <div class="row mb-1">
                                                <div class="col s12 m6 xl8">
                                                    <label>Código: <span id="codigo_producto_add"></span></label>
                                                    <span class="card-subtitle subtitle-3 highlighted capitalize" id="nombre_producto_add"></span>
                                                </div>
                                                <div class="col s6 m3 xl2">
                                                    <label>Valor x Kg</label>
                                                    <span class="card-subtitle subtitle-3 highlighted">$ <span id="valor_kg_add"></span></span>
                                                </div>
                                                <div class="col s6 m3 xl2">
                                                    <label>Valor x Un</label>
                                                    <span class="card-subtitle subtitle-3 highlighted">$ <span id="valor_un_add"></span></span>
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="col s4">
                                                    <label>Facturar Por</label>
                                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense mdc-select--no-label mdc-select--disabled" style="max-width: 100px;" id="unmed_producto_add">
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
                                                                <li class="mdc-list-item" data-value="KG" id="unmed_producto_add_kg">
                                                                    <span class="mdc-list-item__ripple"></span>
                                                                    <span class="mdc-list-item__text">KG</span>
                                                                </li>
                                                                <li class="mdc-list-item" data-value="UN" id="unmed_producto_add_un">
                                                                    <span class="mdc-list-item__ripple"></span>
                                                                    <span class="mdc-list-item__text">UN</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col s4">
                                                    <label>Kilogramos</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_kg_producto_add" style="max-width: 100px; display: block;">
                                                        <input class="mdc-text-field__input cantidad_producto" type="number" step="0.01" aria-labelledby="my-label-id" name="cantidad_producto[]" max="100" min="0.01" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s4">
                                                    <label>Unidades</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_un_producto_add" style="max-width: 100px; display: block;">
                                                        <input class="mdc-text-field__input cantidad_producto" type="number" aria-labelledby="my-label-id" name="cantidad_producto[]" max="100" min="1" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m4 xl3 center">
                                            <label class="center">Subtotal</label>
                                            <span class="card-title subtitle-2 highlighted center mb-2">$ <b id="subtotal_producto_add"></b></span>
                                            <button class="mdc-button mdc-button--outlined mb-1" type="button" id="quitar_producto_lista" disabled>
                                                <span class="mdc-button__label">Quitar</span>
                                            </button>
                                            <button class="mdc-button mdc-button--raised mb-1" type="button" id="agregar_producto_lista" disabled>
                                                <span class="mdc-button__label">Agregar</span>
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
                                                <th>Kg</th>
                                                <th>Uds</th>
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
                                    <span class="card-title highlighted center" id="valor_pedido_mv">$ 0</span>
                                    <div class="row mb-0">
                                        <div class="col s8">
                                            <label>Estado</label>
                                            <span class="card-subtitle highlighted" id="estado_pedido_mv">Borrador</span>
                                        </div>
                                        <div class="col s4 right-align">
                                            <label># Items</label>
                                            <span class="card-subtitle highlighted right-align" id="items_pedido_mv">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('dashboard')}}">
                                <span class="mdc-button__label">Salir</span>
                            </a>
                            <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="enviar_pedido_mv" type="submit" disabled>
                                <span class="mdc-button__label mr-1">Cerrar Pedido</span>
                                <i class="fas fa-truck"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="buscar_cliente_modal" class="modal modal-md">
        <div class="modal-content">
            <div class="row mb-0">
                <div class="col s12">
                    <h4 class="title mb-2">Asignar cliente</h4>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s7 m8 l9">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="cliente_buscado">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_cliente_buscado">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_cliente_buscado">Buscar por Teléfono o Nombre</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
                <div class="col s5 m4 l3">
                    <button class="mdc-button mdc-button--raised mdc-button--x-large full-width" id="buscar_cliente" type="button" disabled>
                        <span class="mdc-button__label mr-1">Buscar</span>
                        <i class="fas fa-search send" style="display: none"></i>
                        <i class="fas fa-spinner sending"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 mt-2">
                    <div>
                        <div class="card card--outlined dashed transparent mb-0" id="clientes_vacio" style="display: none;">
                            <div class="card-content center">
                                <h3 class="card-title center mb-3">NO SE ENCONTRARON CLIENTES</h3>
                                <button class="mdc-button mdc-button--raised" type="button" id="lista_clientes_vacia">
                                    <span class="mdc-button__label mr-1">Nuevo cliente</span>
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <table id="lista_clientes">
                            <thead>
                                <tr>
                                    <th class="{{ $usuario->nivel != 'u_callcenter' ? 'hide' : '' }}">Cédula</th>
                                    <th>Teléfono</th>
                                    <th>Nombre</th>
                                    <th class="{{ $usuario->nivel != 'u_ventadirecta' ? 'hide-on-small-only' : '' }}">Dirección</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="cargando">
                            <div id="html-spinner"></div>
                            <span class="title">cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3 mb-0">
                <div class="col s12 right-align">
                    <button class="mdc-button mdc-button--outlined mdc-button--large modal-close" type="button">
                        <span class="mdc-button__label">Salir</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="nuevo_cliente_modal" class="modal">
        <div class="modal-content">
            <div class="row mb-0 div-nuevo-cliente">
                <div class="col s12">
                    <h4 class="title">Nuevo cliente</h4>
                    <p class="my-0">Ingrese los datos del cliente que desea añadir. El cliente se asignará al pedido automáticamente.</p>
                </div>
            </div>
            <div class="row mb-0 div-editar-cliente" style="display: none;">
                <div class="col s12">
                    <h4 class="title">Editar cliente</h4>
                    <p class="my-0">Cambie los datos que considere necesarios. El cliente se asignará al pedido automáticamente.</p>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 m6 mt-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="nombres">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_nombres" name="nombres" minlength="3">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_nombres">Nombres</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
                <div class="col s12 m6 mt-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="apellidos">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_apellidos" name="apellidos" minlength="3">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_apellidos">Apellidos</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
                <div class="col s12 m4 mt-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="cedula">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_cedula" name="cedula" minlength="7">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_cedula">Cédula</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
                <div class="col s12 m4 mt-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="telefono">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_telefono" name="telefono" minlength="7">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_telefono">Teléfono</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
                <div class="col s12 m4 mt-2">
                    <div class="mdc-select mdc-select--outlined mdc-select--dense" id="mdc-select__id_ciudad">
                        <div class="mdc-select__anchor" aria-labelledby="outlined-select-label">
                            <span id="id_ciudad__selected-text" class="mdc-select__selected-text"></span>
                            <span class="mdc-select__dropdown-icon">
                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                </svg>
                            </span>
                            <span class="mdc-notched-outline">
                                <span class="mdc-notched-outline__leading"></span>
                                <span class="mdc-notched-outline__notch">
                                    <span id="outlined-select-label" class="mdc-floating-label">Ciudad</span>
                                </span>
                                <span class="mdc-notched-outline__trailing"></span>
                            </span>
                        </div>
                        <!-- Other elements from the select remain. -->
                        <div class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox" id="lista_ciudades">
                            <ul class="mdc-list">
                                @foreach ($ciudades as $ciudad)
                                    <li class="mdc-list-item" data-value="{{ $ciudad->id_ciudad }}" role="option">
                                        <span class="mdc-list-item__text">{{ mb_convert_case(mb_strtolower($ciudad->ciudad), MB_CASE_TITLE, "UTF-8") }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col s12 mt-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="direccion">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_direccion" name="direccion" minlength="5">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_direccion">Dirección</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
                <div class="col s12 mt-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="barrio">
                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_barrio" name="barrio" minlength="3">
                        <span class="mdc-notched-outline">
                            <span class="mdc-notched-outline__leading"></span>
                            <span class="mdc-notched-outline__notch">
                                <span class="mdc-floating-label" id="lbl_barrio">Barrio</span>
                            </span>
                            <span class="mdc-notched-outline__trailing"></span>
                        </span>
                    </label>
                </div>
            </div>
            <div class="row mt-3 mb-0">
                <div class="col s12 right-align div-nuevo-cliente">
                    <button class="mdc-button mdc-button--outlined mdc-button--large modal-close" id="salir_crear_cliente" type="button">
                        <span class="mdc-button__label">Salir</span>
                    </button>
                    <button class="mdc-button mdc-button--raised mdc-button--large guardar_cliente" id="crear_cliente" type="button">
                        <span class="mdc-button__label mr-1">Crear Cliente</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
                <div class="col s12 right-align div-editar-cliente" style="display: none;">
                    <button class="mdc-button mdc-button--outlined mdc-button--large modal-close" id="salir_actualizar_cliente" type="button">
                        <span class="mdc-button__label">Salir</span>
                    </button>
                    <button class="mdc-button mdc-button--raised mdc-button--large guardar_cliente" id="actualizar_cliente" type="button">
                        <span class="mdc-button__label mr-1">Actualizar</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="carga-creando-pedido" class="cargando" style="display: none;">
        <div id="html-spinner"></div>
        <span class="title mt-1">Creando Pedido...</span>
    </div>
@endsection

@section('scripts')
    @if ($usuario->cliente)
        <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Variables que guardan la información de la vista
                var cliente = [];
                var productosListado = [];
                var productosPedido = [];
                var productoPorAgregar = [];
                var pedido = null;
                var listaClientes = [];
                var ciudades = @json($ciudades);

                // Rutas de ajax
                var urlBuscarCliente = '{!! route('ajax.pedidos.clientes.buscar', ['busqueda' => null]) !!}';
                var urlGuardarCliente = '{!! route('ajax.clientesvd.guardar') !!}';
                var urlCrearPedido = '{!! route('ajax.pedidos.crear') !!}';
                var urlCerrarPedido = '{!! route('pedidos.update', ['id' => 'null']) !!}';
                var urlVerPedido = '{!! route('pedidos.show', ['id' => 'null']) !!}';
                var urlBuscar = '{!! route('ajax.pedidos.productos.buscar', ['busqueda' => 'null']) !!}';
                var urlGuardarProducto = '{!! route('ajax.pedidos.gurdarProducto') !!}';
                var urlEliminarProducto = '{!! route('ajax.pedidos.eliminarProducto') !!}';
                var urlRegLlamada = '{!! route('rutero.regLlamada', ['cliente' => 'idCliente', 'clienteVd' => 'idClienteVd']) !!}';

                $('#pedidos-create').addClass('mdc-list-item--active');

                // Inicialización de elementos de Material.io
                const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                    return new mdc.textField.MDCTextField(el);
                });
                const selects = [].map.call(document.querySelectorAll('.mdc-select'), function(el) {
                    return new mdc.select.MDCSelect(el);
                });
                const selectCop = new mdc.select.MDCSelect(document.querySelector('#mdc-select__cop'));
                const selectCiudad = new mdc.select.MDCSelect(document.querySelector('#mdc-select__id_ciudad'));
                const selectUnmed = new mdc.select.MDCSelect(document.querySelector('#unmed_producto_add'));
                const fechaEntrega = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_entrega'));

                // Inicializa elementos de materialize
                $('#buscar_cliente_modal').modal({
                    dismissible: false,
                    onOpenEnd: function(modal, trigger) {
                        buscarClientesVd();
                    },
                    onCloseEnd: function() {
                        $('#buscar_cliente').attr('disabled', 'disabled');
                        $('#buscar_cliente .send').hide();
                        $('#buscar_cliente .sending').show();
                        $('#buscar_cliente_modal .cargando').show();
                    }
                });

                $('#nuevo_cliente_modal').modal({
                    dismissible: false,
                    onOpenStart: function(modal, trigger) {
                        selectCiudad.value = null;
                        selectCiudad.valid = true;
                        $('#nombres input').val('').attr('required', 'required');
                        $('#apellidos input').val('').attr('required', 'required');
                        $('#telefono input').val('').attr('required', 'required');
                        $('#direccion input').val('').attr('required', 'required');
                        $('#barrio input').val('').attr('required', 'required');
                        $('#cedula input').val('');
                        $('#mdc-select__id_ciudad').addClass('mdc-select--required');
                        $('#mdc-select__id_ciudad .mdc-select__anchor').attr('aria-required', 'true');
                        $('#mdc-select__id_ciudad .mdc-floating-label').addClass('mdc-floating-label--required');
                        $('#nuevo_cliente_modal .mdc-text-field').removeClass('mdc-text-field--label-floating');
                        $('#nuevo_cliente_modal .mdc-text-field .mdc-notched-outline').removeClass('mdc-notched-outline--notched');
                        $('#nuevo_cliente_modal .mdc-text-field .mdc-floating-label').removeClass('mdc-floating-label--float-above');
                    },
                    onCloseEnd: function() {
                        //
                    }
                });

                // Funciones iniciales
                fechaMinima();
                datatableProductos();

                @if ($usuario->nivel == 'u_ventadirecta')
                    var centroDistribucionCliente = @json($usuario->centroDist->cop);

                    // Cargar COP por defecto
                    selectCop.value = centroDistribucionCliente;
                    $('#cop').val(selectCop.value)
                @endif

                // Detectar el cambio de centro de operaciones
                selectCop.listen('MDCSelect:change', (el) => {
                    if (selectCop.value) {
                        $('#cop').val(selectCop.value);
                        activarProductos();
                    }
                });

                // Detectar cuando se cambia la fecha de entrega
                $('#fecha_entrega').on('change', function(){
                    activarProductos();
                });

                // Buscar cliente por nombre o por teléfono al dar click en botón de buscar
                $('#buscar_cliente').on('click', function(){
                    var clienteBuscado = $('#cliente_buscado input').val();
                    if (clienteBuscado) {
                        buscarClientesVd(clienteBuscado);
                    }
                });

                // Buscar cliente por nombre o por teléfono al dar enter en el input
                $("#cliente_buscado input").on('keyup', function (e) {
                    var clienteBuscado = $('#cliente_buscado input').val();
                    if ((e.key === 'Enter' || e.keyCode === 13) && clienteBuscado) {
                        buscarClientesVd(clienteBuscado);
                    }
                });

                // Asignar al cliente seleccionado como cliente del pedido
                $('#lista_clientes').on('click', 'tr.clickable', function(){
                    let index = $(this).data('index');
                    cliente = listaClientes[index];
                    // console.log(cliente);
                    $('#nombre_clientevd').text(cliente.nombres +' '+ cliente.apellidos);
                    if (cliente.cedula) {
                        $('#cedula_clientevd').text(cliente.cedula);
                        $('#div-cedula_clientevd').show();
                        $('#div-telefono_clientevd').removeClass('s12').addClass('s6');
                    } else {
                        $('#cedula_clientevd').text('');
                        $('#div-cedula_clientevd').hide();
                        $('#div-telefono_clientevd').removeClass('s6').addClass('s12');
                    }
                    $('#telefono_clientevd').text(cliente.telefono);
                    let telefonocliente = 'tel:+57' + cliente.telefono;
                    $('#href-telefono_clientevd').attr('href', telefonocliente);
                    if (cliente.correo_electronico) {
                        $('#correo_electronico_clientevd').text(cliente.correo_electronico.toLowerCase());
                        $('#div-correo_electronico_clientevd').show();
                    } else {
                        $('#correo_electronico_clientevd').text('');
                        $('#div-correo_electronico_clientevd').hide();
                    }
                    $('#direccion_clientevd').text(cliente.direccion);
                    $('#barrio_clientevd').text(cliente.barrio);
                    if (cliente.ciudad.ciudad) {
                        $('#ciudad_clientevd').text(cliente.ciudad.ciudad.toLowerCase());
                    } else {
                        $('#ciudad_clientevd').text(cliente.ciudad.toLowerCase());
                    }
                    $('#id_cliente_vd').val(cliente.id_cliente_vd);
                    $('#tipo_cliente').val(cliente.tipo_cliente);
                    if(cliente.tipo_cliente == 2){
                        $('#editar_cliente').show();
                    }else{
                        $('#editar_cliente').hide();
                    }
                    $('#data_clientevd').show();
                    $('#no_clientevd').hide();
                    $('#buscar_cliente_modal').modal('close');
                    activarProductos();
                });

                // Asignar como cliente al último llamado
                @isset ($clienteVd)
                    @if ($clienteVd == '')

                    cliente.nombres = "{{ $cliente->nombre_cliente }}";
                    cliente.apellidos = "";
                    cliente.cedula = "{{ $cliente->cc_nit }}";
                    cliente.telefono = "{{ $cliente->telefono }}";
                    cliente.correo_electronico = "{{ $cliente->correo }}";
                    cliente.direccion = "{{ $cliente->direccion }}";
                    cliente.ciudadid = "{{ $cliente->ciudad }}";
                    cliente.ciudad = "{{ $cliente->ciudadCl->ciudad }}";
                    cliente.id_cliente_vd = "{{ $cliente->id_cliente }}";
                    cliente.tipo_cliente = 1;

                    @else

                    cliente.nombres = "{{ $clienteVd->nombres }}";
                    cliente.apellidos = "{{ $clienteVd->apellidos }}";
                    cliente.cedula = "{{ $clienteVd->cedula }}";
                    cliente.telefono = "{{ $clienteVd->telefono }}";
                    cliente.correo_electronico = "{{ $clienteVd->correo_electronico }}";
                    cliente.direccion = "{{ $clienteVd->direccion }}";
                    cliente.ciudadid = "{{ $clienteVd->id_ciudad }}";
                    cliente.ciudad = "{{ $clienteVd->ciudad }}";
                    cliente.id_cliente_vd = "{{ $clienteVd->id_cliente_vd }}";
                    cliente.tipo_cliente = 2;
                    activarProductos();

                    @endif

                    $('#nombre_clientevd').text(cliente.nombres + ' ' + cliente.apellidos);

                    if (cliente.cedula) {
                        $('#cedula_clientevd').text(cliente.cedula);
                        $('#div-cedula_clientevd').show();
                        $('#div-telefono_clientevd').removeClass('s12').addClass('s6');
                    } else {
                        $('#cedula_clientevd').text('');
                        $('#div-cedula_clientevd').hide();
                        $('#div-telefono_clientevd').removeClass('s6').addClass('s12');
                    }
                    $('#telefono_clientevd').text(cliente.telefono);
                    let telefonocliente = 'tel:+57' + cliente.telefono;
                    // $('#telefono_clientevd').attr('href', telefonocliente);
                    if (cliente.correo_electronico) {
                        $('#correo_electronico_clientevd').text(cliente.correo_electronico.toLowerCase());
                        $('#div-correo_electronico_clientevd').show();
                    } else {
                        $('#correo_electronico_clientevd').text('');
                        $('#div-correo_electronico_clientevd').hide();
                    }
                    $('#direccion_clientevd').text(cliente.direccion);
                    $('#barrio_clientevd').text(cliente.barrio);

                    if (cliente.ciudad) {
                        $('#ciudad_clientevd').text(cliente.ciudad.toLowerCase());
                    } else {
                        $('#ciudad_clientevd').text(cliente.ciudadid.toLowerCase());
                    }
                    $('#id_cliente_vd').val(cliente.id_cliente_vd);
                    $('#tipo_cliente').val(cliente.tipo_cliente);

                    if(cliente.tipo_cliente == 2){
                        $('#editar_cliente').show();
                    }else{
                        $('#editar_cliente').hide();
                    }

                    $('#data_clientevd').show();
                    $('#no_clientevd').hide();
                    $('#buscar_cliente_modal').modal('close');
                    activarProductos();
                @endisset

                $('#lista_clientes_vacia').click(function(){
                    $('.div-nuevo-cliente').show();
                    $('.div-editar-cliente').hide();
                    $('#buscar_cliente_modal').modal('close');
                    $('#nuevo_cliente_modal').modal('open');
                });

                // Validar el campo de teléfono en la modal de nuevo cliente
                $('#telefono input').blur(function(){
                    let regex = /(\d+)/g;
                    let newValue = $(this).val().match(regex);
                    $(this).val(newValue.join(''));
                });

                // Guardar datos del cliente de venta directa
                $('#crear_cliente').click(function(e){
                    e.preventDefault();
                    guardarCliente(false);
                });

                // Actualizar datos del cliente de venta directa
                $('#actualizar_cliente').click(function(e){
                    e.preventDefault();
                    guardarCliente(true);
                });

                function guardarCliente(edicion) {
                    if ($('#nombres input').val() && $('#apellidos input').val() && $('#telefono input').val() && $('#direccion input').val() && $('#barrio input').val() && selectCiudad.value) {
                        if (!$('#nombres').hasClass('mdc-text-field--invalid') && !$('#apellidos').hasClass('mdc-text-field--invalid') && !$('#telefono').hasClass('mdc-text-field--invalid') && !$('#direccion').hasClass('mdc-text-field--invalid') && !$('#barrio').hasClass('mdc-text-field--invalid')) {
                            let regex = /^(300|301|302|303|304|305|310|311|312|313|314|315|316|317|318|319|320|321|322|323|350|351)[\d]{7}$/;
                            if ($('#telefono input').val().length == 7) {
                                regex = /^[1-9]\d{6}$/;
                            }
                            if (regex.test($('#telefono input').val())) {
                                $('#salir_crear_cliente').attr('disabled', 'disabled');
                                let id_cliente_vd = null;
                                if (edicion) {
                                    id_cliente_vd = cliente.id_cliente_vd;
                                }
                                $.ajax({
                                    method: 'POST',
                                    url: urlGuardarCliente,
                                    context: document.body,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        id_cliente_vd: id_cliente_vd,
                                        nombres: $('#nombres input').val(),
                                        apellidos: $('#apellidos input').val(),
                                        cedula: $('#cedula input').val(),
                                        telefono: $('#telefono input').val(),
                                        direccion: $('#direccion input').val(),
                                        barrio: $('#barrio input').val(),
                                        id_ciudad: selectCiudad.value
                                    }
                                }).done(function(response) {
                                    cliente = [];
                                    if (response.cliente) {
                                        cliente = response.cliente;
                                        if (cliente.cedula) {
                                            $('#cedula_clientevd').text(numeroMiles(cliente.cedula));
                                            $('#div-cedula_clientevd').show();
                                            $('#div-telefono_clientevd').removeClass('s12').addClass('s6');
                                        } else {
                                            $('#cedula_clientevd').text('');
                                            $('#div-cedula_clientevd').hide();
                                            $('#div-telefono_clientevd').removeClass('s6').addClass('s12');
                                        }
                                        $('#nombre_clientevd').text(cliente.nombres +' '+ cliente.apellidos);
                                        $('#telefono_clientevd').text(cliente.telefono);
                                        let telefonocliente = 'tel:+57' + cliente.telefono;
                                        // $('#telefono_clientevd').attr('href', telefonocliente);
                                        if (cliente.correo_electronico) {
                                            $('#correo_electronico_clientevd').text(cliente.correo_electronico.toLowerCase());
                                            $('#div-correo_electronico_clientevd').show();
                                        } else {
                                            $('#correo_electronico_clientevd').text('');
                                            $('#div-correo_electronico_clientevd').hide();
                                        }
                                        $('#direccion_clientevd').text(cliente.direccion);
                                        $('#barrio_clientevd').text(cliente.barrio);
                                        $('#ciudad_clientevd').text(response.ciudad);
                                        $('#id_cliente_vd').val(cliente.id_cliente_vd);
                                        $('#tipo_cliente').val('2');
                                        $('#data_clientevd').show();
                                        $('#no_clientevd').hide();
                                        $('#nuevo_cliente_modal').modal('close');
                                    }
                                    activarProductos();
                                }).fail(function(error) {
                                    console.log(error);
                                    $('#salir_crear_cliente').removeAttr('disabled');
                                });
                            } else {
                                $('#salir_crear_cliente').removeAttr('disabled');
                                $('#telefono').addClass('mdc-text-field--invalid');
                            }
                        } else {
                            $('#salir_crear_cliente').removeAttr('disabled');
                        }
                    } else {
                        $('#salir_crear_cliente').removeAttr('disabled');
                    }
                }

                // Desplegar la modal de editar cliente con los datos del cliente del pedido
                $('#editar_cliente').click(function(){
                    $('.div-nuevo-cliente').hide();
                    $('.div-editar-cliente').show();
                    $('#nuevo_cliente_modal').modal('open');

                    $('#nombres input').val(cliente.nombres);
                    $('#apellidos input').val(cliente.apellidos);
                    $('#cedula input').val(cliente.cedula);
                    $('#telefono input').val(cliente.telefono);
                    $('#direccion input').val(cliente.direccion);
                    $('#barrio input').val(cliente.barrio);
                    selectCiudad.value = cliente.id_ciudad;
                    selectCiudad.selectedIndex = ciudades.map(e => e.id_ciudad).indexOf(cliente.id_ciudad);
                    $('#nuevo_cliente_modal .mdc-text-field').addClass('mdc-text-field--label-floating');
                    $('#nuevo_cliente_modal .mdc-text-field .mdc-notched-outline').addClass('mdc-notched-outline--notched');
                    $('#nuevo_cliente_modal .mdc-text-field .mdc-floating-label').addClass('mdc-floating-label--float-above');
                    if (!cliente.cedula) {
                        $('#cedula').removeClass('mdc-text-field--label-floating');
                        $('#cedula .mdc-notched-outline').removeClass('mdc-notched-outline--notched');
                        $('#cedula .mdc-floating-label').removeClass('mdc-floating-label--float-above');
                    }
                    if (!cliente.barrio) {
                        $('#barrio').removeClass('mdc-text-field--label-floating');
                        $('#barrio .mdc-notched-outline').removeClass('mdc-notched-outline--notched');
                        $('#barrio .mdc-floating-label').removeClass('mdc-floating-label--float-above');
                    }
                });

                $('#main-form').on('keyup keypress', function(e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) {
                        e.preventDefault();
                    return false;
                    }
                });

                // Buscar productos por nombre y código
                $('#buscar_producto input').keyup(function(e){
                    var key = e.keyCode || e.charCode;
                    if ((key >= 48 && key <= 57) || (key >= 65 && key <= 90) || key == 8 || key == 46 || (e.keyCode >= 96 && e.keyCode <= 105)) {
                        var nombreProducto = $(this).val().toUpperCase();
                        if(nombreProducto.length > 2){
                            buscarProductos(nombreProducto);
                        } else {
                            $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                        }
                    } else if (key === 13) {
                        e.preventDefault();
                        $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                        $('#list_product_item-0').trigger('click');
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
                $('#mdc-menu__buscar_producto').on('click tap touchstart', '.mdc-list-item', function(){
                    let index = $(this).data('index');
                    productoPorAgregar = productosListado[index];
                    productoPorAgregar.unidades = 1;
                    productoPorAgregar.peso = 1;
                    if(productoPorAgregar) {
                        $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                        $('#mdc-menu__buscar_producto').empty();
                        $('#buscar_producto input').val('');

                        $('#codigo_producto_add').text(productoPorAgregar.codigo);
                        $('#nombre_producto_add').text(productoPorAgregar.nombre);
                        $('#valor_kg_add').text(numeroMiles(productoPorAgregar.precio_unidad_inventario));
                        $('#valor_un_add').text(numeroMiles(productoPorAgregar.precio_unidad_empaque));
                        if(productoPorAgregar.precio_unidad_empaque > 500 && productoPorAgregar.precio_unidad_inventario > 500) {
                            selectUnmed.value = productoPorAgregar.undmed.replace(' ', '');
                            $('#unmed_producto_add_kg').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                            $('#unmed_producto_add_un').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                            $('#unmed_txt_producto_add').text(productoPorAgregar.undmed.toLowerCase());
                            $('#cant_un_producto_add input').val(1);
                            if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                                $('#cant_kg_producto_add input').val(1).removeAttr('readonly');
                                $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_inventario));
                            } else {
                                $('#cant_kg_producto_add input').val(productoPorAgregar.peso_unidad).attr('readonly', 'readonly');
                                $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_empaque));
                            }
                        } else if (productoPorAgregar.precio_unidad_inventario > 500) {
                            selectUnmed.value = 'KG';
                            productoPorAgregar.undmed = 'KG';
                            productoPorAgregar.peso = 1;
                            $('#unmed_producto_add_kg').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                            $('#unmed_producto_add_un').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                            $('#cant_kg_producto_add input').val(1).removeAttr('readonly');
                            $('#cant_un_producto_add input').val(1);
                            $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_inventario));
                        } else {
                            selectUnmed.value = 'UN';
                            productoPorAgregar.undmed = 'UN';
                            productoPorAgregar.peso = productoPorAgregar.peso_unidad;
                            $('#unmed_producto_add_un').removeClass('mdc-list-item--disabled').removeAttr('aria-disabled');
                            $('#unmed_producto_add_kg').addClass('mdc-list-item--disabled').attr('aria-disabled', true);
                            $('#cant_kg_producto_add input').val(productoPorAgregar.peso_unidad);
                            $('#cant_kg_producto_add input').attr('readonly', 'readonly');
                            $('#cant_un_producto_add input').val(1);
                            $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.precio_unidad_empaque));
                        }

                        $('#alerta_producto_por_agregar').hide();
                        $('#cant_kg_producto_add').removeClass('mdc-text-field--disabled');
                        $('#cant_kg_producto_add input').removeAttr('disabled');
                        $('#cant_un_producto_add').removeClass('mdc-text-field--disabled');
                        $('#cant_un_producto_add input').removeAttr('disabled');
                        $('#quitar_producto_lista').removeAttr('disabled');
                        $('#agregar_producto_lista').removeAttr('disabled');
                        selectUnmed.disabled = false;
                    }
                });

                // Recalcular el subtotal del producto al cambiar el peso
                $('#cant_kg_producto_add input').change(function(){
                    if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                        productoPorAgregar.peso = $('#cant_kg_producto_add input').val();
                        productoPorAgregar.undmed = 'KG';
                        productoPorAgregar.subtotal = Math.ceil(productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario);
                        $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.subtotal));
                    }
                });

                // Recalcula el subtotal y el peso del producto al cambiar las unidades
                $('#cant_un_producto_add input').change(function(){
                    productoPorAgregar.unidades = $('#cant_un_producto_add input').val();
                    if (selectUnmed.value == 'UN' || selectUnmed.value == 'UN ') {
                        productoPorAgregar.undmed = 'UN';
                        productoPorAgregar.peso = parseFloat((productoPorAgregar.unidades * productoPorAgregar.peso_unidad).toFixed(2));
                        productoPorAgregar.subtotal = Math.ceil(productoPorAgregar.unidades * productoPorAgregar.precio_unidad_empaque);
                        $('#cant_kg_producto_add input').val(productoPorAgregar.peso);
                        $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.subtotal));
                    }
                });

                // Recalcular el subtotal del producto al cambiar la unidad de medida
                selectUnmed.listen('MDCSelect:change', (el) => {
                    if (selectUnmed.value) {
                        productoPorAgregar.undmed = selectUnmed.value.replace(' ','');
                        if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                            productoPorAgregar.peso = $('#cant_kg_producto_add input').val();
                            productoPorAgregar.subtotal = Math.ceil(productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario);
                            $('#cant_kg_producto_add input').removeAttr('readonly');
                        } else {
                            productoPorAgregar.peso = parseFloat((productoPorAgregar.unidades * productoPorAgregar.peso_unidad).toFixed(2));
                            productoPorAgregar.subtotal = Math.ceil(productoPorAgregar.unidades * productoPorAgregar.precio_unidad_empaque);
                            $('#cant_kg_producto_add input').val(productoPorAgregar.peso).attr('readonly', 'readonly');
                        }
                        $('#subtotal_producto_add').text(numeroMiles(productoPorAgregar.subtotal));
                    }
                });

                // Añadir el prodcuto que está en transición al listado de productos del pedido
                $('#agregar_producto_lista').click(function(){
                    if (productoPorAgregar && pedido) {
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
                                total: function() {
                                    if (selectUnmed.value == 'KG' || selectUnmed.value == 'KG ') {
                                        return Math.ceil(productoPorAgregar.peso * productoPorAgregar.precio_unidad_inventario);
                                    } else {
                                        return Math.ceil(productoPorAgregar.unidades * productoPorAgregar.precio_unidad_empaque);
                                    }
                                }
                            }
                        }).done(function(response){
                            productosPedido = response.productos;
                            actualizarTotales();
                            datatableProductos();
                        }).fail(function(error){
                            console.log(error);
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
                    if (id_producto && pedido) {
                        $.ajax({
                            method: 'DELETE',
                            url: urlEliminarProducto,
                            context: document.body,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id_comercial: pedido.id_comercial,
                                id_producto: id_producto
                            }
                        }).done(function(response){
                            productosPedido = response.productos;
                            actualizarTotales();
                            datatableProductos();
                        }).fail(function(error){
                            console.log(error);
                        });
                    }
                });

                // Enviar el pedido y cerrarlo
                $('.enviar_pedido').click(function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Cerrar Pedido?',
                        text: "Una vez cerrado el pedido no se podrá modificar ni cancelar.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Si, cerrar pedido!',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#estado').val(1);
                            $('form').submit();
                        }
                    });
                });

                // Asigna la fecha de entrega mínima para el siguiente día
                @if($usuario->nivel == 'u_callcenter' || ($usuario->nivel == 'u_ventadirecta' && $usuario->ciudad == 'BARRANCABERMEJA'))
                    function fechaMinima() {
                        let hoy = new Date();
                        let limite =  new Date().setHours(12,1,0,0);
                        let fechaMinima = new Date();
                        @if($usuario->nivel != 'u_callcenter')
                        if (hoy.getTime() > limite) {
                            fechaMinima = addDays(fechaMinima, 1);
                        }
                        @endif
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
                @elseif ($usuario->nivel == 'u_ventadirecta')
                    function fechaMinima() {
                        let hoy = new Date();
                        let limite =  new Date().setHours(15,1,0,0);
                        let fechaMinima = new Date('2022-12-01');
                        $('#fecha_entrega').attr('min', '2022-12-01');
                    }
                @else
                    function fechaMinima() {
                        let hoy = new Date();
                        let limite =  new Date().setHours(15,1,0,0);
                        let fechaMinima = new Date();
                        if (hoy.getTime() > limite) {
                            fechaMinima = addDays(fechaMinima, 2);
                        } else {
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
                @endif

                function validarDatosEscenciales() {
                    let cop = $('#cop').val();
                    let clientevd = $('#id_cliente_vd').val();
                    if(cop && fechaEntrega.value && fechaEntrega.valid && clientevd) {
                        $('#buscar_producto').removeClass('mdc-text-field--disabled');
                        $('#buscar_producto input').removeAttr('disabled');
                        $('.enviar_pedido').removeAttr('disabled');
                        return true;
                    } else {
                        $('#buscar_producto').addClass('mdc-text-field--disabled');
                        $('#buscar_producto input').attr('disabled', 'disabled');
                        $('.enviar_pedido').attr('disabled', 'disabled');
                        return false;
                    }
                }

                // Activar la búsqueda de productos y crear el pedido
                function activarProductos() {
                    let datosEscenciales = validarDatosEscenciales();
                    if (!pedido && datosEscenciales) {
                        $('#carga-creando-pedido').show();

                        // var data = {
                        //         cop: selectCop.value,
                        //         fecha_entrega: $('#fecha_entrega').val(),
                        //         observacion_pedido: $('#observacion_pedido').val(),
                        //         id_cliente_vd: $('#id_cliente_vd').val(),
                        //         tipo_cliente: $('#tipo_cliente').val()
                        //     };
                        // console.log(data); return;
                        $.ajax({
                            method: 'POST',
                            url: urlCrearPedido,
                            context: document.body,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                cop: selectCop.value,
                                fecha_entrega: $('#fecha_entrega').val(),
                                observacion_pedido: $('#observacion_pedido').val(),
                                id_cliente_vd: $('#id_cliente_vd').val(),
                                tipo_cliente: $('#tipo_cliente').val()
                            }
                        }).done(function(response){
                            pedido = response.pedido;
                            urlCerrarPedido = urlCerrarPedido.replace('null', pedido.id_comercial);
                            urlVerPedido = urlVerPedido.replace('null', pedido.id_comercial);
                            // console.log(urlVerPedido); return;
                            window.location.href = urlVerPedido;
                            $('#main-form').attr('action', urlCerrarPedido);
                            $('#id_comercial').val(pedido.id_comercial);
                            $('#buscar_producto').removeClass('mdc-text-field--disabled');
                            $('#buscar_producto input').removeAttr('disabled');
                            $('h1.title').text('Pedido N° ' + pedido.id_comercial);
                            $('.current-breadcrumb').text('# ' + pedido.id_comercial);
                            $('#estado_pedido').text('Abierto');
                            $('#carga-creando-pedido').hide();
                        }).fail(function(error){
                            console.log(error);
                        });
                    }
                }

                // Buscar productos por nombre o código
                function buscarProductos(busqueda) {
                    var urlBuscar2 = urlBuscar.replace('null', busqueda);
                    $('#mdc-menu__buscar_producto').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_producto').empty();
                    $('#mdc-menu__buscar_producto').append('<li class="mdc-list-item" role="option"><span class="mdc-list-item__text">Buscando</span></li>');
                    $.ajax({
                        'url': urlBuscar2,
                        'context': document.body
                    }).done(function(response) {
                        $('#mdc-menu__buscar_producto').empty();
                        var productos = response.productos;
                        productosListado = response.productos;
                        if(productos.length) {
                            for (let index = 0; index < productos.length; index++) {
                                const producto = productos[index];
                                $('#mdc-menu__buscar_producto').append('<li tabindex="0" class="mdc-list-item" data-index="'+ index +'" role="option" id="list_product_item-'+ index +'"><span class="mdc-list-item__text">'+ producto.codigo +' - '+ producto.nombre.toLowerCase() +'</span></li>');
                            }
                        } else {
                            $('#mdc-menu__buscar_producto').append('<li class="mdc-list-item mdc-list-item--producto" role="option"><span class="mdc-list-item__text">No hay productos</span></li>');
                        }
                    });
                }

                // Actualizar totales del pedido
                function actualizarTotales() {
                    var totalPedido = 0;
                    var totalItems = 0;
                    for (let index = 0; index < productosPedido.length; index++) {
                        const producto = productosPedido[index];
                        totalItems++;
                        if (producto.pivot.venta_por == 'KG' || producto.pivot.venta_por == 'KG ') {
                            totalPedido += producto.pivot.peso * producto.pivot.valor_kg;
                        } else {
                            totalPedido += producto.pivot.unidades * producto.pivot.valor_un;
                        }
                    }
                    if (totalPedido) {
                        $('.enviar_pedido').removeAttr('disabled');
                    } else {
                        $('.enviar_pedido').attr('disabled', 'disabled');
                    }
                    $('#valor_pedido').text('$ ' + numeroMiles(Math.ceil(totalPedido)));
                    $('#valor_pedido_mv').text('$ ' + numeroMiles(Math.ceil(totalPedido)));
                    $('#items_pedido').text(numeroMiles(totalItems));
                    $('#items_pedido_mv').text(numeroMiles(totalItems));
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
                    $('#productos').DataTable({
                        pageLength: 10,
                        order: [],
                        columnDefs: [
                            { responsivePriority: 1, targets: 1 },
                            { responsivePriority: 2, targets: 7 },
                            { responsivePriority: 3, targets: 0 },
                            { orderable: false, targets: [8] },
                            { searchable: false, targets: [2, 3, 4, 6, 8] },
                            { visible: false, targets: 6 }
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
                    $('#cant_un_producto_add input').val(null);
                    $('#valor_kg_add').text('');
                    $('#valor_un_add').text('');
                    $('#subtotal_producto_add').text('');

                    // Desactivando campos del div de edición
                    $('#alerta_producto_por_agregar').show();
                    $('#cant_kg_producto_add').addClass('mdc-text-field--disabled');
                    $('#cant_kg_producto_add input').attr('disabled', 'disabled');
                    $('#cant_un_producto_add').addClass('mdc-text-field--disabled');
                    $('#cant_un_producto_add input').attr('disabled', 'disabled');
                    $('#unmed_producto_add').addClass('mdc-select--disabled');
                    $('#unmed_producto_add .mdc-select__anchor').attr('aria-disabled', true);
                    $('#quitar_producto_lista').attr('disabled', 'disabled');
                    $('#agregar_producto_lista').attr('disabled', 'disabled');
                }

                function buscarClientesVd(clienteBuscado) {
                    let urlBuscarClienteVd = urlBuscarCliente;
                    if (typeof clienteBuscado !== 'undefined') {
                        urlBuscarClienteVd = urlBuscarClienteVd +'/'+ clienteBuscado;
                    }
                    // console.log(urlBuscarClienteVd);
                    $('#buscar_cliente').attr('disabled', 'disabled');
                    $('#buscar_cliente .send').hide();
                    $('#buscar_cliente .sending').show();
                    $('#buscar_cliente_modal .cargando').show();
                    $.ajax({
                        'url': urlBuscarClienteVd,
                        'context': document.body
                    }).done(function(response) {
                        // console.log(response);
                        $('#buscar_cliente_modal .cargando').hide();
                        $('#lista_clientes tbody').empty();
                        listaClientes = response.clientes;
                        if (listaClientes.length) {
                            $('#lista_clientes').show();
                            $('#clientes_vacio').hide();
                            for (let index = 0; index < listaClientes.length; index++) {
                                const cliente = listaClientes[index];
                                let f1 = '<td class="{{ $usuario->nivel != 'u_callcenter' ? 'hide' : '' }}">'+ cliente.cedula +'</td>';
                                let f2 = '<td>'+ cliente.telefono +'</td>';
                                let f3 = '<td class="capitalize">'+ cliente.nombres.toLowerCase() +' '+ cliente.apellidos.toLowerCase() +'</td>';
                                let f4 = '<td class="capitalize {{ $usuario->nivel != 'u_ventadirecta' ? 'hide-on-small-only' : '' }}">'+ cliente.direccion.toLowerCase() + ' - ' + cliente.barrio.toLowerCase() +' - '+ cliente.ciudad +'</td>';
                                $('#lista_clientes tbody').append('<tr class="dense clickable" data-index="'+ index +'">'+ f1+f2+f3+f4 +'</tr>');
                            }
                        } else {
                            $('#lista_clientes').hide();
                            $('#clientes_vacio').show();
                        }
                        $('#buscar_cliente').removeAttr('disabled');
                        $('#buscar_cliente .send').show();
                        $('#buscar_cliente .sending').hide();
                    });
                }

                function addDays(date, days) {
                    var result = new Date(date);
                    result.setDate(result.getDate() + days);
                    return result;
                }



                $('#telefono_clientevd').on('click', function(e) {
                    // console.log($('#telefono_clientevd').text());
                    // let index = $(this).data('index');
                    guardarLlamadaCliente();
                    // console.log(cliente);
                });

                function guardarLlamadaCliente() {
                    var urlLlamada;

                    if (cliente.tipo_cliente == "1") {
                        urlLlamada = urlRegLlamada.replace('idCliente', cliente.id_cliente_vd).replace('idClienteVd', '0');
                    } else {
                        urlLlamada = urlRegLlamada.replace('idCliente', {{ $usuario->cliente->id_cliente }}).replace('idClienteVd', cliente.id_cliente_vd);
                    }
                    // console.log(urlLlamada);

                    $.ajax({
                        url: urlLlamada
                    })
                    .done( function (response) {
                        console.log(response);
                        $("#href-telefono_clientevd")[0].click();

                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    });
                }

            });
        </script>
    @endif
@endsection

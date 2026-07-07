@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <form action="{{ route('pedidos.semanalescf.close', ['ano' => $pedido->ano, 'semana' => $pedido->semana]) }}" method="POST" id="main-form">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">P. Semanal Carnes Frías N° {{ $pedido->id_pedido }}</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.semanales.index') }}" class="breadcrumb">Pedidos Semanales</a>
                        <a class="breadcrumb">Carnes Frías Semana {{ $pedido->semana }} / {{ $pedido->ano }}</a>
                    </div>
                </div>
                <div class="col s12 m6 right-align hide-on-small-only">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('pedidos.semanales.index')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="enviar_pedido" type="submit" {{ !count($pedido->productos) ? 'disabled' : '' }}>
                        <span class="mdc-button__label mr-1">Cerrar Pedido</span>
                        <i class="fas fa-truck"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 l4 xl3 hide">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-1">Datos del Pedido</span>
                            <div class="row mb-0">
                                <input type="number" class="hide" name="estado" id="estado" value="0">
                                <div class="col s12 mb-2">
                                    <label>Vendedor</label>
                                    <span class="card-title highlighted subtitle-1 capitalize mb-0">{{ $pedido->vendedor->codigo_vendedor .' - '. strToLower($pedido->vendedor->nombres .' '. $pedido->vendedor->apellidos) }}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Año</label>
                                    <span class="card-title subtitle-3 highlighted capitalize mb-0">{{ $pedido->ano }}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Semana</label>
                                    <span class="card-title subtitle-3 highlighted capitalize mb-0">{{ $pedido->semana }}</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Estado</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">Abierto</span>
                                </div>
                                <div class="col s6 mb-2">
                                    <label>Ingreso</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">{{ date('d/m/Y', strtotime($pedido->fecha_ingreso)) }}</span>
                                </div>
                                @if($pedido->id_usuario != $pedido->vendedor->id_usuario)
                                    <div class="col s12 mb-2">
                                        <label>Creador</label>
                                        <span class="card-subtitle subtitle-3 highlighted capitalize">{{ strToLower($pedido->usuario->nombres .' '. $pedido->usuario->apellidos) }}</span>
                                    </div>
                                @endif
                                <div class="col s12">
                                    <label>Planta</label>
                                    <span class="card-subtitle subtitle-3 highlighted capitalize">{{ $pedido->cop .' - '. strtolower($pedido->centroDist->nombre) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="row mb-0 full-row">
                        <div class="col s12 m7">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title mb-3">Buscar Productos</span>
                                    <div class="row mb-0">
                                        <div class="col s12">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="buscar_producto">
                                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_buscar_producto" autocomplete="off">
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
                        <div class="col s12 m5 hide-on-small-only">
                            <div class="card highlighted">
                                <div class="card-content full-height d-flex f-column justify-content-center" style="padding: 19.5px 24px;">
                                    <label class="center">Planta</label>
                                    <span class="card-title highlighted center capitalize nowrap" id="valor_pedido">{{ $pedido->centroDist->cop. ' - ' .str_replace('PEDIDO SEMANAL ', '', str_replace('PLANTA ', '', $pedido->centroDist->nombre)) }}</span>
                                    <div class="row mb-0">
                                        <div class="col s4">
                                            <label>Ingreso</label>
                                            <span class="card-subtitle highlighted" id="items_pedido">{{ date('d/m/Y', strtotime($pedido->fecha_ingreso)) }}</span>
                                        </div>
                                        <div class="col s8 right-align">
                                            <label>Estado</label>
                                            <span class="card-subtitle highlighted right-align" id="estado_pedido">Abierto</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="card highlighted relative">
                                <div class="card-content">
                                    <div class="row mb-0 valign-wrapper-m">
                                        <div class="col s12 m10 border-right">
                                            <div class="row mb-1">
                                                <div class="col s12 m6 l8">
                                                    <label>Código: <span id="codigo_producto_add"></span></label>
                                                    <span class="card-subtitle subtitle-3 highlighted capitalize" id="nombre_producto_add">&nbsp;</span>
                                                </div>
                                                <div class="col s12 m6 l4 px-0 mt-1-s">
                                                    <div class="col s4">
                                                        <label>Factor</label>
                                                        <span class="card-subtitle subtitle-3 highlighted"><span id="factor_add"></span></span>
                                                    </div>
                                                    <div class="col s4">
                                                        <label>UndMed</label>
                                                        <span class="card-subtitle subtitle-3 highlighted"><span id="undmed_add"></span></span>
                                                    </div>
                                                    <div class="col s4">
                                                        <label>Peso</label>
                                                        <span class="card-subtitle subtitle-3 highlighted"><span id="peso_add"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-0 cols-m7">
                                                <div class="col s3 cols mb-1">
                                                    <label>Lunes</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-ulu" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="ulu" name="ulu" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 cols mb-1">
                                                    <label>Martes</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-uma" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="uma" name="uma" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 cols mb-1">
                                                    <label>Miércoles</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-umi" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="umi" name="umi" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 cols mb-1">
                                                    <label>Jueves</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-uju" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="uju" name="uju" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 cols mb-1">
                                                    <label>Viernes</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-uvi" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="uvi" name="uvi" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 cols mb-1">
                                                    <label>Sábado</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-usa" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="usa" name="usa" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col s3 cols mb-1">
                                                    <label>Domingo</label>
                                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled mdc-text-field--pivot" id="mdc-udo" style="display: block;">
                                                        <input class="mdc-text-field__input mdc-text-field__producto" type="number" aria-labelledby="my-label-id" id="udo" name="udo" min="0" max="9999" disabled>
                                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                            <span class="mdc-notched-outline__leading"></span>
                                                            <span class="mdc-notched-outline__trailing"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m2 border-left">
                                            <button class="mdc-button mdc-button--raised full-width mb-1" id="agregar_producto_lista" type="button" disabled>
                                                <span class="mdc-button__label mr-1">Agregar</span>
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                            <button class="mdc-button mdc-button--outlined full-width" id="quitar_producto_lista" type="button" disabled>
                                                <span class="mdc-button__label mr-1">Descartar</span>
                                                <!--i class="fas fa-trash-alt"></i-->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-0 hide">
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
                                        <div class="col s4">mdc-ulu
                                            <label>Kilogramos</label>
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_kg_producto_add" style="max-width: 100px; display: block;">
                                                <input class="mdc-text-field__input cantidad_producto" type="number" step="0.01" aria-labelledby="my-label-id" name="cantidad_producto[]" max="9999" min="0.01" disabled>
                                                <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col s4">
                                            <label>Unidades</label>
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label mdc-text-field--disabled" id="cant_un_producto_add" style="max-width: 100px; display: block;">
                                                <input class="mdc-text-field__input cantidad_producto" type="number" aria-labelledby="my-label-id" name="cantidad_producto[]" max="9999" min="1" disabled>
                                                <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
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
                                                <th>Factor</th>
                                                <th>Lun</th>
                                                <th>Mar</th>
                                                <th>Mie</th>
                                                <th>Jue</th>
                                                <th>Vie</th>
                                                <th>Sab</th>
                                                <th>Dom</th>
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
                            <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('pedidos.semanales.index')}}">
                                <span class="mdc-button__label">Salir</span>
                            </a>
                            <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="enviar_pedido_mv" type="submit" {{ !count($pedido->productos) ? 'disabled' : '' }}>
                                <span class="mdc-button__label mr-1">Cerrar Pedido</span>
                                <i class="fas fa-truck"></i>
                            </button>
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
            // Variables que guardan la información de la vista
            var productosListado = [];
            var productosPedido = @json($pedido->productos);
            var productoPorAgregar = null;
            var pedido = @json($pedido);
            var limite = new Date('{!! $limite !!}');

            // Rutas de ajax
            var urlBuscar = '{!! route('ajax.pedidos.semanalescf.productos', ['busqueda' => 'null']) !!}';
            var urlGuardarProducto = '{!! route('ajax.pedidos.semanalescf.gurdarProducto') !!}';
            var urlEliminarProducto = '{!! route('ajax.pedidos.semanalescf.eliminarProducto') !!}';

            $('#pedidos-semanales').addClass('mdc-list-item--active');

            // Inicialización de elementos de Material.io
            const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                return new mdc.textField.MDCTextField(el);
            });
            const inputBusqueda = new mdc.textField.MDCTextField(document.querySelector('#buscar_producto'));
            const selectUnmed = new mdc.select.MDCSelect(document.querySelector('#unmed_producto_add'));
            
            // Funciones iniciales
            datatableProductos();
            validarCerrarPedido();

            // Buscar productos por nombre y código
            $('#buscar_producto input').keyup(function(e){
                var nombreProducto = $(this).val().toUpperCase();
                var key = e.keyCode || e.charCode;
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    console.log(productoPorAgregar);
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
            $('#mdc-menu__buscar_producto').on('click tap touchstart', '.mdc-list-item', function(){
                let index = $(this).data('index');
                productoPorAgregar = productosListado[index];
                if (productoPorAgregar) {
                    $('#buscar_producto input').val('');
                    $('#buscar_producto').removeClass('mdc-text-field--label-floating');
                    $('#buscar_producto .mdc-notched-outline__notch').removeAttr('style');
                    $('#lbl_buscar_producto').removeClass('mdc-floating-label--float-above');
                    $('#buscar_producto .mdc-notched-outline').removeClass('mdc-notched-outline--notched');
                    $('#nombre_producto_add').text(productoPorAgregar.nombre);
                    $('#codigo_producto_add').text(productoPorAgregar.codigo);
                    $('#factor_add').text(productoPorAgregar.peso_unidad);
                    $('#undmed_add').text(productoPorAgregar.undmed);
                    $('#peso_add').text(productoPorAgregar.peso_unidad);
                    $('#alerta_producto_por_agregar').hide();
                    $('.mdc-text-field--pivot').removeClass('mdc-text-field--disabled');
                    $('.mdc-text-field--pivot input').removeAttr('disabled');
                    $('#quitar_producto_lista').removeAttr('disabled');
                    $('#agregar_producto_lista').removeAttr('disabled');
                    $('#ulu').focus();
                }
            });

            $('#mdc-menu__buscar_producto').on('keyup', '.mdc-list-item', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    console.log($(this));
                    $(this).trigger('click');
                }
            });

            // Añadir el prodcuto que está en transición al listado de productos del pedido
            $('#agregar_producto_lista').click(function(){
                let totalUds = 0;
                $('.mdc-text-field__producto').each(function() {
                    totalUds += Number($(this).val());
                });
                if (productoPorAgregar && pedido && totalUds) {
                    let data = {
                        id_pedido: pedido.id_pedido,
                        codigo: productoPorAgregar.codigo,
                        nombre: productoPorAgregar.nombre,
                        klu: $('#ulu').val() * productoPorAgregar.peso_unidad,
                        ulu: $('#ulu').val() ? $('#ulu').val() : 0,
                        kma: $('#uma').val() * productoPorAgregar.peso_unidad,
                        uma: $('#uma').val() ? $('#uma').val() : 0,
                        kmi: $('#umi').val() * productoPorAgregar.peso_unidad,
                        umi: $('#umi').val() ? $('#umi').val() : 0,
                        kju: $('#uju').val() * productoPorAgregar.peso_unidad,
                        uju: $('#uju').val() ? $('#uju').val() : 0,
                        kvi: $('#uvi').val() * productoPorAgregar.peso_unidad,
                        uvi: $('#uvi').val() ? $('#uvi').val() : 0,
                        ksa: $('#usa').val() * productoPorAgregar.peso_unidad,
                        usa: $('#usa').val() ? $('#usa').val() : 0,
                        kdo: $('#udo').val() * productoPorAgregar.peso_unidad,
                        udo: $('#udo').val() ? $('#udo').val() : 0,
                        peso_unidad: productoPorAgregar.peso_unidad,
                        undmed: productoPorAgregar.undmed,
                        peso: productoPorAgregar.peso_unidad
                    };
                    $.ajax({
                        method: 'POST',
                        url: urlGuardarProducto,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: data
                    }).done(function(response){
                        console.log(response);
                        productosPedido = response.productos;
                        datatableProductos();
                        validarCerrarPedido();
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
                console.log(urlEliminarProducto);
                let codigo = $(this).data('codigo');
                if (codigo && pedido) {
                    $.ajax({
                        method: 'DELETE',
                        url: urlEliminarProducto,
                        context: document.body,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id_pedido: pedido.id_pedido,
                            codigo: codigo
                        }
                    }).done(function(response){
                        console.log(response);
                        productosPedido = response.productos;
                        datatableProductos();
                        validarCerrarPedido();
                    }).fail(function(error){
                        console.log(error);
                    });
                }
            });

            // Enviar el pedido y cerrarlo
            $('.enviar_pedido').click(function(e){
                e.preventDefault();
                let hoy = new Date();
                if (hoy < limite) {
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
                } else {
                    Swal.fire({
                        title: 'Denegado!',
                        text: 'La fecha limite para cerrar el pedido de la semana '+ pedido.semana +' era el '+ limite.toLocaleDateString("es-ES", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })+ ' a medio día',
                        icon: 'error'
                    });
                }
            });
            
            // Valida si el botón de Cerrar Pedido se puede activar o no
            function validarCerrarPedido() {
                if (productosPedido.length) {
                    $('.enviar_pedido').removeAttr('disabled');
                } else {
                    $('.enviar_pedido').attr('disabled', 'disabled');
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
                    destroy: true,
                    data: productosPedido,
                    pageLength: 10,
                    order: [],
                    responsive: true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 1 },
                        { responsivePriority: 2, targets: 0 },
                        { responsivePriority: 3, targets: 2 },
                        { orderable: false, targets: [10] },
                        { searchable: false, targets: [2, 3, 4, 6, 7, 8, 9, 10] }
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
                            title: 'Factor',
                            data: 'pivot.peso_unidad',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Lun',
                            data: 'pivot.ulu',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Mar',
                            data: 'pivot.uma',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Mie',
                            data: 'pivot.umi',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Jue',
                            data: 'pivot.uju',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Vie',
                            data: 'pivot.uvi',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Sab',
                            data: 'pivot.usa',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: 'Dom',
                            data: 'pivot.udo',
                            className: 'center',
                            render: function(data, type, row){
                                return numeroMiles(data);
                            }
                        },
                        {
                            title: '',
                            data: 'codigo',
                            ordering: false,
                            className: 'no-line-height',
                            render: function(data, type, row){
                                let buttonPc = '<button type="button" class="eliminar-producto eliminar-producto-pc btn-icon" data-codigo='+ data +'><i class="fas fa-trash-alt white-text"></i></button>';
                                let buttonMv = '<button class="mdc-button mdc-button--raised mdc-button--dense eliminar-producto eliminar-producto-mv" type="button" data-codigo='+ data +'><span class="mdc-button__label">Quitar</span></button>';
                                return  buttonPc + buttonMv;
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
            }

            // Reiniciar el panel de transición de productos
            function reiniciarEdicion() {
                productoPorAgregar = null;
                // Reiniciando campos del div de edición
                $('#codigo_producto_add').html('&nbsp;');
                $('#nombre_producto_add').html('&nbsp;');
                $('#factor_add').html('&nbsp;');
                $('#undmed_add').html('&nbsp;');
                $('#peso_add').html('&nbsp;');
                $('.mdc-text-field__producto').val(null);

                // Desactivando campos del div de edición
                $('#alerta_producto_por_agregar').show();
            }
        });
    </script>
@endsection
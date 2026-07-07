@extends('layouts.app')

@section('styles')
    <link href="{{ asset('vendor/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <style>
        .dropify-wrapper {
            height: 110px;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('sondeos.create') }}" method="POST" id="form" accept-charset="UTF-8" enctype="multipart/form-data" files="true">
        @csrf
        <input type="hidden" class="hide" name="codigo_producto" id="codigo_producto">
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Nuevo Sondeo de Precios</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('sondeos.index') }}" class="breadcrumb">Sondeos de Precios</a>
                        <a class="breadcrumb">Nuevo</a>
                    </div>
                </div>
                <div class="col m6 right-align hide-on-small-only">
                    <a href="{{ route('sondeos.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large crear_sondeo" type="submit">
                        <span class="mdc-button__label mr-1">Crear Sondeo</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted mt-0">
                        <div class="card-content">
                            <div class="row mb-0">
                                <div class="col s12 m4 mb-1">
                                    <div class="mdc-select mdc-select--outlined mdc-select--dense mdc-select--required focusable" id="mdc-id_canal">
                                        <div class="mdc-select__anchor" aria-required="true" aria-labelledby="id_canal-select-label">
                                            <input type="text" name="id_canal" id="id_canal" class="mdc-select__input-value" value="">
                                            <span id="id_canal__selected-text" class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="id_canal-select-label" class="mdc-floating-label">Canal de Ventas</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                @foreach ($canales as $canal)
                                                    <li class="mdc-list-item" data-value="{{ $canal->id }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ $canal->nombre }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mdc-select-helper-text mdc-select-helper-text--validation-msg nowrap" id="mdc-helper-id_canal" aria-hidden="true"></div>
                                </div>
                                <div class="col s12 m4 mb-1">
                                    <div class="mdc-select mdc-select--outlined mdc-select--dense mdc-select--required focusable" id="mdc-id_marca">
                                        <div class="mdc-select__anchor" aria-required="true" aria-labelledby="id_marca-select-label">
                                            <input type="text" name="id_marca" id="id_marca" class="mdc-select__input-value" value="">
                                            <span id="id_marca__selected-text" class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="id_marca-select-label" class="mdc-floating-label">Marca</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                @foreach ($marcas as $marca)
                                                    <li class="mdc-list-item" data-value="{{ $marca->id }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ $marca->nombre }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mdc-select-helper-text mdc-select-helper-text--validation-msg nowrap" id="mdc-helper-id_marca" aria-hidden="true"></div>
                                </div>
                                <div class="col s12 m4 mb-1">
                                    <div class="mdc-select mdc-select--outlined mdc-select--dense mdc-select--required focusable" id="mdc-lista_precio">
                                        <div class="mdc-select__anchor" aria-required="true" aria-labelledby="lista_precio-select-label">
                                            <input type="text" name="lista_precio" id="lista_precio" class="mdc-select__input-value" value="">
                                            <span id="lista_precio__selected-text" class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="lista_precio-select-label" class="mdc-floating-label">Lista de Precio</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                            <ul class="mdc-list">
                                                @foreach ($listas as $lista)
                                                    <li class="mdc-list-item" data-value="{{ $lista->codigo }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ $lista->codigo. " - " . $lista->lista_precio }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mdc-select-helper-text mdc-select-helper-text--validation-msg nowrap" id="mdc-helper-lista_precio" aria-hidden="true"></div>
                                </div>
                                <div class="col s12 m6 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-producto">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_producto">Producto</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                        <input type="text" class="mdc-text-field__input" data-input="producto" aria-labelledby="lbl_producto" autocomplete="off" required>
                                        <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                        <span id="clear-producto" class="form-clear d-none mdc-icon-clear" style="display: none">
                                            <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-producto" aria-hidden="true"></div>
                                    </div>
                                    <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                        <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_producto">
                                            <ul class="mdc-list">
                                                <!-- Items que coincidan con la búsqueda -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m3 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-precio_empaque_avicampo">
                                        <span class="mdc-text-field__affix mdc-text-field__affix--prefix">$ </span>
                                        <input class="mdc-text-field__input" type="number" aria-labelledby="lbl_precio_empaque_avicampo" id="precio_empaque_avicampo" name="precio_empaque_avicampo" value="0" readonly>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_precio_empaque_avicampo">Precio Empaque Avicampo</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-precio-empaque-avicampo" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s12 m3 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-precio_inventario_avicampo">
                                        <span class="mdc-text-field__affix mdc-text-field__affix--prefix">$ </span>
                                        <input class="mdc-text-field__input" type="number" aria-labelledby="lbl_precio_inventario_avicampo" id="precio_inventario_avicampo" name="precio_inventario_avicampo" value="0" readonly>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_precio_inventario_avicampo">Precio Inventario Avicampo</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-precio-inventario-avicampo" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-precio">
                                        <span class="mdc-text-field__affix mdc-text-field__affix--prefix">$ </span>
                                        <input class="mdc-text-field__input" type="number" step="1" aria-labelledby="lbl_precio" id="precio" name="precio" min="1" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_precio">Precio</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-precio" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-precio_gramo">
                                        <span class="mdc-text-field__affix mdc-text-field__affix--prefix">$ </span>
                                        <input class="mdc-text-field__input" type="number" step="0.01" aria-labelledby="lbl_precio_gramo" id="precio_gramo" name="precio_gramo" min="1" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_precio_gramo">Precio x Gramo</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-precio_gramo" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s12 m6 mb-1-s">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--textarea-dense" id="mdc-observaciones">
                                        <span class="mdc-text-field__resizer">
                                            <textarea class="mdc-text-field__input" rows="4" cols="40" maxlength="300" aria-label="Label" name="observaciones"></textarea>
                                        </span>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_observaciones">Observaciones</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-observaciones" aria-hidden="true"></div>
                                        <div class="mdc-text-field-character-counter">0 / 300</div>
                                    </div>
                                </div>
                                <div class="col s12 m6 col-dropify mt-0">
                                    <label class="dropify-label">Imágen</label>
                                    <input type="file" class="dropify" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.webp" data-allowed-file-extensions="jpg jpeg png webp"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('sondeos.index')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large crear_sondeo" type="submit">
                        <span class="mdc-button__label mr-1">Crear Sondeo</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="cargando noselect px-5 center" id="guardando" style="display: none">
        <div id="html-spinner"></div>
        <span class="title mt-1">Creando Sondeo</span>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('#sondeos').addClass('mdc-list-item--active');

        // Declaración de urls a utilizar
        const urlObtenerProductos = '{!! route('ajax.sondeos.obtenerProductos', ['busqueda' => 'busqueda']) !!}';
        const urlObtenerPrecioProducto = '{!! route('ajax.sondeos.obtenerPrecioProducto', ['producto' => 'producto', 'listaprecio' => 'listaprecio']) !!}';

        // Declaración de elementos de material.io (Mismo orden en el que se renderizan)
        const producto = new mdc.textField.MDCTextField(document.querySelector('#mdc-producto'));
        const precioInventarioAvicampo = new mdc.textField.MDCTextField(document.querySelector('#mdc-precio_inventario_avicampo'));
        const precioEmpaqueAvicampo = new mdc.textField.MDCTextField(document.querySelector('#mdc-precio_empaque_avicampo'));
        const idCanal = new mdc.select.MDCSelect(document.querySelector('#mdc-id_canal'));
        const idCanalHelper = new mdc.select.MDCSelectHelperText(document.querySelector('#mdc-helper-id_canal'));
        const idMarca = new mdc.select.MDCSelect(document.querySelector('#mdc-id_marca'));
        const idMarcaHelper = new mdc.select.MDCSelectHelperText(document.querySelector('#mdc-helper-id_marca'));
        const listaPrecio = new mdc.select.MDCSelect(document.querySelector('#mdc-lista_precio'));
        const listaPrecioHelper = new mdc.select.MDCSelectHelperText(document.querySelector('#mdc-helper-lista_precio'));
        const precio = new mdc.textField.MDCTextField(document.querySelector('#mdc-precio'));
        const precioGramo = new mdc.textField.MDCTextField(document.querySelector('#mdc-precio_gramo'));
        const observaciones = new mdc.textField.MDCTextField(document.querySelector('#mdc-observaciones'));

        var factorConversion = 1000;
        precioInventarioAvicampo.value = 0;
        precioEmpaqueAvicampo.value = 0;

        $('.dropify').dropify({
            messages: {
                'default': 'Arrastra y suelta una imágen aquí o haz click',
                'replace': 'Arrastra y suelta una imágen o haz clic para reemplazar',
                'remove':  'Quitar Iimágen',
                'error':   'Ooops, hubo un error inesperado.',
            },
            error: {
                'fileSize': 'El tamaño de la imágen es demasiado grande.',
                'fileExtension': 'La extensión del archivo no es válida.',
            }
        });

        /**
            Acciones para Input de producto
            14/04/2021
        **/
        {
            // Variables
            var productoDef = '';  // Valor por defecto del campo de producto
            var productos = [];  // Listado de productos
            var auxProducto = {}; // Producto seleccionado

            // Busca los primeros 10 valores del listado de productos que concuerden con lo ingresado en el input
            $('#mdc-producto input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                let url = urlObtenerProductos.replace('busqueda', busqueda);
                if(busqueda){
                    $('#clear-producto').show();
                    $('#mdc-menu__buscar_producto').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_producto').empty();
                    $.ajax({
                        method: 'GET',
                        url: url,
                        context: document.body
                    }).done(function(response) {
                        productos = response.productos;
                        mostrarProductosBuscados();
                    }).fail(function(error) {
                        console.error(error);
                        productos = [];
                        mostrarProductosBuscados();
                    });

                }
            });

            // Restablece el valor por defecto en el compo de producto al quitar el foco del campo
            $('#mdc-producto input').blur(function() {
                if(!$('#mdc-menu__buscar_producto').hasClass('mdc-menu-surface--open')) {
                    producto.value = productoDef;
                }
                if (productoDef == '' || productoDef == null) {
                    $('#clear-producto').hide();
                } else {
                    $('#clear-producto').show();
                }
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
            $('#mdc-producto input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_producto').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_producto .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_producto .mdc-list-item').first().data('value');
                        seleccionarProducto(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_producto').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_producto .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_producto .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_producto .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_producto').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_producto .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_producto .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_producto .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    producto.value = productoDef;
                    $('#mdc-producto input').blur();
                    $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                    if (productoDef == '' || productoDef == null) {
                        $('#clear-producto').hide();
                    } else {
                        $('#clear-producto').show();
                    }
                }
                if (productoDef == '' || productoDef == null) {
                    $('#clear-producto').hide();
                } else {
                    $('#clear-producto').show();
                }
            });

            // Selecciona el producto en la cual se hace click
            $('#mdc-menu__buscar_producto').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarProducto(index, value);
            });

            // Selecciona el primer producto de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_producto').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarProducto(index, value);
                }
            });

            // Limpia el campo de producto, pero no altera el campo por defecto
            $('#clear-producto').click(function() {
                producto.value = '';
                producto.valid = true;
                $(this).hide();
                $('#mdc-producto input').focus();
            });

            // Selecciona la producto con base en el index del listado y el id
            function seleccionarProducto(index, value) {
                if (index === undefined || index === null) {
                    producto.value = productoDef;
                } else {
                    auxProducto = productos[index];
                    console.log(auxProducto);
                    if (productoDef != auxProducto.codigo + ' - ' + auxProducto.nombre) {
                        productoDef = auxProducto.codigo + ' - ' + auxProducto.nombre;
                        precio.value = '';
                        precioGramo.value = '';
                    }
                    $('#codigo_producto').val(value);
                    producto.value = productoDef;
                    buscarPrecioProducto();
                    if (auxProducto.undmed == 'KG' || auxProducto.undmed == ' KG') {
                        $('#lbl_precio').text('Precio x Kilo');
                        factorConversion = 1000;
                    } else {
                        $('#lbl_precio').text('Precio x Unidad');
                        factorConversion = auxProducto.peso_unidad * 1000;
                    }
                }
                $('#mdc-producto input').blur();
                $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                if (productoDef == '' || productoDef == null) {
                    $('#clear-producto').hide();
                } else {
                    $('#clear-producto').show();
                }
            }

            function buscarPrecioProducto() {
                // console.log("buscarprecio");
                // console.log(auxProducto);
                // console.log(producto.value);
                // console.log(listaPrecio.value);
                var url = urlObtenerPrecioProducto.replace('producto', auxProducto.codigo);
                url = url.replace('listaprecio', listaPrecio.value);
                // console.log(url);
                if(producto.value && listaPrecio.value){
                    $.ajax({
                        method: 'GET',
                        url: url,
                        context: document.body
                    }).done(function(response) {
                        console.log(response);
                        precioInventarioAvicampo.value = response.precio_unidad_inventario;
                        precioEmpaqueAvicampo.value = response.precio_unidad_empaque;
                    }).fail(function(error) {
                        precioInventarioAvicampo.value = 0;
                        precioEmpaqueAvicampo.value = 0;
                        console.error(error);
                    });
                }
            }

            function mostrarProductosBuscados() {
                $('#mdc-producto input').focus();
                $('#mdc-menu__buscar_producto').empty();
                if (productos.length) {
                    for (let index = 0; index < productos.length; index++) {
                        const auxProducto = productos[index];
                        if (auxProducto.codigo == $('#codigo_producto').val()) {
                            $('#mdc-menu__buscar_producto').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxProducto.codigo +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxProducto.codigo + ' - ' + auxProducto.nombre +'</span></li>');
                        } else {
                            $('#mdc-menu__buscar_producto').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxProducto.codigo +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxProducto.codigo + ' - ' + auxProducto.nombre +'</span></li>');
                        }
                    }
                } else {
                    $('#mdc-menu__buscar_producto').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                }
            }
        }

        // Asigna el valor del Select de Canal de Ventas al input
        idCanal.listen('MDCSelect:change', (el) => {
            $('#id_canal').val(idCanal.value);
        });

        // Asigna el valor del Select de Marca al input
        idMarca.listen('MDCSelect:change', (el) => {
            $('#id_marca').val(idMarca.value);
        });

        // Asigna el valor del Select de Lista de Precio al input
        listaPrecio.listen('MDCSelect:change', (el) => {
            $('#lista_precio').val(listaPrecio.value);
            buscarPrecioProducto();
        });

        /**
            Acciones para elementos generales y funciones
            20/01/2021
        **/
        {
            // Asigna el valor de las sesiones
            @if (Session::has('sondeo-id_canal'))
                idCanal.value = '{{ Session::get('sondeo-id_canal') }}';
            @endif

            @if (Session::has('sondeo-id_marca'))
                idMarca.value = '{{ Session::get('sondeo-id_marca') }}';
            @endif

            @if (Session::has('sondeo-lista_precio'))
                listaPrecio.value = '{{ Session::get('sondeo-lista_precio') }}';
            @endif

            // Reinicia los inputs
            document.addEventListener('click', function (event) {
                if (event.target.matches('.mdc-icon-clear')) {
                    event.preventDefault();
                } else {
                    if (!event.target.matches('.mdc-list-item')) {
                        $('.mdc-menu').removeClass('mdc-menu-surface--open');
                        if (producto.value && (productoDef != null || productoDef != '')) {
                            producto.value = productoDef;
                        }
                    }
                }
            }, false);

            // Ajusta el desplazamiento con flechas en los inputs de autocompletado
            $('.mdc-menu').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    let value = $(this).next().data('value');
                    let index = $(this).next().data('index');
                    if (index != undefined || index != null) {
                        $(this).next().focus();
                    } else {
                        $(this).parent().find('.mdc-list-item').first().focus();
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    let value = $(this).prev().data('value');
                    let index = $(this).prev().data('index');
                    if (index != undefined || index != null) {
                        $(this).prev().focus();
                    } else {
                        $(this).parent().find('.mdc-list-item').last().focus();
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    $('.mdc-menu').removeClass('mdc-menu-surface--open');
                    if (producto.value && (productoDef != null || productoDef != '')) {
                        producto.value = productoDef;
                    }
                }
            });

            //Calcula el Precio x Gramo con base en el Precio x Kilo
            $('#precio').on('change', function() {
                console.log(auxProducto);
                console.log(factorConversion);
                if (precio.value) {
                    if (!$('#precio_gramo').val()) {
                        precioGramo.value = parseFloat((precio.value / factorConversion).toFixed(numDecimales));
                    }
                } else {
                    precioGramo.value = '';
                }
            });

            //Calcula el Precio con base en el Precio x Libra
            $('#precio_gramo').on('change', function() {
                console.log(auxProducto);
                console.log(factorConversion);
                if (precioGramo.value) {
                    if (!$('#precio').val()) {
                        precio.value = parseFloat((precioGramo.value * factorConversion).toFixed(numDecimales));
                    }
                } else {
                    precio.value = '';
                }
            });

            // Valida el formulario antes de enviarlo
            const validar = function() {
                if (!idCanal.valid || idCanal.value == null || idCanal.value == '') {
                    idCanal.valid = false;
                    idCanalHelper.foundation.setContent('Seleccione un canal de ventas.');
                    M.toast({html: '<span class="mr-3">Error en el canal de ventas.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!idMarca.valid || idMarca.value == null || idMarca.value == '') {
                    idMarca.valid = false;
                    idMarcaHelper.foundation.setContent('Seleccione una marca.');
                    M.toast({html: '<span class="mr-3">Error en la marca.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!listaPrecio.valid || listaPrecio.value == null || listaPrecio.value == '') {
                    listaPrecio.valid = false;
                    listaPrecioHelper.foundation.setContent('Seleccione una lista de precios.');
                    M.toast({html: '<span class="mr-3">Error en la lista de precios.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!producto.valid || producto.value == null || producto.value == '' || $('#codigo_producto').val() == null || $('#codigo_producto').val() == '') {
                    producto.valid = false;
                    producto.helperTextContent = 'Seleccione el producto.';
                    M.toast({html: '<span class="mr-3">Error en el producto del sondeo.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!precio.valid || precio.value == null || precio.value == '') {
                    precio.valid = false;
                    precio.helperTextContent = 'Ingrese el precio del producto.';
                    M.toast({html: '<span class="mr-3">Error en el precio del producto.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!precioGramo.valid || precioGramo.value == null || precioGramo.value == '') {
                    precioGramo.valid = false;
                    precioGramo.helperTextContent = 'Ingrese el precio por gramo.';
                    M.toast({html: '<span class="mr-3">Error en el precio por gramo.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                return true;
            }

            // Ejecuta la función de validación antes de enviar el formulario
            $('.crear_sondeo').on('click', async function(e) {
                $('#guardando').show();
                $('body').css('overflow', 'hidden');
                $('.crear_sondeo').attr('disabled', 'disabled');
                e.preventDefault();
                let validacion = validar();
                if (validacion) {
                    $('#form').submit();
                } else {
                    $('#guardando').hide();
                    $('body').css('overflow', '');
                    $('.crear_sondeo').removeAttr('disabled');
                }
            });
        }
    </script>
@endsection

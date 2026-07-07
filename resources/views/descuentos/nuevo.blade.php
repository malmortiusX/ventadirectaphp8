@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <form action="{{ route('descuentos.create') }}" method="POST" id="form">
        @csrf
        <input type="hidden" class="hide" name="id_cliente" id="id_cliente">
        <input type="hidden" class="hide" name="codigo_producto" id="codigo_producto">
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Nueva Solicitud de Descuento</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('descuentos.index') }}" class="breadcrumb">Sol. Descuento</a>
                        <a class="breadcrumb">Nueva</a>
                    </div>
                </div>
                <div class="col m6 right-align hide-on-small-only">
                    <a href="{{ route('descuentos.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large crear_solicitud" type="submit">
                        <span class="mdc-button__label mr-1">Crear Solicitud</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted mt-0">
                        <div class="card-content">
                            <div class="row mb-0">
                                <div class="col s12 l6 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-cliente">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_cliente">Cliente</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                        <input type="text" class="mdc-text-field__input" data-input="cliente" aria-labelledby="lbl_cliente" autocomplete="off" required>
                                        <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                        <span id="clear-cliente" class="form-clear d-none mdc-icon-clear" style="display: none">
                                            <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-cliente" aria-hidden="true"></div>
                                    </div>
                                    <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                        <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_cliente">
                                            <ul class="mdc-list">
                                                <!-- Items que coincidan con la búsqueda -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 l6 mb-1">
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
                                <div class="col s7 m6 l3 mb-1-m">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--filled mdc-text-field--label-floating mdc-text-field--dense" id="mdc-fecha">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha" id="fecha" name="fecha" min="{{ $hoy->addDay()->toDateString() }}" value="{{ $hoy->toDateString() }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label mdc-floating-label--float-above" id="lbl_fecha">Fecha</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-fecha" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s5 m6 l3 mb-1-m">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating mdc-text-field--dense" id="mdc-porcentaje">
                                        <input class="mdc-text-field__input" type="number" step="0.01" aria-labelledby="lbl_porcentaje" id="porcentaje" name="porcentaje" max="100" min="0.01" required>
                                        <span class="mdc-text-field__affix mdc-text-field__affix--suffix">%</span>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_porcentaje">Descuento</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-porcentaje" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s6 l3 mb-1-s">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating mdc-text-field--dense" id="mdc-kilos">
                                        <input class="mdc-text-field__input" type="number" step="0.01" aria-labelledby="lbl_kilos" id="kilos" name="kilos" min="0.01" required>
                                        <span class="mdc-text-field__affix mdc-text-field__affix--suffix">Kgs</span>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_kilos">Kilogramos</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-kilos" aria-hidden="true"></div>
                                    </div>
                                </div>
                                <div class="col s6 l3">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating mdc-text-field--dense" id="mdc-unidades">
                                        <input class="mdc-text-field__input" type="number" step="1" aria-labelledby="lbl_unidades" id="unidades" name="unidades" min="1" required>
                                        <span class="mdc-text-field__affix mdc-text-field__affix--suffix">Uds</span>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_unidades">Unidades</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-unidades" aria-hidden="true"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('descuentos.index')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large crear_solicitud" type="submit">
                        <span class="mdc-button__label mr-1">Crear Solicitud</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="cargando noselect px-5 center" id="guardando" style="display: none">
        <div id="html-spinner"></div>
        <span class="title mt-1">Creando Solicitud</span>
    </div>
@endsection

@section('scripts')
    <script>
        $('#descuentos').addClass('mdc-list-item--active');

        // Declaración de urls a utilizar
        const urlObtenerProductosListaPrecio = '{!! route('ajax.descuentos.obtenerProductosListaPrecio', ['lista_precio' => 'lista_precio', 'busqueda' => 'busqueda']) !!}';

        // Declaración de elementos de material.io (Mismo orden en el que se renderizan)
        const cliente = new mdc.textField.MDCTextField(document.querySelector('#mdc-cliente'));
        const producto = new mdc.textField.MDCTextField(document.querySelector('#mdc-producto'));
        const fecha = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha'));
        const porcentaje = new mdc.textField.MDCTextField(document.querySelector('#mdc-porcentaje'));
        const kilos = new mdc.textField.MDCTextField(document.querySelector('#mdc-kilos'));
        const unidades = new mdc.textField.MDCTextField(document.querySelector('#mdc-unidades'));
        
        /**
            Acciones para Input de clientes
            20/01/2021
        **/
        {
            // Variables
            var clienteDef = '';  // Valor por defecto del campo de cliente
            var listaPrecio = '';  // Guarda la lista de precio para consultar los productos
            var clientes = @json($usuario->clientes);  // Listado de clientes

            // Busca los primeros 10 valores del listado de clientes que concuerden con lo ingresado en el input
            $('#mdc-cliente input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                if(busqueda){
                    $('#clear-cliente').show();
                    $('#mdc-menu__buscar_cliente').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_cliente').empty();
                    if (clientes.length) {
                        let auxCant = 0;
                        for (let index = 0; index < clientes.length; index++) {
                            const auxCliente = clientes[index];
                            // Se configura para que no tenga en cuenta las tildes
                            if (auxCliente.nombre_cliente.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, "")) || auxCliente.cc_nit.includes(busqueda)) {
                                auxCant++;
                                if (auxCliente.id_cliente == $('#id_cliente').val()) {
                                    $('#mdc-menu__buscar_cliente').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxCliente.id_cliente +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCliente.cc_nit + ' - ' + auxCliente.nombre_cliente +'</span></li>');
                                } else {
                                    $('#mdc-menu__buscar_cliente').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxCliente.id_cliente +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCliente.cc_nit + ' - ' + auxCliente.nombre_cliente +'</span></li>');
                                }
                            }
                            if (auxCant == 10) {
                                break;
                            }
                        }
                        if (!auxCant) {
                            $('#mdc-menu__buscar_cliente').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_cliente').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                    }
                }
            });

            // Restablece el valor por defecto en el compo de cliente al quitar el foco del campo
            $('#mdc-cliente input').blur(function() {
                if(!$('#mdc-menu__buscar_cliente').hasClass('mdc-menu-surface--open')) {
                    cliente.value = clienteDef;
                }
                if (clienteDef == '' || clienteDef == null) {
                    $('#clear-cliente').hide();
                } else {
                    $('#clear-cliente').show();
                }
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input 
            $('#mdc-cliente input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) { 
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_cliente').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_cliente .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_cliente .mdc-list-item').first().data('value');
                        seleccionarCliente(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_cliente').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_cliente .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_cliente .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_cliente .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_cliente').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_cliente .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_cliente .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_cliente .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    cliente.value = clienteDef;
                    $('#mdc-cliente input').blur();
                    $('#mdc-menu__buscar_cliente').removeClass('mdc-menu-surface--open');
                    if (clienteDef == '' || clienteDef == null) {
                        $('#clear-cliente').hide();
                    } else {
                        $('#clear-cliente').show();
                    }
                }
                if (clienteDef == '' || clienteDef == null) {
                    $('#clear-cliente').hide();
                } else {
                    $('#clear-cliente').show();
                }
            });

            // Selecciona la cliente en la cual se hace click
            $('#mdc-menu__buscar_cliente').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarCliente(index, value);
            });

            // Selecciona la primer cliente de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_cliente').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarCliente(index, value);
                }
            });

            // Limpia el campo de cliente, pero no altera el campo por defecto
            $('#clear-cliente').click(function() {
                cliente.value = '';
                cliente.valid = true;
                $(this).hide();
                $('#mdc-cliente input').focus();
            });

            // Selecciona al cliente con base en el index del listado y el id
            function seleccionarCliente(index, value) {
                if (index === undefined || index === null) {
                    cliente.value = clienteDef;
                } else {
                    let auxCliente = clientes[index];
                    clienteDef = auxCliente.cc_nit + ' - ' + auxCliente.nombre_cliente;
                    $('#id_cliente').val(value);
                    cliente.value = clienteDef;
                    if (listaPrecio != auxCliente.lista_precio) {
                        listaPrecio = auxCliente.lista_precio;
                        $('#codigo_producto').val('');
                        productoDef = '';
                        producto.value = productoDef;
                    }
                }
                $('#mdc-cliente input').blur();
                $('#mdc-menu__buscar_cliente').removeClass('mdc-menu-surface--open');
                if (clienteDef == '' || clienteDef == null) {
                    $('#clear-cliente').hide();
                } else {
                    $('#clear-cliente').show();
                }
            }
        }

        /**
            Acciones para Input de producto
            20/01/2021
        **/
        {
            // Variables
            var productoDef = '';  // Valor por defecto del campo de producto
            var productos = [];  // Listado de productos

            // Busca los primeros 10 valores del listado de productos que concuerden con lo ingresado en el input
            $('#mdc-producto input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                let url = urlObtenerProductosListaPrecio.replace('lista_precio', listaPrecio).replace('busqueda', busqueda);
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

            // Selecciona la producto en la cual se hace click
            $('#mdc-menu__buscar_producto').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarProducto(index, value);
            });

            // Selecciona la primer producto de la lista, en caso de que se oprima Enter mientras el foco está en el input
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
                    let auxProducto = productos[index];
                    productoDef = auxProducto.codigo + ' - ' + auxProducto.nombre;
                    $('#codigo_producto').val(value);
                    producto.value = productoDef;
                }
                $('#mdc-producto input').blur();
                $('#mdc-menu__buscar_producto').removeClass('mdc-menu-surface--open');
                if (productoDef == '' || productoDef == null) {
                    $('#clear-producto').hide();
                } else {
                    $('#clear-producto').show();
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

        /**
            Acciones para elementos generales y funciones
            20/01/2021
        **/
        {
            // Reinicia los inputs
            document.addEventListener('click', function (event) {
                if (event.target.matches('.mdc-icon-clear')) {
                    event.preventDefault();
                } else {
                    if (!event.target.matches('.mdc-list-item')) {
                        $('.mdc-menu').removeClass('mdc-menu-surface--open');
                        if (cliente.value && (clienteDef != null || clienteDef != '')) {
                            cliente.value = clienteDef;
                        }
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
                    if (cliente.value && (clienteDef != null || clienteDef != '')) {
                        cliente.value = clienteDef;
                    }
                    if (producto.value && (productoDef != null || productoDef != '')) {
                        producto.value = productoDef;
                    }
                }
            });

            // Valida el formulario antes de enviarlo
            const validar = function() {
                if (!cliente.valid || cliente.value == null || cliente.value == '' || $('#id_cliente').val() == null || $('#id_cliente').val() == '') {
                    cliente.valid = false;
                    cliente.helperTextContent = 'Seleccione el cliente.';
                    M.toast({html: '<span class="mr-3">Error en el cliente del descuento.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!producto.valid || producto.value == null || producto.value == '' || $('#codigo_producto').val() == null || $('#codigo_producto').val() == '') {
                    producto.valid = false;
                    producto.helperTextContent = 'Seleccione el producto.';
                    M.toast({html: '<span class="mr-3">Error en el producto del descuento.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!fecha.valid || fecha.value == null || fecha.value == '') {
                    fecha.valid = false;
                    fecha.helperTextContent = 'Ingrese la fecha.';
                    M.toast({html: '<span class="mr-3">Error en la fecha del descuento.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!porcentaje.valid || porcentaje.value == null || porcentaje.value == '') {
                    porcentaje.valid = false;
                    porcentaje.helperTextContent = 'Ingrese el % de descuento.';
                    M.toast({html: '<span class="mr-3">Error en el valor(%) del descuento.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!kilos.valid || kilos.value == null || kilos.value == '') {
                    kilos.valid = false;
                    kilos.helperTextContent = 'Ingrese la cantidad de kilogramos.';
                    M.toast({html: '<span class="mr-3">Error en la cantidad de kilogramos.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!unidades.valid || unidades.value == null || unidades.value == '') {
                    unidades.valid = false;
                    unidades.helperTextContent = 'Ingrese la cantidad de unidades.';
                    M.toast({html: '<span class="mr-3">Error en la cantidad de unidades.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                
                return true;
            }

            // Ejecuta la función de validación antes de enviar el formulario
            $('.crear_solicitud').on('click', async function(e) {
                $('#guardando').show();
                $('body').css('overflow', 'hidden');
                $('.crear_solicitud').attr('disabled', 'disabled');
                e.preventDefault();
                let validacion = validar();
                if (validacion) {
                    $('#form').submit();
                } else {
                    $('#guardando').hide();
                    $('body').css('overflow', '');
                    $(this).removeAttr('disabled');
                }
            });
        }
    </script>
@endsection
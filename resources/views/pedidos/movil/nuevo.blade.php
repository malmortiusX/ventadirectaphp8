@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        @if (isset($vendedores)) <input type="hidden" class="hide" name="codigo_vendedor" id="codigo_vendedor"> @endif
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Nuevo Pedido</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.index') }}" class="breadcrumb">Pedidos</a>
                        <a class="breadcrumb">Nuevo</a>
                    </div>
                </div>
                <div class="col m6 right-align hide-on-small-only">
                    <a href="{{ route('pedidos.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large" id="enviar_pedido" type="submit">
                        <span class="mdc-button__label mr-1">Crear Pedido</span>
                        <i class="fas fa-truck"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="row">
                        <div class="col s12 m6 relative">
                            <div class="card highlighted">
                                <div class="card-content">
                                    <span class="card-title mb-3">Datos del Cliente</span>
                                    <div class="row mb-0">
                                        @if (isset($vendedores))
                                            <div class="col s12 m6">
                                                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-codigo_vendedor">
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span class="mdc-floating-label" id="lbl_codigo_vendedor">Vendedor</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                    <input type="text" class="mdc-text-field__input" data-input="codigo_vendedor" aria-labelledby="lbl_codigo_vendedor" autocomplete="off" required>
                                                    <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                                    <span id="clear-codigo_vendedor" class="form-clear d-none mdc-icon-clear" style="display: none">
                                                        <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                                    </span>
                                                </label>
                                                <div class="mdc-text-field-helper-line">
                                                    <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-codigo_vendedor" aria-hidden="true"></div>
                                                </div>
                                                <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                    <div class="mdc-menu mdc-menu-surface mdc-menu--dense mdc-menu--autocomplete" role="listbox" id="mdc-menu__buscar_codigo_vendedor">
                                                        <ul class="mdc-list">
                                                            <!-- Items que coincidan con la búsqueda -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col s12 {{ isset($vendedores) ? 'm6' : '' }}">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="buscar_cliente">
                                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_buscar_cliente" name="buscar_cliente" autocomplete="off">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_buscar_cliente">Buscar por CC/NIT o por Nombre</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_cliente">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-0" id="datos_cliente" style="display: none;">
                                        <input type="text" class="hide" name="id_cliente" id="id_cliente">
                                        <div class="col s9 xl10 mb-1">
                                            <label>Nombre Completo</label>
                                            <span id="datos_cliente_nombre" class="card-subtitle highlighted capitalize"></span>
                                        </div>
                                        <div class="col s3 xl2 mb-1">
                                            <label>Lista</label>
                                            <span id="datos_cliente_lista" class="card-subtitle highlighted capitalize"></span>
                                        </div>
                                        <div class="col s6 mb-1">
                                            <label>Valor Facturado</label>
                                            <span id="datos_cliente_valor_facturado" class="card-subtitle subtitle-3 highlighted capitalize"></span>
                                        </div>
                                        <div class="col s6 mb-1">
                                            <label>Cupo Total</label>
                                            <span id="datos_cliente_cupo" class="card-subtitle subtitle-3 highlighted capitalize"></span>
                                        </div>
                                        <div class="col s6 mb-1">
                                            <label>Cartera</label>
                                            <span id="datos_cliente_cartera" class="card-subtitle subtitle-3 highlighted capitalize"></span>
                                        </div>
                                        <div class="col s6 mb-1">
                                            <label>Cupo Disponible</label>
                                            <span id="datos_cliente_cupo_disponible" class="card-subtitle subtitle-3 highlighted capitalize"></span>
                                        </div>
                                        <div class="col s12 l4 mb-1">
                                            <label>CC / NIT</label>
                                            <span id="datos_cliente_cc_nit" class="card-subtitle subtitle-3 highlighted capitalize"></span>
                                        </div>
                                        <div class="col s12 l4 mb-1">
                                            <label>Teléfono</label>
                                            <a href="tel:+57" id="datos_cliente_telefono" class="card-subtitle subtitle-3 highlighted capitalize"></a>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <label>Dirección</label>
                                            <span id="datos_cliente_direccion" class="card-subtitle subtitle-3 highlighted capitalize"></span>
                                        </div>
                                        <div class="col s12 right-align">
                                            <button class="mdc-button mdc-button--outlined mdc-button--dense modal-trigger" data-target="estadisticas_cliente_modal" id="estadisticas_cliente" type="button">
                                                <span class="mdc-button__label mr-1">Estadisticas de Cliente</span>
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="card highlighted">
                                <div class="card-content">
                                    <span class="card-title mb-0">Opciones del Pedido</span>
                                    <div class="row mb-0">
                                        <input type="number" class="hide" name="estado" id="estado" value="0">
                                        @if ($empresa->nombre != 'Italcol')
                                            <div class="col s12 mb-2">
                                                <div class="mdc-touch-target-wrapper">
                                                    <div class="mdc-checkbox mdc-checkbox--touch" id="mdc_productos">
                                                        <input type="checkbox" class="mdc-checkbox__native-control" id="productos" name="productos"/>
                                                        <div class="mdc-checkbox__background">
                                                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                            </svg>
                                                            <div class="mdc-checkbox__mixedmark"></div>
                                                        </div>
                                                        <div class="mdc-checkbox__ripple"></div>
                                                    </div>
                                                    <label id="mdc_productos_lbl" for="productos" class="noselect nowrap">Cargar productos y cantidades del pedido anterior</label>
                                                </div>
                                            </div>
                                        @else
                                            <br>
                                        @endif
                                        <div class="col s12 xl5 mb-3">
                                            <div class="mdc-select mdc-select--outlined mdc-select--dense" id="mdc-select__cop">
                                                <div class="mdc-select__anchor" aria-labelledby="outlined-select-label">
                                                    <input type="text" name="cop" id="cop" class="mdc-select__input-value" value="{{ $usuario->cop }}">
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
                                                <div id="mdc-menu-cop" class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox">
                                                    <ul class="mdc-list">
                                                        @foreach ($usuario->centrosDist as $centro)
                                                            <li class="mdc-list-item {{ $centro->cop == $usuario->cop ? 'mdc-list-item--selected' : '' }}" data-value="{{ $centro->cop }}" role="option" {{ $centro->cop == $usuario->cop ? 'aria-selected="true"' : '' }}>
                                                                <span class="mdc-list-item__text">{{ ucfirst(strtolower($centro->nombre)) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s6 xl4 mb-3">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-fecha_entrega">
                                                <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha_entrega" name="fecha_entrega" id="fecha_entrega" value="{{ date("Y-m-d", time() + 86400) }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_fecha_entrega">Fecha de Entrega</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col s6 xl3 mb-3">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-orden">
                                                <input type="number" class="mdc-text-field__input" aria-labelledby="lbl_orden" name="orden" id="orden">
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
                                        <div class="col s12 mb-3">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-orden_compra">
                                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_orden" name="orden_compra" id="orden_compra">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="orden_compra">Orden de Compra</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        @endif
                                        <div class="col s12">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--textarea-dense">
                                                <span class="mdc-text-field__resizer">
                                                    <textarea class="mdc-text-field__input" rows="3" cols="40" aria-label="Label" name="observacion_pedido"></textarea>
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
                        <div class="col s12">
                            <a href="{{ route('pedidos.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir_mv">
                                <span class="mdc-button__label">Salir</span>
                            </a>
                            <button class="mdc-button mdc-button--raised mdc-button--large" id="enviar_pedido_mv" type="submit">
                                <span class="mdc-button__label mr-1">Crear Pedido</span>
                                <i class="fas fa-truck"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="estadisticas_cliente_modal" class="modal modal-md">
        <div class="modal-content">
            <div class="row mb-0">
                <div class="col s12">
                    <h4 class="title capitalize mb-0" id="nombre_cliente"></h4>
                    <span class="mb-2">Esta es la estadística de productos del cliente seleccionado, durante la última semana.</span>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 mt-2">
                    <div>
                        <div class="card card--outlined dashed transparent mb-0" id="productos_vacio" style="display: none;">
                            <div class="card-content center">
                                <h3 class="card-title center mb-3">NO SE ENCONTRARON PRODUCTOS</h3>
                            </div>
                        </div>
                        <table id="lista_productos" class="display responsive" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Promedio</th>
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
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Activa la sección en la barra lateral
            $('#pedidos-create').addClass('mdc-list-item--active');

            var clientesListado = [];
            var clientePedido = [];
            @if (isset($vendedores))
                var urlBuscarClientes = '{!! route('ajax.clientes.vendedor.buscar', ['vendedor' => 'vendedor', 'busqueda' => 'busqueda']) !!}';
                var urlBuscarCentrosDist = '{!! route('ajax.centdist.vendedor', ['vendedor' => 'null']) !!}';
            @else
                var urlBuscarClientes = '{!! route('ajax.clientes.buscar', ['busqueda' => 'null']) !!}';
            @endif
            var urlBuscarProductosCliente = '{!! route('ajax.clientes.productos', ['cliente' => 'null']) !!}';
            var horaLimite = '{{ $usuario->pedidos_mismo_dia ? $usuario->limite_mismo_dia : "" }}';//nuevo
            //var horaLimite = '{{ $usuario->pedidos_mismo_dia ? "" : $usuario->limite_mismo_dia }}';//como está
            var hoy = '{{ $hoy ?? '' }}';
            //console.log(hoy);
            //console.log(horaLimite);

            // Inicializa los textFields de Material.io
            const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                return new mdc.textField.MDCTextField(el);
            });
            @if (isset($vendedores))
                const codigo_vendedor = new mdc.textField.MDCTextField(document.querySelector('#mdc-codigo_vendedor'));
            @endif

            // Inicializa los selects de Material.io
            const selects = [].map.call(document.querySelectorAll('.mdc-select'), function(el) {
                return new mdc.select.MDCSelect(el);
            });

            // Asigna una función que detecta cuando se cambia el Centro de Distribución
            const busquedaCliente = new mdc.textField.MDCTextField(document.querySelector('#buscar_cliente'));
            const fechaEntrega = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_entrega'));
            var selectCop = new mdc.select.MDCSelect(document.querySelector('#mdc-select__cop'));
            selectCop.listen('MDCSelect:change', (el) => {
                $('#cop').val(selectCop.value);
            });

            // Inicializa elementos de materialize
            $('#estadisticas_cliente_modal').modal({
                startingTop: '0',
                endingTop: '5%',
                dismissible: true,
                onOpenEnd: function(modal, trigger) {
                    $('#nombre_cliente').text(clientePedido.nombre_cliente.toLowerCase());
                    buscarProductosCliente();
                },
                onCloseEnd: function() {
                    $('#nombre_cliente').text('');
                    $('.cargando').show();
                }
            });

            fechaMinima();

            $('#buscar_cliente input').keyup(function(){
                var busqueda = $(this).val().toUpperCase();
                if(busqueda.length > 2){
                    buscarCliente(busqueda);
                } else {
                    $('#mdc-menu__buscar_cliente').removeClass('mdc-menu-surface--open');
                }
            });

            $('#buscar_cliente input').blur(function(){
                if ($('#mdc-menu__buscar_cliente').hasClass('mdc-menu-surface--open')) {
                    $(document).click(function(){
                        $('#mdc-menu__buscar_cliente').removeClass('mdc-menu-surface--open');
                    });
                }
            });

            $('#mdc-menu__buscar_cliente').on('click', '.mdc-list-item', function(){
                let index = $(this).data('index');
                let cliente = clientesListado[index];
                if(cliente) {
                    clientePedido = cliente;
                    $('#mdc-menu__buscar_cliente').removeClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_cliente').empty();
                    $('#buscar_cliente input').val('');
                    $('#id_cliente').val(cliente.id_cliente);
                    $('#datos_cliente_nombre').text(cliente.nombre_cliente.toLowerCase());
                    $('#datos_cliente_lista').text(cliente.lista_precio);
                    $('#datos_cliente_cc_nit').text(cliente.cc_nit);
                    $('#datos_cliente_telefono').text(cliente.telefono);
                    let telefonocliente = 'tel:+57' + cliente.telefono;
                    $('#datos_cliente_telefono').attr('href', telefonocliente);
                    $('#datos_cliente_direccion').text((cliente.direccion +' - '+ cliente.ciudad).toLowerCase());
                    $('#datos_cliente_cupo').text('$ ' + numeroMiles(cliente.cupo));
                    $('#datos_cliente_cartera').text('$ ' + numeroMiles(cliente.deuda));
                    $('#datos_cliente_cupo_disponible').text('$ ' + numeroMiles(cliente.cupo - cliente.deuda));
                    $('#datos_cliente_valor_facturado').text('$ ' + numeroMiles(cliente.valor_facturado));
                    $('#estadisticas_cliente').attr('data-cliente', cliente.id_cliente);
                    $('#datos_cliente').show();
                } else {
                    $('#datos_cliente').hide();
                }
            });

            $('#lista_clientes').on('change', '.cantidad_cliente', function() {
                var fila = $(this).closest('.item-cliente');
                var codigo = fila.find('.codigo_cliente').val();
                var clienteModificado = null;
                let subtotalcliente = 0;
                for (let index = 0; index < clientePedido.length; index++) {
                    if (clientePedido[index].codigo == codigo){
                        clienteModificado = clientePedido[index];
                        break;
                    }
                }
                if (clienteModificado) {
                    clienteModificado.cantidad = $(this).val();
                    if(clienteModificado.precio_unidad_empaque > 500) {
                        subtotalcliente = clienteModificado.precio_unidad_empaque * clienteModificado.cantidad;
                    } else {
                        subtotalcliente = clienteModificado.precio_unidad_inventario * clienteModificado.cantidad;
                    }
                    fila.find('.subtotal-cliente').text('$ ' + subtotalcliente);
                }
                let toltalPedido = 0;
                for (let index = 0; index < clientePedido.length; index++) {
                    const clientePed = clientePedido[index];
                    if(clientePed.precio_unidad_empaque > 500) {
                        toltalPedido += (clientePed.precio_unidad_empaque * clientePed.cantidad);
                    } else {
                        toltalPedido += (clientePed.precio_unidad_inventario * clientePed.cantidad);
                    }
                }
                $('#items_pedido').text(clientePedido.length);
                $('#valor_pedido').text('$ ' + toltalPedido);
            });

            $('#enviar_pedido').click(function(e){
                e.preventDefault();
                validarEnvio();
            });

            $('#enviar_pedido_mv').click(function(e){
                e.preventDefault();
                validarEnvio();
            });

            function activarclientes() {
                var cop = $('#cop').val();
                var fecha_entrega = $('#fecha_entrega').val();
                if(cop && fecha_entrega) {
                    $('#buscar_cliente').removeClass('mdc-text-field--disabled');
                    $('#buscar_cliente input').removeAttr('disabled');
                    $('#enviar_pedido').removeAttr('disabled');
                    $('#salir').removeAttr('disabled');
                    $('#agregar_cliente').removeAttr('disabled');
                } else {
                    $('#buscar_cliente').addClass('mdc-text-field--disabled');
                    $('#buscar_cliente input').attr('disabled', 'disabled');
                    $('#enviar_pedido').attr('disabled', 'disabled');
                    $('#salir').attr('disabled', 'disabled');
                    $('#agregar_cliente').attr('disabled', 'disabled');
                }
            }

            function buscarCliente(busqueda) {
                @if (isset($vendedores))
                    var urlBuscar = urlBuscarClientes.replace('vendedor', $('#codigo_vendedor').val()).replace('busqueda', busqueda);
                @else
                    var urlBuscar = urlBuscarClientes.replace('null', busqueda);
                @endif
                console.log(urlBuscar);
                $('#mdc-menu__buscar_cliente').addClass('mdc-menu-surface--open');
                $('#mdc-menu__buscar_cliente').empty();
                $('#mdc-menu__buscar_cliente').append('<li class="mdc-list-item" role="option"><span class="mdc-list-item__text">Buscando</span></li>');
                $.ajax({
                    'url': urlBuscar,
                    'context': document.body
                }).done(function(response) {
                    $('#mdc-menu__buscar_cliente').empty();
                    var clientes = response.clientes;
                    clientesListado = response.clientes;
                    if(clientes.length) {
                        for (let index = 0; index < clientes.length; index++) {
                            const cliente = clientes[index];
                            let tipoFila;
                            if (index % 2) {
                                tipoFila = 'odd';
                            } else {
                                tipoFila = 'pair';
                            }
                            $('#mdc-menu__buscar_cliente').append('<li tabindex="0" class="mdc-list-item mdc-list-item-'+ tipoFila +' nowrap" data-index="'+ index +'" role="option"><span class="mdc-list-item__text capitalize">'+ cliente.cc_nit +' - '+ cliente.nombre_cliente.toLowerCase() +'</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_cliente').append('<li class="mdc-list-item mdc-list-item--cliente" role="option"><span class="mdc-list-item__text">No hay clientes</span></li>');
                    }
                });
            }

            function buscarProductosCliente() {
                let urlBuscar = urlBuscarProductosCliente.replace('null', clientePedido.id_cliente);
                $.ajax({
                    'url': urlBuscar,
                    'context': document.body
                }).done(function(response) {
                    $('#lista_productos').DataTable({
                        destroy: true,
                        data: response.productos,
                        pageLength: 10,
                        order: [],
                        responsive: true,
                        columnDefs: [
                            { responsivePriority: 1, targets: [0, 2, 5] },
                            { responsivePriority: 2, targets: [0, 1] },
                            { searchable: false, targets: [3, 4, 5] }
                        ],
                        columns: [
                            {
                                title: 'Día',
                                data: 'nombre_dia',
                                className: 'capitalize nowrap'
                            },
                            {
                                title: 'Codigo',
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
                                        return 'Cliente Sin Nombre';
                                    }
                                }
                            },
                            {
                                title: 'Cantidad',
                                data: 'undmed',
                                className: 'right-align nowrap',
                                render: function(data, type, row){
                                    if (data.replace(' ', '') == 'KG') {
                                        return numeroMiles(row.peso.toFixed(2)) + ' Kg';
                                    } else {
                                        return numeroMiles(row.unidades) + ' Un';
                                    }
                                }
                            },
                            {
                                title: 'Promedio',
                                data: 'undmed',
                                className: 'right-align nowrap',
                                render: function(data, type, row){
                                    if (data.replace(' ', '') == 'KG') {
                                        return '$ ' + numeroMiles(row.prom_peso.toFixed(0));
                                    } else {
                                        return '$ ' + numeroMiles(row.prom_unidades);
                                    }
                                }
                            },
                            {
                                title: 'Total',
                                data: 'total',
                                className: 'right-align nowrap',
                                render: function(data, type, row){
                                    return '$ ' + numeroMiles(data.toFixed(0));
                                }
                            }
                        ],
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

                    $('.cargando').hide();
                });
            }

            function addDays(date, days) {
                var result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
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

            function validarEnvio() {
                let validCop = false;
                let validEntrega = false;
                let validCliente = false;

                if (!$('#id_cliente').val()) {
                    Swal.fire({
                        title: 'ERROR!',
                        text: "Debe seleccionar un cliente.",
                        icon: 'error'
                    });
                    busquedaCliente.valid = false;
                    return;
                }

                if (!selectCop.value || !selectCop.valid) {
                    Swal.fire({
                        title: 'ERROR!',
                        text: "Debe seleccionar un Centro de Distribución.",
                        icon: 'error'
                    });
                    return;
                }

                if (!fechaEntrega.value || !fechaEntrega.valid) {
                    Swal.fire({
                        title: 'ERROR!',
                        text: "Debe seleccionar una Fecha de Entrega válida.",
                        icon: 'error'
                    });
                    return;
                }

                if (horaLimite) {
                    //var horaActual = new Date().toLocaleTimeString('en-US', { hour12: false});
                    //console.log(horaActual);
                    if (hoy > horaLimite) {
                        let fecha = new Date();
                        fecha.setHours(horaLimite.substring(0, 2));
                        fecha.setMinutes(horaLimite.substring(2, 2));
                        Swal.fire({
                            title: 'ERROR!',
                            text: 'Hola {{ mb_convert_case($usuario->nombres, MB_CASE_TITLE, "UTF-8") }}, no puedes crear pedidos después de las '+ fecha.toLocaleTimeString('es-CO', { hour12: true, hour: '2-digit', minute: '2-digit'}),
                            icon: 'error'
                        });
                        return;
                    } else {
                        $('#estado').val(1);
                        $('form').submit();
                    }
                } else {
                    $('#estado').val(1);
                    $('form').submit();
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

            @if (isset($vendedores))
                /**
                    Acciones para Input de vendedor
                    24/09/2021
                **/
                {
                    // Variables
                    var vendedorDef = '';                 // Valor por defecto del campo de vendedor
                    var vendedores = @json($vendedores);    // Listado de vendedores

                    // Busca los primeros 10 valores del listado de vendedores que concuerden con lo ingresado en el input
                    $('#mdc-codigo_vendedor input').keyup(function(){
                        let busqueda = $(this).val().toUpperCase();
                        if(busqueda){
                            $('#clear-codigo_vendedor').show();
                            $('#mdc-menu__buscar_codigo_vendedor').addClass('mdc-menu-surface--open');
                            $('#mdc-menu__buscar_codigo_vendedor').empty();
                            if (vendedores.length) {
                                let auxCant = 0;
                                for (let index = 0; index < vendedores.length; index++) {
                                    const auxVendedor = vendedores[index];
                                    // Se configura para que no tenga en cuenta las tildes
                                    if (auxVendedor.codigo_vendedor.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, "")) || auxVendedor.nombres.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, "")) || auxVendedor.apellidos.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
                                        auxCant++;
                                        if (auxVendedor.codigo_vendedor == $('#codigo_vendedor').val()) {
                                            $('#mdc-menu__buscar_codigo_vendedor').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxVendedor.codigo_vendedor +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxVendedor.codigo_vendedor +' - '+ auxVendedor.nombres +' '+ auxVendedor.apellidos +'</span></li>');
                                        } else {
                                            $('#mdc-menu__buscar_codigo_vendedor').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxVendedor.codigo_vendedor +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text nowrap">'+ auxVendedor.codigo_vendedor +' - '+ auxVendedor.nombres +' '+ auxVendedor.apellidos +'</span></li>');
                                        }
                                    }
                                    if (auxCant == 10) {
                                        break;
                                    }
                                }
                                if (!auxCant) {
                                    $('#mdc-menu__buscar_codigo_vendedor').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                                }
                            } else {
                                $('#mdc-menu__buscar_codigo_vendedor').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                            }
                        }
                    });

                    // Restablece el valor por defecto en el campo de vendedor al quitar el foco del campo
                    $('#mdc-codigo_vendedor input').blur(function() {
                        if(!$('#mdc-menu__buscar_codigo_vendedor').hasClass('mdc-menu-surface--open')) {
                            codigo_vendedor.value = vendedorDef;
                        }
                        if (vendedorDef == '' || vendedorDef == null) {
                            $('#clear-codigo_vendedor').hide();
                        } else {
                            $('#clear-codigo_vendedor').show();
                        }
                    });

                    // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
                    $('#mdc-codigo_vendedor input').keydown(function(e) {
                        if (e.key === 'Enter' || e.keyCode === 13) {
                            e.preventDefault();
                            if ($('#mdc-menu__buscar_codigo_vendedor').hasClass('mdc-menu-surface--open')) {
                                let index = $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').first().data('index');
                                let value = $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').first().data('value');
                                seleccionarVendedor(index, value);
                            }
                        } else if (e.key === 'Down' || e.keyCode === 40) {
                            e.preventDefault();
                            if ($('#mdc-menu__buscar_codigo_vendedor').hasClass('mdc-menu-surface--open')) {
                                let index = $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').first().data('index');
                                let value = $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').first().data('value');
                                if (index != undefined || index != null) {
                                    $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').first().focus();
                                }
                            }
                        } else if (e.key === 'Up' || e.keyCode === 38) {
                            e.preventDefault();
                            if ($('#mdc-menu__buscar_codigo_vendedor').hasClass('mdc-menu-surface--open')) {
                                let index = $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').last().data('index');
                                let value = $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').last().data('value');
                                if (index != undefined || index != null) {
                                    $('#mdc-menu__buscar_codigo_vendedor .mdc-list-item').last().focus();
                                }
                            }
                        } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                            e.preventDefault();
                            codigo_vendedor.value = vendedorDef;
                            $('#mdc-codigo_vendedor input').blur();
                            $('#mdc-menu__buscar_codigo_vendedor').removeClass('mdc-menu-surface--open');
                            if (vendedorDef == '' || vendedorDef == null) {
                                $('#clear-codigo_vendedor').hide();
                            } else {
                                $('#clear-codigo_vendedor').show();
                            }
                        }
                        if (vendedorDef == '' || vendedorDef == null) {
                            $('#clear-codigo_vendedor').hide();
                        } else {
                            $('#clear-codigo_vendedor').show();
                        }
                    });

                    // Selecciona el vendedor en el cual se hace click
                    $('#mdc-menu__buscar_codigo_vendedor').on('click', '.mdc-list-item', function() {
                        let value = $(this).data('value');
                        let index = $(this).data('index');
                        seleccionarVendedor(index, value);
                    });

                    // Selecciona el primer vendedor de la lista, en caso de que se oprima Enter mientras el foco está en el input
                    $('#mdc-menu__buscar_codigo_vendedor').on('keydown', '.mdc-list-item', function(e) {
                        if (e.key === 'Enter' || e.keyCode === 13) {
                            e.preventDefault();
                            let value = $(this).data('value');
                            let index = $(this).data('index');
                            seleccionarVendedor(index, value);
                        }
                    });

                    // Limpia el campo de vendedor, pero no altera el campo por defecto
                    $('#clear-codigo_vendedor').click(function() {
                        codigo_vendedor.value = '';
                        codigo_vendedor.valid = true;
                        $(this).hide();
                        $('#mdc-codigo_vendedor input').focus();
                    });

                    // Selecciona el vendedor con base en el index del listado y el id
                    async function seleccionarVendedor(index, value) {
                        if (index === undefined || index === null) {
                            codigo_vendedor.value = vendedorDef;
                        } else {
                            let auxVendedor = vendedores[index];
                            vendedorDef = auxVendedor.codigo_vendedor +' - '+ auxVendedor.nombres +' '+ auxVendedor.apellidos;
                            $('#codigo_vendedor').val(value);
                            codigo_vendedor.value = vendedorDef;
                            if ($('#mdc-codigo_vendedor input').val() != auxVendedor.codigo_vendedor) {
                                $('#datos_cliente').hide();
                                $('#id_cliente').val('');
                                let centrosDist = await buscarCops();
                                if (centrosDist) {
                                    $('#mdc-menu-cop .mdc-list').empty();
                                    for (let index = 0; index < centrosDist.length; index++) {
                                        const cop = centrosDist[index];
                                        $('#mdc-menu-cop .mdc-list').append('<li class="mdc-list-item" data-value="' +cop.cop+ '" role="option" tabindex="-1"><span class="mdc-list-item__text">' +cop.nombre.charAt(0).toUpperCase() + cop.nombre.toLowerCase().slice(1)+ '</span></li>');
                                    }
                                    selectCop.value = '';
                                    selectCop.selectedIndex = -1;
                                    selectCop = new mdc.select.MDCSelect(document.querySelector('#mdc-select__cop'));
                                    selectCop.listen('MDCSelect:change', (el) => {
                                        $('#cop').val(selectCop.value);
                                    });
                                }
                            }
                        }
                        $('#mdc-codigo_vendedor input').blur();
                        $('#mdc-menu__buscar_codigo_vendedor').removeClass('mdc-menu-surface--open');
                        if (vendedorDef == '' || vendedorDef == null) {
                            $('#clear-codigo_vendedor').hide();
                        } else {
                            $('#clear-codigo_vendedor').show();
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
                                codigo_vendedor.value = vendedorDef;
                            }
                        }
                    }, false);

                    // Ajusta el desplazamiento con flechas en los inputs de autocompletado
                    $('.mdc-menu.mdc-menu--autocomplete').on('keydown', '.mdc-list-item', function(e) {
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
                            $('#mdc-menu__buscar_codigo_vendedor').removeClass('mdc-menu-surface--open');
                            codigo_vendedor.value = vendedorDef;
                        }
                    });
                }

                async function buscarCops() {
                    return $.ajax({
                        'url': urlBuscarCentrosDist.replace('null', $('#codigo_vendedor').val()),
                        'context': document.body
                    }).done(function(response) {
                        return response;
                    }).fail(function(error){
                        console.error(error);
                        return false;
                    });
                }
            @endif
        });
    </script>
@endsection

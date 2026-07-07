@extends('layouts.app')

@section('content')
    @php
        setlocale(LC_ALL, 'es_ES', 'es', 'ES');
    @endphp
    <form action="{{ route('pedidos.semanalescf.store') }}" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h1 class="title">Pedido Semanal Carnes Frías</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('pedidos.semanales.index') }}" class="breadcrumb">Pedidos Semanales</a>
                        <a class="breadcrumb">Carnes Frías Nuevo</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 right-align hide-on-small-only">
                    <a href="{{ route('pedidos.semanales.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="enviar_pedido" type="submit">
                        <span class="mdc-button__label mr-1">Crear Pedido</span>
                        <i class="fas fa-tags"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted">
                        <div class="card-content center">
                            <span class="card-title highlighted center mb-1 uppercase">Gracias Por Diligenciar el Pedido Semanal de Carnes Frías</span>
                            <span class="card-subtitle subtitle-2 highlighted mb-0">Recuerde que debe ser finalizado antes del {{ $limite->formatLocalized("%A %d de %B del %Y") }} a las 3:00 p.m.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12 relative">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-1">Configuración Inicial</span>
                            <div class="row mb-0">
                                <div class="col s6 m3 l2 mt-1">
                                    <label>Planta</label>
                                    <div class="mdc-select mdc-select--outlined mdc-select--superdense mdc-select--no-label mdc-select--required" id="mdc-cop">
                                        <input type="text" name="cop" id="cop" class="mdc-select__input-value" value="{{ $usuario->plantas->count() ? $usuario->plantas[0]->cop : '' }}">
                                        <div class="mdc-select__anchor" aria-required="true">
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
                                                @foreach ($usuario->plantas as $key => $planta)
                                                    <li class="mdc-list-item {{ $key == 0 ? 'mdc-list-item--selected' : '' }}" data-value="{{ $planta->cop }}" id="unmed_producto_add_kg" role="option" {{ $key == 0 ? 'aria-selected="true"' : '' }}>
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ $planta->cop. ' - ' .str_replace('PEDIDO SEMANAL ', '', str_replace('PLANTA ', '', $planta->nombre)) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6 m3 l2 mt-1">
                                    <label>Año de Pedido</label>
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label" id="mdc-ano" style="display: block;">
                                        <input class="mdc-text-field__input ano_pedido" type="number" aria-labelledby="my-label-id" name="ano" value="{{ $semana->year }}" readonly required>
                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s6 m3 l2 mt-1">
                                    <label>Semana</label>
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label" id="mdc-semana" style="display: block;">
                                        <input class="mdc-text-field__input semana_pedido" type="number" aria-labelledby="my-label-id" name="semana" value="{{ $semana->weekOfYear }}" readonly required>
                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s6 m3 l2 mt-1">
                                    <label>Vendedor</label>
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--superdense mdc-text-field--no-label" id="mdc-codigo_vendedor" style="display: block;">
                                        <input class="mdc-text-field__input codigo_vendedor_pedido" type="text" aria-labelledby="my-label-id" name="codigo_vendedor" value="{{ $usuario->codigo_vendedor }}" readonly required>
                                        <span class="mdc-notched-outline mdc-notched-outline--no-label">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col s12 l4 mt-1">
                                    {{-- <div class="mdc-touch-target-wrapper">
                                        <div class="mdc-checkbox mdc-checkbox--touch" id="mdc_productos">
                                            <input type="checkbox" class="mdc-checkbox__native-control" id="productos" name="productos" checked="true"/>
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                            <div class="mdc-checkbox__ripple"></div>
                                        </div>
                                        <label id="mdc_productos_lbl" for="productos" class="noselect nowrap">Cargar productos del pedido anterior</label>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('pedidos.semanales.index')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="crear_pedido_mv" type="submit">
                        <span class="mdc-button__label mr-1">Crear Pedido</span>
                        <i class="fas fa-tags"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="cargando noselect px-5 center" id="guardando" style="display: none">
        <div id="html-spinner"></div>
        <span class="title mt-1">Creando Pedido Semanal</span>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Activa la sección en la barra lateral
            $('#pedidos-semanales').addClass('mdc-list-item--active');

            // Inicializa los inputs de Material.io
            const cop = new mdc.select.MDCSelect(document.querySelector('#mdc-cop'));
            const ano = new mdc.textField.MDCTextField(document.querySelector('#mdc-ano'));
            const semana = new mdc.textField.MDCTextField(document.querySelector('#mdc-semana'));
            const codigo_vendedor = new mdc.textField.MDCTextField(document.querySelector('#mdc-codigo_vendedor'));

            // Asigna la fecha de entrega mínima para el siguiente día
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

            var clientesListado = [];
            var clientePedido = [];
            var urlBuscar = '{!! route('ajax.clientes.buscar', ['busqueda' => 'null']) !!}';
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
                    console.log(clientePedido);
                    $('#mdc-menu__buscar_cliente').removeClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_cliente').empty();
                    $('#buscar_cliente input').val('');
                    $('#id_cliente').val(cliente.id_cliente);
                    $('#datos_cliente_nombre').text(cliente.nombre_cliente.toLowerCase());
                    $('#datos_cliente_lista').text(cliente.lista_precio);
                    $('#datos_cliente_cc_nit').text(cliente.cc_nit);
                    $('#datos_cliente_direccion').text((cliente.direccion +' - '+ cliente.ciudad).toLowerCase());
                    // Limpia la cedula y deja solo el numero
                    let nuevoNumero = cliente.cupo.toString();
                    value = '';
                    // It puts a . every 3 chars
                    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i-- , j++) {
                        value = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 === 0) ? "." : "") + value;
                    }
                    $('#datos_cliente_cupo').text('$ ' + value);

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
                var urlBuscar2 = urlBuscar.replace('null', busqueda);
                console.log(urlBuscar2);
                $('#mdc-menu__buscar_cliente').addClass('mdc-menu-surface--open');
                $('#mdc-menu__buscar_cliente').empty();
                $('#mdc-menu__buscar_cliente').append('<li class="mdc-list-item" role="option"><span class="mdc-list-item__text">Buscando</span></li>');
                $.ajax({
                    'url': urlBuscar2,
                    'context': document.body
                }).done(function(response) {
                    $('#mdc-menu__buscar_cliente').empty();
                    var clientes = response.clientes;
                    clientesListado = response.clientes;
                    if(clientes.length) {
                        for (let index = 0; index < clientes.length; index++) {
                            const cliente = clientes[index];
                            $('#mdc-menu__buscar_cliente').append('<li tabindex="0" class="mdc-list-item" data-index="'+ index +'" role="option"><span class="mdc-list-item__text capitalize">'+ cliente.cc_nit +' - '+ cliente.nombre_cliente.toLowerCase() +'</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_cliente').append('<li class="mdc-list-item mdc-list-item--cliente" role="option"><span class="mdc-list-item__text">No hay clientes</span></li>');
                    }
                });
            }

            // Valida el formulario antes de enviarlo
            const validar = async function() {
                let errors = 0;

                // Validación del campo cop
                if (!cop.valid || cop.value == null || cop.value == '') {
                    cop.valid = false;
                    M.toast({html: '<span class="mr-3">Error en la planta del usuario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    errors++;
                }

                // Validación del campo de año
                if (!ano.valid || ano.value == null || ano.value == '') {
                    ano.valid = false;
                    M.toast({html: '<span class="mr-3">Error en el año.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    errors++;
                }

                // Validación del campo de semana
                if (!semana.valid || semana.value == null || semana.value == '') {
                    semana.valid = false;
                    M.toast({html: '<span class="mr-3">Error en la semana.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    errors++;
                }

                // Validación del campo de código de vendedor
                if (!codigo_vendedor.valid || codigo_vendedor.value == null || codigo_vendedor.value == '') {
                    codigo_vendedor.valid = false;
                    M.toast({html: '<span class="mr-3">Error en el código de vendedor.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    errors++;
                }

                if (errors)
                    return false;

                return true;
            }

            // Ejecuta la función de validación antes de enviar el formulario
            $('.enviar_pedido').on('click', async function(e) {
                $('#guardando').show();
                $('body').css('overflow', 'hidden');
                $(this).attr('disabled', 'disabled');
                e.preventDefault();
                let validacion = await validar();
                if (validacion) {
                    $('#estado').val(1);
                    $('form').submit();
                } else {
                    $('#guardando').hide();
                    $('body').css('overflow', '');
                    $(this).removeAttr('disabled');
                }
            });
        });
    </script>
@endsection

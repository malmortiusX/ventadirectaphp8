@php
    $empresa = \App\Models\TblEmpresa::first();
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', $empresa->nombre) }}</title>
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/materialize/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/material.io/material-components-web.min.css') }}">
    @yield('styles')
    <link href="{{ asset('css/styles.css') }}?1.1.1" rel="stylesheet">
    <link href="{{ asset('vendor/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --mdc-theme-primary: {{ $empresa->color }};
            --mdc-theme-primary-rgb: {{ $empresa->color_rgb }};
            --mdc-theme-secondary: {{ $empresa->color2 }};
            --mdc-theme-secondary-rgb: {{ $empresa->color2_rgb }};
        }
        .col-firma .wrapper {
            position: relative;
            max-width: 400px;
            width: 100%;
            height: 200px;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .col-firma img {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .col-firma .signature-pad {
            position: absolute;
            left: 0;
            top: 0;
            max-width: 400px;
            width: 100%;
            height: 200px;
            border: solid 1px rgba(0,0,0,.38);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <main class="main-content container-full" id="main-content" style="max-width: inherit;">
        <section class="div-main">
            <form action="{{ route('clientes.externos.empresarios') }}" method="POST" id="form"accept-charset="UTF-8">
                @csrf
                <input type="hidden" class="hide" name="ciudad_expedicion_empresaria" id="ciudad_expedicion_empresaria">
                <input type="hidden" class="hide" name="ciudad_empresaria" id="ciudad_empresaria">
                <input type="hidden" class="hide" name="ciudad_referenciador" id="ciudad_referenciador">
                <input type="hidden" class="hide" name="firma_empresaria" id="firma_empresaria">
                <input type="hidden" class="hide" name="cop" id="cop" value="49901">
                <div class="container">
                    <div class="row">
                        <div class="col s12 center hide-on-med-and-up">
                            <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo">
                        </div>
                        <div class="col s12 m6">
                            <h1 class="title">FORMULARIO DE INSCRIPCIÓN</h1>
                            <div class="breadcrumbs full-width">
                                <a class="breadcrumb">EMPRESARIOS AVICAMPO</a>
                            </div>
                        </div>
                        <div class="col m6 hide-on-small-only pr-5" style ="text-align: right;">
                            <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo mb-0">
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12">
                            <div class="card highlighted mt-0">
                                <div class="card-content">
                                    <span class="card-title mb-3">Datos del empresario</span>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombres_empresaria">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombres_empresaria" name="nombres_empresaria" id="nombres_empresaria" required maxlength="30" value="{{ isset($cliente) ? $cliente->nombre_cliente : "" }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombres_empresaria">Nombres</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 30</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-apellidos_empresaria">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_apellidos_empresaria" name="apellidos_empresaria" id="apellidos_empresaria" required maxlength="30" value="{{ isset($cliente) ? $cliente->nombre_cliente : "" }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_apellidos_empresaria">Apellidos</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 30</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-4">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-fecha_nacimiento_empresaria">
                                                <input type="date" class="mdc-text-field__input uppercase" aria-labelledby="lbl_fecha_nacimiento_empresaria" name="fecha_nacimiento_empresaria" id="fecha_nacimiento_empresaria" required>
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_fecha_nacimiento_empresaria">Fecha de Nacimiento</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-cedula_empresaria">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_cedula_empresaria" name="cedula_empresaria" id="cedula_empresaria" required maxlength="15">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_cedula_empresaria">Cédula</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 15</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion_empresaria">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion_empresaria" name="direccion_empresaria" id="direccion_empresaria" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion_empresaria">Dirección</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 100</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-barrio_empresaria">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_barrio_empresaria" name="barrio_empresaria" id="barrio_empresaria" required maxlength="50">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_barrio_empresaria">Barrio</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 50</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-ciudad_empresaria">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_ciudad_empresaria">Ciudad</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                                <input type="text" class="mdc-text-field__input" data-input="ciudad_empresaria" aria-labelledby="lbl_ciudad_empresaria" autocomplete="off" required>
                                                <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                                <span id="clear-ciudad_empresaria" class="form-clear d-none mdc-icon-clear" style="display: none">
                                                    <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-ciudad_empresaria" aria-hidden="true"></div>
                                            </div>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_ciudad_empresaria">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono_empresaria">
                                                <input type="tel" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono_empresaria" name="telefono_empresaria" id="telefono_empresaria" required max="9999999999" min="0" maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono_empresaria">Teléfono</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 10</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-correo_empresaria">
                                                <input type="email" class="mdc-text-field__input uppercase" aria-labelledby="lbl_correo_empresaria" name="correo_empresaria" id="correo_empresaria" required maxlength="50">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_correo_empresaria">Correo Electrónico</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 50</div>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col s12 mb-1">
                                            <div class="mdc-form-field">
                                                <div class="mdc-checkbox mdc-checkbox--touch pl-0">
                                                    <input type="checkbox" class="mdc-checkbox__native-control" id="autorizoHabeasData"/>
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                    <div class="mdc-checkbox__ripple"></div>
                                                </div>
                                                <label for="autorizoHabeasData" class="ml-1 noselect nowrap" style="white-space: pre-line;">Autorizo el uso de mis datos personales. <a target="_blank" href="https://www.navicampo.com/habeasData/">Clic aquí para ver habeas data.</a></label>
                                            </div>
                                            <div class="mdc-form-field">
                                                <div class="mdc-checkbox mdc-checkbox--touch pl-0">
                                                    <input type="checkbox" class="mdc-checkbox__native-control" id="aceptoEmpresarias"/>
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                    <div class="mdc-checkbox__ripple"></div>
                                                </div>
                                                <label for="aceptoEmpresarias" class="ml-1 noselect nowrap" style="white-space: pre-line;">Acepto los términos y condiciones - Empresarios Avicampo. <a target="_blank" href="https://www.navicampo.com/terminosYcondiciones/">Clic aquí para ver los terminos y condiciones</a></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12">
                            <button class="mdc-button mdc-button--raised mdc-button--large crear_cliente" type="submit">
                                <span class="mdc-button__label mr-1">{{ isset($cliente) ? "Actualizar" : "Crear" }} Empresario</span>
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="cargando noselect px-5 center" id="guardando" style="display: none">
                <div id="html-spinner"></div>
                <span class="title mt-1">Creando Vendedor</span>
            </div>
        </section>
        <footer>
            <div class="row mb-0">
                <div class="col s12 m6">
                    <Label>Copyright © {{ date('Y') }} | <a class="link" style="color: var(--mdc-theme-secondary);" href="https://avicolaelmadrono.com/" target="_blank">Avicola El Madroño S.A.</a></Label>
                </div>
                <div class="col s12 m6 right-align">
                    <Label>Sistema de Pedidos Madroño Móvil</Label>
                </div>
            </div>
        </footer>
    </main>
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendor/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('vendor/material.io/material-components-web.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2@10.js') }}"></script>
    <script src="{{ asset('vendor/signature_pad/signature_pad.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.modal').modal();
        });

        // Declaración de urls a utilizar
        const urlValidarVendedorVD = '{!! route('ajax.clientes.validarVendedorVD', ['documento_vendedorVD' => 'documento']) !!}';

        // Declaración de elementos de material.io (Mismo orden en el que se renderizan)
        const nombres_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombres_empresaria'));
        const apellidos_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-apellidos_empresaria'));
        const fecha_nacimiento_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_nacimiento_empresaria'));
        const cedula_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-cedula_empresaria'));
        const direccion_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_empresaria'));
        const ciudad_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-ciudad_empresaria'));
        const barrio_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-barrio_empresaria'));
        const telefono_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_empresaria'));
        const correo_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-correo_empresaria'));

        // Variables
        var ciudades = @json($ciudades);    // Listado de ciudades
        var ciudadDef = '';
        var ciudadExpDef = '';
        var ciudadRefDef = '';



        /**
            Acciones para Input de ciudad
            20/01/2021
        **/
        {
            // Busca los primeros 10 valores del listado de ciudades que concuerden con lo ingresado en el input
            $('#mdc-ciudad_empresaria input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                if(busqueda){
                    $('#clear-ciudad_empresaria').show();
                    $('#mdc-menu__buscar_ciudad_empresaria').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_ciudad_empresaria').empty();
                    if (ciudades.length) {
                        let auxCant = 0;
                        for (let index = 0; index < ciudades.length; index++) {
                            const auxCiudad = ciudades[index];
                            // Se configura para que no tenga en cuenta las tildes
                            if (auxCiudad.ciudad.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
                                auxCant++;
                                if (auxCiudad.id_ciudad == $('#ciudad_empresaria').val()) {
                                    $('#mdc-menu__buscar_ciudad_empresaria').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxCiudad.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudad.ciudad +'</span></li>');
                                } else {
                                    $('#mdc-menu__buscar_ciudad_empresaria').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxCiudad.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudad.ciudad +'</span></li>');
                                }
                            }
                            if (auxCant == 10) {
                                break;
                            }
                        }
                        if (!auxCant) {
                            $('#mdc-menu__buscar_ciudad_empresaria').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_ciudad_empresaria').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                    }
                }
            });

            // Restablece el valor por defecto en el compo de ciudad al quitar el foco del campo
            $('#mdc-ciudad_empresaria input').blur(function() {
                    $('#clear-ciudad_empresaria').show();
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
            $('#mdc-ciudad_empresaria input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_empresaria').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').first().data('value');
                        seleccionarCiudad(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_empresaria').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_empresaria').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_empresaria .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    ciudad.value = ciudadDef;
                    $('#mdc-ciudad_empresaria input').blur();
                    $('#mdc-menu__buscar_ciudad_empresaria').removeClass('mdc-menu-surface--open');
                    if (ciudadDef == '' || ciudadDef == null) {
                        $('#clear-ciudad_empresaria').hide();
                    } else {
                        $('#clear-ciudad_empresaria').show();
                    }
                }

                $('#clear-ciudad_empresaria').show();

            });

            // Selecciona la ciudad en la cual se hace click
            $('#mdc-menu__buscar_ciudad_empresaria').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarCiudad(index, value);
            });

            // Selecciona la primer ciudad de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_ciudad_empresaria').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarCiudad(index, value);
                }
            });

            // Limpia el campo de ciudad, pero no altera el campo por defecto
            $('#clear-ciudad_empresaria').click(function() {
                ciudad_empresaria.value = '';
                ciudad_empresaria.valid = true;
                $(this).hide();
                $('#mdc-ciudad_empresaria input').focus();
            });

            // Selecciona la ciudad con base en el index del listado y el id
            function seleccionarCiudad(index, value) {
                if (index === undefined || index === null) {
                    ciudad_empresaria.value = ciudadDef;
                } else {
                    let auxCiudad = ciudades[index];
                    ciudadDef = auxCiudad.ciudad;
                    $('#ciudad_empresaria').val(value);
                    ciudad_empresaria.value = ciudadDef;
                }
                $('#mdc-ciudad_empresaria input').blur();
                $('#mdc-menu__buscar_ciudad_empresaria').removeClass('mdc-menu-surface--open');
                if (ciudadDef == '' || ciudadDef == null) {
                    $('#clear-ciudad_empresaria').hide();
                } else {
                    $('#clear-ciudad_empresaria').show();
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
                        ciudad_expedicion_empresaria.value = ciudadExpDef;
                        ciudad_empresaria.value = ciudadDef;
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
                    $('#mdc-menu__buscar_ciudad').removeClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_ciudad_exp').removeClass('mdc-menu-surface--open');
                    ciudad.value = ciudadDef;
                    ciudadExp.value = ciudadExpDef;
                }
            });

            const validarVendedorVD = async function() {
                let url = urlValidarVendedorVD.replace('documento', cedula_empresaria.value);
                const validacion = await $.ajax({
                    method: 'GET',
                    url: url,
                    context: document.body
                }).done(function(response) {
                    return response;
                }).fail(function(error) {
                    console.error(error);
                    return false;
                });
                return validacion;
            }

            // Valida el formulario antes de enviarlo
            const validar = async function() {
                if (!nombres_empresaria.valid || nombres_empresaria.value == null || nombres_empresaria.value == '') {
                    nombres_empresaria.valid = false;
                    nombres_empresaria.helperTextContent = 'Ingrese los nombres del empresario.';
                    M.toast({html: '<span class="mr-3">Error en los nombres del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!apellidos_empresaria.valid || apellidos_empresaria.value == null || apellidos_empresaria.value == '') {
                    apellidos_empresaria.valid = false;
                    apellidos_empresaria.helperTextContent = 'Ingrese los apellidos del empresario.';
                    M.toast({html: '<span class="mr-3">Error en los apellidos del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    $('#apellidos_empresaria').focus();
                    return false;
                }
                if (!fecha_nacimiento_empresaria.valid || fecha_nacimiento_empresaria.value == null || fecha_nacimiento_empresaria.value == '') {
                    fecha_nacimiento_empresaria.valid = false;
                    fecha_nacimiento_empresaria.helperTextContent = 'Ingrese la fecha de nacimiento del empresario.';
                    M.toast({html: '<span class="mr-3">Error en la fecha de nacimiento de la emprearia.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!cedula_empresaria.valid || cedula_empresaria.value == null || cedula_empresaria.value == '') {
                    cedula_empresaria.valid = false;
                    cedula_empresaria.helperTextContent = 'Ingrese la cédula del empresario.';
                    M.toast({html: '<span class="mr-3">Error en la cédula del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion_empresaria.valid || direccion_empresaria.value == null || direccion_empresaria.value == '') {
                    direccion_empresaria.valid = false;
                    direccion_empresaria.helperTextContent = 'Ingrese la dirección del empresario.';
                    M.toast({html: '<span class="mr-3">Error en la dirección del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!barrio_empresaria.valid || barrio_empresaria.value == null || barrio_empresaria.value == '') {
                    barrio_empresaria.valid = false;
                    barrio_empresaria.helperTextContent = 'Ingrese el barrio del empresario.';
                    M.toast({html: '<span class="mr-3">Error en el barrio del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!ciudad_empresaria.valid || ciudad_empresaria.value == null || ciudad_empresaria.value == '' || $('#ciudad_empresaria').val() == null || $('#ciudad_empresaria').val() == '') {
                    ciudad_empresaria.valid = false;
                    ciudad_empresaria.helperTextContent = 'Seleccione la ciudad del empresario.';
                    M.toast({html: '<span class="mr-3">Error en la ciudad del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono_empresaria.valid || telefono_empresaria.value == null || telefono_empresaria.value == '') {
                    telefono_empresaria.valid = false;
                    telefono_empresaria.helperTextContent = 'Ingrese el teléfono del empresario.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!correo_empresaria.valid || correo_empresaria.value == null || correo_empresaria.value == '') {
                    correo_empresaria.valid = false;
                    correo_empresaria.helperTextContent = 'Ingrese el correo del empresario.';
                    M.toast({html: '<span class="mr-3">Error en el correo del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }


                if (!$('#autorizoHabeasData').is(':checked')) {
                    M.toast({html: '<span class="mr-3">Por favor, debe autorizar el uso de sus datos personales.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    $('#autorizoHabeasData').focus();
                    return false;
                }
                if (!$('#aceptoEmpresarias').is(':checked')) {
                    M.toast({html: '<span class="mr-3">Por favor acepte los términos y condiciones (empresarias).</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    $('#aceptoEmpresarias').focus();
                    return false;
                }

                let validacionVendedorVD = await validarVendedorVD();

                if (validacionVendedorVD.vendedor) {
                    console.log(validacionVendedorVD.vendedor);
                    Swal.fire({
                        title: 'El usuario ya existe',
                        text: 'El documento ' +validacionVendedorVD.vendedor.documento+ ' se encuentra registrado con el nombre ' +validacionVendedorVD.vendedor.nombres.toUpperCase()+ ' ' + validacionVendedorVD.vendedor.apellidos.toUpperCase()+ '.',
                        icon: 'error'
                    });
                    return false;
                }

                return true;
            }

            // Ejecuta la función de validación antes de enviar el formulario
            $('.crear_cliente').on('click', async function(e) {
                $('#guardando').show();
                $('body').css('overflow', 'hidden');
                $(this).attr('disabled', 'disabled');
                e.preventDefault();
                let validacion = await validar();
                if (validacion) {
                    $('#form').submit();
                } else {
                    $('#guardando').hide();
                    $('body').css('overflow', '');
                    $(this).removeAttr('disabled');
                }
            });
        }

        /**
            Aviso de cliente creado exitosamente
            05/05/2021
        **/
        @if (Session::has('usuario_creado'))
            let dataSession = JSON.parse('{!! Session::get('usuario_creado') !!}');
            @php
                Session::flush();
            @endphp
            Swal.fire({
                html: 'Tome nota de las siguientes credenciales para el ingreso en la plataforma de pedidos.<br><b>Usuario:</b> ' + dataSession.codigo_vendedor + '<br><b>Contraseña:</b> ' + dataSession.documento,
                title: '¡Registro exitoso!',
                text: 'Usuario: ' + dataSession.codigo_vendedor + '<br>Contraseña: ' + dataSession.documento + '.',
                icon: 'success',
                onClose: goToHome
            });
        @elseif (Session::has('usuario_actualizado'))
            let dataSession = JSON.parse('{!! Session::get('usuario_actualizado') !!}');
            @php
                Session::flush();
            @endphp
            Swal.fire({
                title: 'Empresario actualizado con éxito',
                text: 'El empresario con documento ' + dataSession.documento + ' y nombre ' + dataSession.nombres + dataSession.apellidos + ' se ha actualizado exitosamente.',
                icon: 'success',
                onClose: goToHome
            });

        @endif

        function goToHome() {
            window.location.href='https://www.avicampo.shop/mmovil/avicampo/dashboard';
            // window.location.href='http://ventadirecta.test/dashboard';
        }
    </script>
</body>
</html>

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
        .dropify-wrapper {
            height: 110px;
        }
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
            <form action="{{ route('clientes.store.pdv') }}" method="POST" id="form" enctype="multipart/form-data" files="true">
                @csrf
                <input type="hidden" class="hide" name="ciudad" id="ciudad">
                <input type="hidden" class="hide" name="ciudad_exp" id="ciudad_exp">
                <input type="hidden" class="hide" name="firma" id="firma">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6">
                            <h1 class="title">Nuevo Cliente</h1>
                            <div class="breadcrumbs full-width">
                                <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                                {{-- <a href="{{ route('pedidos.index') }}" class="breadcrumb">Pedidos</a> --}}
                                <a class="breadcrumb">Nuevo Cliente</a>
                            </div>
                        </div>
                        <div class="col m6 right-align hide-on-small-only">
                            <button class="mdc-button mdc-button--raised mdc-button--large crear_cliente" type="submit">
                                <span class="mdc-button__label mr-1">Crear Cliente</span>
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12">
                            <div class="card highlighted mt-0">
                                <div class="card-content">
                                    <span class="card-title mb-3">1. Datos del cliente</span>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombres">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombres" name="nombres" id="nombres" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombres">Nombres</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-apellidos">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_apellidos" name="apellidos" id="apellidos" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_apellidos">Apellidos</span>
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
                                            <div class="mdc-select mdc-select--outlined mdc-select--dense mdc-select--required focusable" id="mdc-select__tipo_documento">
                                                <div class="mdc-select__anchor" aria-required="true" aria-labelledby="tipo_documento-select-label">
                                                    <input type="text" name="tipo_documento" id="tipo_documento" class="mdc-select__input-value" value="">
                                                    <span id="tipo_documento__selected-text" class="mdc-select__selected-text capitalize"></span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
                                                    </span>
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span id="tipo_documento-select-label" class="mdc-floating-label">Tipo de Documento</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                </div>
                                                <!-- Other elements from the select remain. -->
                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                                    <ul class="mdc-list">
                                                        <li class="mdc-list-item" data-value="CC" role="option">
                                                            <span class="mdc-list-item__ripple"></span>
                                                            <span class="mdc-list-item__text">CC</span>
                                                        </li>
                                                        <li class="mdc-list-item" data-value="CE" role="option">
                                                            <span class="mdc-list-item__ripple"></span>
                                                            <span class="mdc-list-item__text">CE</span>
                                                        </li>
                                                        <li class="mdc-list-item" data-value="PEP" role="option">
                                                            <span class="mdc-list-item__ripple"></span>
                                                            <span class="mdc-list-item__text">PEP</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-tipo_documento" aria-hidden="true"></div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-codigo_cli">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_codigo_cli" name="codigo_cli" id="codigo_cli" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_codigo_cli">Número de Documento</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-ciudad_exp">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_ciudad_exp">Ciudad Expedición Documento</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                                <input type="text" class="mdc-text-field__input" data-input="ciudad_exp" aria-labelledby="lbl_ciudad_exp" autocomplete="off" required>
                                                <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                                <span id="clear-ciudad_exp" class="form-clear d-none mdc-icon-clear" style="display: none">
                                                    <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-ciudad_exp" aria-hidden="true"></div>
                                            </div>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_ciudad_exp">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono">
                                                <input type="number" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono" name="telefono" id="telefono" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono">Teléfono</span>
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
                                            <div class="mdc-select mdc-select--outlined mdc-select--dense focusable" id="mdc-select__genero">
                                                <div class="mdc-select__anchor" aria-labelledby="genero-select-label">
                                                    <input type="text" name="genero" id="genero" class="mdc-select__input-value" value="">
                                                    <span id="genero__selected-text" class="mdc-select__selected-text capitalize"></span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
                                                    </span>
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span id="genero-select-label" class="mdc-floating-label">Género</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                </div>
                                                <!-- Other elements from the select remain. -->
                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                                    <ul class="mdc-list">
                                                        <li class="mdc-list-item" data-value="M" role="option">
                                                            <span class="mdc-list-item__ripple"></span>
                                                            <span class="mdc-list-item__text">M</span>
                                                        </li>
                                                        <li class="mdc-list-item" data-value="F" role="option">
                                                            <span class="mdc-list-item__ripple"></span>
                                                            <span class="mdc-list-item__text">F</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-tipo_documento" aria-hidden="true"></div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-fecha_nacimiento">
                                                <input type="date" class="mdc-text-field__input uppercase" aria-labelledby="lbl_fecha_nacimiento" name="fecha_nacimiento" id="fecha_nacimiento" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_fecha_nacimiento">Fecha de Nacimiento</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion" name="direccion" id="direccion" required maxlength="90">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion">Dirección</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 90</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-barrio">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_barrio" name="barrio" id="barrio" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_barrio">Barrio</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-ciudad">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_ciudad">Ciudad</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                                <input type="text" class="mdc-text-field__input" data-input="ciudad" aria-labelledby="lbl_ciudad" autocomplete="off" required>
                                                <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                                <span id="clear-ciudad" class="form-clear d-none mdc-icon-clear" style="display: none">
                                                    <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-ciudad" aria-hidden="true"></div>
                                            </div>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_ciudad">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-correo">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_correo" name="correo" id="correo" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_correo">Correo Electrónico</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 100</div>
                                            </div>
                                        </div>
                                        {{-- <div class="col s12 m6 l4 mb-1">
                                            <div class="mdc-select mdc-select--outlined mdc-select--dense mdc-select--required focusable" id="mdc-select__id_tipo_cliente">
                                                <div class="mdc-select__anchor" aria-required="true" aria-labelledby="id_tipo_cliente-select-label">
                                                    <input type="text" name="id_tipo_cliente" id="id_tipo_cliente" class="mdc-select__input-value" value="">
                                                    <span id="id_tipo_cliente__selected-text" class="mdc-select__selected-text capitalize"></span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
                                                    </span>
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span id="id_tipo_cliente-select-label" class="mdc-floating-label">Segmento de Cliente</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                </div>
                                                <!-- Other elements from the select remain. -->
                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox">
                                                    <ul class="mdc-list">
                                                        @foreach ($tiposCliente as $tipoCli)
                                                            <li class="mdc-list-item" data-value="{{ $tipoCli->id_tipo_cliente }}" role="option">
                                                                <span class="mdc-list-item__ripple"></span>
                                                                <span class="mdc-list-item__text capitalize">{{ $tipoCli->clase .' - '. mb_strtolower($tipoCli->nombre_tipo_cliente) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-id_tipo_cliente" aria-hidden="true"></div>
                                            </div>
                                        </div> --}}
                                        <div class="col s12 mb-1">
                                            <label style="margin-left: 16px;">Dia en el que le gustaria que lo contacten</label>
                                            <div class="mdc-chip-set mdc-chip-set--filter mdc-chip-set--filter--nosvg mdc-chip-set-dense" role="grid" id="mdc-dias_visita">
                                                <div class="mdc-chip noselect" id="mdc-lu" role="row">
                                                    <input type="hidden" name="lu" id="lu" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="checkbox" tabindex="0" class="mdc-chip__primary-action">
                                                            <span class="mdc-chip__text">Lunes</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mdc-chip noselect" id="mdc-ma" role="row">
                                                    <input type="hidden" name="ma" id="ma" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="checkbox" tabindex="-1" class="mdc-chip__primary-action">
                                                            <span class="mdc-chip__text">Martes</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mdc-chip noselect" id="mdc-mi" role="row">
                                                    <input type="hidden" name="mi" id="mi" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Miércoles</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mdc-chip noselect" id="mdc-ju" role="row">
                                                    <input type="hidden" name="ju" id="ju" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Jueves</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mdc-chip noselect" id="mdc-vi" role="row">
                                                    <input type="hidden" name="vi" id="vi" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Viernes</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mdc-chip noselect" id="mdc-sa" role="row">
                                                    <input type="hidden" name="sa" id="sa" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Sábado</span>
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="mdc-chip noselect" id="mdc-do" role="row">
                                                    <input type="hidden" name="do" id="do" class="hide" value="0">
                                                    <div class="mdc-chip__ripple"></div>
                                                    <span role="gridcell">
                                                        <span role="button" tabindex="-1" class="mdc-chip__primary-action">
                                                        <span class="mdc-chip__text">Domingo</span>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 mt-2">
                                            <div class="justify mb-1">
                                                <p>Como titular de los datos y bajo los parámetros de la Ley 1581 de 2012 y las normas que la adicionen y/o modifiquen, Autorizo a AVÍCOLA EL MADROÑO S.A. a recolectar, almacenar, usar, circular, procesar, transferir, suprimir, actualizar, y disponer de los datos personales aquí solicitados para cumplir con el desarrollo normal de su objeto social y para dar cumplimiento a las obligaciones legales y contractuales de AVICOLA EL MADROÑO S.A. Sin perjuicio de lo anterior, los datos recolectados por AVÍCOLA EL MADROÑO S.A. son recolectados para las siguienes finalidades:</p>
                                                <ol style="list-style: upper-roman;">
                                                    <li>La Ejecución del contrato suscrito con cualquiera de la Compañía.</li>
                                                    <li>Pago de obligaciones contractuales.</li>
                                                    <li>Envío de información a entidades gubernamentales o judiciales por solicitud expresa de la misma.</li>
                                                    <li>Soporte en procesos de auditoria externa/interna.</li>
                                                    <li>Registro de la información de los empleados en la base de datos AVÍCOLA EL MADROÑO S.A.</li>
                                                    <li>Contacto con empleados para el envío de información relacionado con la relación contractual y obligacional que tenga lugar.</li>
                                                    <li>Recolección de datos para el cumplimiento de los deberes que como responsable de la información y datos personales, le corresponde AVÍCOLA EL MADROÑO S.A.</li>
                                                    <li>Con propósitos de seguridad o prevención de fraude.</li>
                                                    <li>Cualquier otra finalidad que resulte en el desarrollo del contrato o la relación entre usted Y AVÍCOLA EL MADROÑO S.A.</li>
                                                </ol>
                                                <p>Además, conozco mis derechos a conocer, actualizar y rectificar mis datos personales; Todo lo anterior, cumpliendo con lo establecido en la “Política de Tratamiento de Datos Personales”, la cual me ha sido informado y entiendo claramente, que puedo consultar en la página web <a href="https://avicolaelmadrono.com/" class="link color-primary" target="_blank">www.avicolaelmadrono.com</a>.</p>
                                                <br>
                                                <p class="color-error">Declaro bajo gravedad de juramento que los recursos  no provienen de actividades ilícitas, ni vinculadas con el cultivo, producción o tráfico de estupefacientes, ni actividades contempladas en el Código Penal Colombiano o en cualquier norma que lo modifique o adicione, dando cumplimiento a lo señalado en la Circular 100 - 000005 de Agosto 2016 expedida por la Superintendencia de Sociedades, el Estatuto Anticorrupción (Ley 190 de 1995).</p>
                                            </div>
                                            <div class="mdc-touch-target-wrapper">
                                                <div class="mdc-checkbox mdc-checkbox--touch pl-0">
                                                    <input type="checkbox" class="mdc-checkbox__native-control" id="acepto"/>
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                    <div class="mdc-checkbox__ripple"></div>
                                                </div>
                                                <label for="acepto" class="ml-1 noselect nowrap">Autorizo el uso de mis datos personales.</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col s12 m12 col-dropify mt-2">
                                            <label class="dropify-label">Cédula del Cliente</label>
                                            <input type="file" class="dropify" id="imagen_cedula" name="imagen_cedula" accept=".jpg,.jpeg,.png,.webp" data-allowed-file-extensions="jpg jpeg png webp"/>
                                        </div> --}}
                                        <div class="col s12 m12 mt-2 col-firma">
                                            <label style="margin-left: 16px;">Firma del cliente</label>
                                            <div class="wrapper">
                                                <img src="{{ asset('imagenes/backgrounds/firma.png') }}" width="100%" height=200 style="background-color:white;" />
                                                <canvas id="signature-pad" class="signature-pad" height=200></canvas>
                                            </div>
                                            <div>
                                                <button id="clear">Borrar Firma</button>
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
                                <span class="mdc-button__label mr-1">Crear Cliente</span>
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="cargando noselect px-5 center" id="guardando" style="display: none">
                <div id="html-spinner"></div>
                <span class="title mt-1">Guardando Cliente</span>
            </div>
        </section>
        <footer>
            <div class="row mb-0">
                <div class="col s12 m6">
                    <Label>Copyright © {{ date('Y') }} | <a class="link" style="color: var(--mdc-theme-secondary);" href="https://avicolaelmadrono.com/" target="_blank">Avicola El Madroño S.A.</a></Label>
                </div>
                <div class="col s12 m6 right-align">
                    <Label>Sistema de Pedidos Madroño Móvil | V 2.2.17</Label>
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
        $('#crear-clientes').addClass('mdc-list-item--active');

        // var imagen_cedula = $('.dropify').dropify({
        //     messages: {
        //         'default': 'Arrastra y suelta una imágen aquí o haz click',
        //         'replace': 'Arrastra y suelta una imágen o haz clic para reemplazar',
        //         'remove':  'Quitar Iimágen',
        //         'error':   'Ooops, hubo un error inesperado.',
        //     },
        //     error: {
        //         'fileSize': 'El tamaño de la imágen es demasiado grande.',
        //         'fileExtension': 'La extensión del archivo no es válida.',
        //     }
        // });

        var numDecimales = {{ $empresa->decimales }};

        // Declaración de urls a utilizar
        const urlClientesValidarCliente = '{!! route('ajax.clientes.validarCliente', ['codigo_cli' => 'codigo_cli', 'sucursal' => 'sucursal']) !!}';

        // Declaración de elementos de material.io (Mismo orden en el que se renderizan)
        const nombres = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombres'));
        const apellidos = new mdc.textField.MDCTextField(document.querySelector('#mdc-apellidos'));
        const tipoDocumento = new mdc.select.MDCSelect(document.querySelector('#mdc-select__tipo_documento'));
        const tipoDocumentoHelper = new mdc.select.MDCSelectHelperText(document.querySelector('#mdc-helper-tipo_documento'));
        const genero = new mdc.select.MDCSelect(document.querySelector('#mdc-select__genero'));
        const generoHelper = new mdc.select.MDCSelectHelperText(document.querySelector('#mdc-helper-genero'));
        const telefono = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono'));
        const fechaNacimiento = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_nacimiento'));
        const codigoCli = new mdc.textField.MDCTextField(document.querySelector('#mdc-codigo_cli'));
        const ciudadExp = new mdc.textField.MDCTextField(document.querySelector('#mdc-ciudad_exp'));
        // const establecimiento = new mdc.textField.MDCTextField(document.querySelector('#mdc-establecimiento'));
        const direccion = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion'));
        const barrio = new mdc.textField.MDCTextField(document.querySelector('#mdc-barrio'));
        const ciudad = new mdc.textField.MDCTextField(document.querySelector('#mdc-ciudad'));
        const correo = new mdc.textField.MDCTextField(document.querySelector('#mdc-correo'));
        // const idTipoCliente = new mdc.select.MDCSelect(document.querySelector('#mdc-select__id_tipo_cliente'));
        // const idTipoClienteHelper = new mdc.select.MDCSelectHelperText(document.querySelector('#mdc-helper-id_tipo_cliente'));
        const diasVisita = new mdc.chips.MDCChipSet(document.querySelector('#mdc-dias_visita'));

        /**
            Acciones para Input de ciudad de expedición
            04/05/2021
        **/
        {
            // Variables
            var ciudadExpDef = '';                 // Valor por defecto del campo de ciudad
            var ciudades = @json($ciudades);    // Listado de ciudades

            // Busca los primeros 10 valores del listado de ciudades que concuerden con lo ingresado en el input
            $('#mdc-ciudad_exp input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                if(busqueda){
                    $('#clear-ciudad_exp').show();
                    $('#mdc-menu__buscar_ciudad_exp').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_ciudad_exp').empty();
                    if (ciudades.length) {
                        let auxCant = 0;
                        for (let index = 0; index < ciudades.length; index++) {
                            const auxCiudadExpDef = ciudades[index];
                            // Se configura para que no tenga en cuenta las tildes
                            if (auxCiudadExpDef.ciudad.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
                                auxCant++;
                                if (auxCiudadExpDef.id_ciudad == $('#ciudad_exp').val()) {
                                    $('#mdc-menu__buscar_ciudad_exp').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxCiudadExpDef.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudadExpDef.ciudad +'</span></li>');
                                } else {
                                    $('#mdc-menu__buscar_ciudad_exp').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxCiudadExpDef.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudadExpDef.ciudad +'</span></li>');
                                }
                            }
                            if (auxCant == 10) {
                                break;
                            }
                        }
                        if (!auxCant) {
                            $('#mdc-menu__buscar_ciudad_exp').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_ciudad_exp').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                    }
                }
            });

            // Restablece el valor por defecto en el compo de ciudad al quitar el foco del campo
            $('#mdc-ciudad_exp input').blur(function() {
                if(!$('#mdc-menu__buscar_ciudad_exp').hasClass('mdc-menu-surface--open')) {
                    ciudadExp.value = ciudadExpDef;
                }
                if (ciudadExpDef == '' || ciudadExpDef == null) {
                    $('#clear-ciudad_exp').hide();
                } else {
                    $('#clear-ciudad_exp').show();
                }
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
            $('#mdc-ciudad_exp input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_exp').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').first().data('value');
                        seleccionarCiudadExp(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_exp').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_exp').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_exp .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    ciudadExp.value = ciudadExpDef;
                    $('#mdc-ciudad_exp input').blur();
                    $('#mdc-menu__buscar_ciudad_exp').removeClass('mdc-menu-surface--open');
                    if (ciudadExpDef == '' || ciudadExpDef == null) {
                        $('#clear-ciudad_exp').hide();
                    } else {
                        $('#clear-ciudad_exp').show();
                    }
                }
                if (ciudadExpDef == '' || ciudadExpDef == null) {
                    $('#clear-ciudad_exp').hide();
                } else {
                    $('#clear-ciudad_exp').show();
                }
            });

            // Selecciona la ciudad en la cual se hace click
            $('#mdc-menu__buscar_ciudad_exp').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarCiudadExp(index, value);
            });

            // Selecciona la primer ciudad de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_ciudad_exp').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarCiudadExp(index, value);
                }
            });

            // Limpia el campo de ciudad, pero no altera el campo por defecto
            $('#clear-ciudad_exp').click(function() {
                ciudadExp.value = '';
                ciudadExp.valid = true;
                $(this).hide();
                $('#mdc-ciudad_exp input').focus();
            });

            // Selecciona la ciudad con base en el index del listado y el id
            function seleccionarCiudadExp(index, value) {
                if (index === undefined || index === null) {
                    ciudadExp.value = ciudadExpDef;
                } else {
                    let auxCiudadExpDef = ciudades[index];
                    ciudadExpDef = auxCiudadExpDef.ciudad;
                    $('#ciudad_exp').val(value);
                    ciudadExp.value = ciudadExpDef;
                }
                $('#mdc-ciudad_exp input').blur();
                $('#mdc-menu__buscar_ciudad_exp').removeClass('mdc-menu-surface--open');
                if (ciudadExpDef == '' || ciudadExpDef == null) {
                    $('#clear-ciudad_exp').hide();
                } else {
                    $('#clear-ciudad_exp').show();
                }
            }
        }

        /**
            Acciones para Input de ciudad
            20/01/2021
        **/
        {
            // Variables
            var ciudadDef = '';                 // Valor por defecto del campo de ciudad
            var ciudades = @json($ciudades);    // Listado de ciudades

            // Busca los primeros 10 valores del listado de ciudades que concuerden con lo ingresado en el input
            $('#mdc-ciudad input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                if(busqueda){
                    $('#clear-ciudad').show();
                    $('#mdc-menu__buscar_ciudad').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_ciudad').empty();
                    if (ciudades.length) {
                        let auxCant = 0;
                        for (let index = 0; index < ciudades.length; index++) {
                            const auxCiudad = ciudades[index];
                            // Se configura para que no tenga en cuenta las tildes
                            if (auxCiudad.ciudad.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
                                auxCant++;
                                if (auxCiudad.id_ciudad == $('#ciudad').val()) {
                                    $('#mdc-menu__buscar_ciudad').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxCiudad.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudad.ciudad +'</span></li>');
                                } else {
                                    $('#mdc-menu__buscar_ciudad').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxCiudad.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudad.ciudad +'</span></li>');
                                }
                            }
                            if (auxCant == 10) {
                                break;
                            }
                        }
                        if (!auxCant) {
                            $('#mdc-menu__buscar_ciudad').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_ciudad').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                    }
                }
            });

            // Restablece el valor por defecto en el compo de ciudad al quitar el foco del campo
            $('#mdc-ciudad input').blur(function() {
                if(!$('#mdc-menu__buscar_ciudad').hasClass('mdc-menu-surface--open')) {
                    ciudad.value = ciudadDef;
                }
                if (ciudadDef == '' || ciudadDef == null) {
                    $('#clear-ciudad').hide();
                } else {
                    $('#clear-ciudad').show();
                }
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
            $('#mdc-ciudad input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad .mdc-list-item').first().data('value');
                        seleccionarCiudad(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_ciudad .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    ciudad.value = ciudadDef;
                    $('#mdc-ciudad input').blur();
                    $('#mdc-menu__buscar_ciudad').removeClass('mdc-menu-surface--open');
                    if (ciudadDef == '' || ciudadDef == null) {
                        $('#clear-ciudad').hide();
                    } else {
                        $('#clear-ciudad').show();
                    }
                }
                if (ciudadDef == '' || ciudadDef == null) {
                    $('#clear-ciudad').hide();
                } else {
                    $('#clear-ciudad').show();
                }
            });

            // Selecciona la ciudad en la cual se hace click
            $('#mdc-menu__buscar_ciudad').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarCiudad(index, value);
            });

            // Selecciona la primer ciudad de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_ciudad').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarCiudad(index, value);
                }
            });

            // Limpia el campo de ciudad, pero no altera el campo por defecto
            $('#clear-ciudad').click(function() {
                ciudad.value = '';
                ciudad.valid = true;
                $(this).hide();
                $('#mdc-ciudad input').focus();
            });

            // Selecciona la ciudad con base en el index del listado y el id
            function seleccionarCiudad(index, value) {
                if (index === undefined || index === null) {
                    ciudad.value = ciudadDef;
                } else {
                    let auxCiudad = ciudades[index];
                    ciudadDef = auxCiudad.ciudad;
                    $('#ciudad').val(value);
                    ciudad.value = ciudadDef;
                }
                $('#mdc-ciudad input').blur();
                $('#mdc-menu__buscar_ciudad').removeClass('mdc-menu-surface--open');
                if (ciudadDef == '' || ciudadDef == null) {
                    $('#clear-ciudad').hide();
                } else {
                    $('#clear-ciudad').show();
                }
            }
        }

        /**
            Acciones para Input de firma
            04/05/2021
        **/
        {
            var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'
            });

            var cancelButton = document.getElementById('clear');
            cancelButton.addEventListener('click', function(e) {
                e.preventDefault();
                signaturePad.clear();
            });

            function resizeCanvas() {
                $('#signature-pad').attr('width', $('.col-firma .wrapper').width());
                signaturePad.clear(); // otherwise isEmpty() might return incorrect value
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();
        }

        // Asigna el valor del Select de TipoDocumento al input
        tipoDocumento.listen('MDCSelect:change', (el) => {
            $('#tipo_documento').val(tipoDocumento.value);
        });

        // Asigna el valor del Select de Genero al input
        genero.listen('MDCSelect:change', (el) => {
            $('#genero').val(genero.value);
        });

        // Asigna el valor del Select de TipoCliente al input
        // idTipoCliente.listen('MDCSelect:change', (el) => {
        //     $('#id_tipo_cliente').val(idTipoCliente.value);
        // });

        // Asigna los valores de cada día al input conrrespondiente
        diasVisita.listen('MDCChip:interaction', (el) => {
            if ($('#'+el.detail.chipId).hasClass('mdc-chip--selected')) {
                $('#'+el.detail.chipId.replace('mdc-', '')).val(1);
            } else {
                $('#'+el.detail.chipId.replace('mdc-', '')).val(0);
            }
        });

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
                        ciudad.value = ciudadDef;
                        ciudadExp.value = ciudadExpDef;
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

            const validarCliente = async function() {
                let url = urlClientesValidarCliente.replace('codigo_cli', codigoCli.value).replace('sucursal', '00');
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
                if (!nombres.valid || nombres.value == null || nombres.value == '') {
                    nombres.valid = false;
                    nombres.helperTextContent = 'Ingrese los nombres.';
                    M.toast({html: '<span class="mr-3">Error en los nombres del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!apellidos.valid || apellidos.value == null || apellidos.value == '') {
                    apellidos.valid = false;
                    apellidos.helperTextContent = 'Ingrese los apellidos.';
                    M.toast({html: '<span class="mr-3">Error en los apellidos del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!tipoDocumento.valid || tipoDocumento.value == null || tipoDocumento.value == '') {
                    tipoDocumento.valid = false;
                    tipoDocumentoHelper.foundation.setContent('Seleccione un tipo de documento.');
                    M.toast({html: '<span class="mr-3">Error en el tipo de documento.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!codigoCli.valid || codigoCli.value == null || codigoCli.value == '') {
                    codigoCli.valid = false;
                    codigoCli.helperTextContent = 'Ingrese el documento.';
                    M.toast({html: '<span class="mr-3">Error en el documento del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!ciudadExp.valid || ciudadExp.value == null || ciudadExp.value == '' || $('#ciudad_exp').val() == null || $('#ciudad_exp').val() == '') {
                    ciudadExp.valid = false;
                    ciudadExp.helperTextContent = 'Seleccione la ciudad de expedición.';
                    M.toast({html: '<span class="mr-3">Error en la ciudad de expedición del documento.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono.valid || telefono.value == null || telefono.value == '') {
                    telefono.valid = false;
                    telefono.helperTextContent = 'Ingrese el teléfono.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!fechaNacimiento.valid || fechaNacimiento.value == null || fechaNacimiento.value == '') {
                    fechaNacimiento.valid = false;
                    fechaNacimiento.helperTextContent = 'Ingrese el teléfono.';
                    M.toast({html: '<span class="mr-3">Error en la fecha de nacimiento del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion.valid || direccion.value == null || direccion.value == '') {
                    direccion.valid = false;
                    direccion.helperTextContent = 'Ingrese la dirección.';
                    M.toast({html: '<span class="mr-3">Error en la dirección del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!barrio.valid || barrio.value == null || barrio.value == '') {
                    barrio.valid = false;
                    barrio.helperTextContent = 'Ingrese el barrio.';
                    M.toast({html: '<span class="mr-3">Error en el barrio del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!ciudad.valid || ciudad.value == null || ciudad.value == '' || $('#ciudad').val() == null || $('#ciudad').val() == '') {
                    ciudad.valid = false;
                    ciudad.helperTextContent = 'Seleccione la ciudad.';
                    M.toast({html: '<span class="mr-3">Error en la ciudad del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!correo.valid || correo.value == null || correo.value == '') {
                    correo.valid = false;
                    correo.helperTextContent = 'Ingrese el correo.';
                    M.toast({html: '<span class="mr-3">Error en el correo del cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                // if (!idTipoCliente.valid || idTipoCliente.value == null || idTipoCliente.value == '') {
                //     idTipoCliente.valid = false;
                //     idTipoClienteHelper.foundation.setContent('Seleccione un tipo de cliente.');
                //     M.toast({html: '<span class="mr-3">Error en el tipo de cliente.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                //     return false;
                // }
                if (!diasVisita.selectedChipIds.length) {
                    M.toast({html: '<span class="mr-3">Seleccione los días de visita.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!$('#acepto').is(':checked')) {
                    M.toast({html: '<span class="mr-3">Por favor autorice el tratatiento de datos personales.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    $('#acepto').focus();
                    return false;
                }
                // if ($('#imagen_cedula')[0].files.length == 0) {
                //     M.toast({html: '<span class="mr-3">Por favor agregue una foto de la cédula.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                //     imagen_cedula.focus();
                //     return false;
                // }
                if (signaturePad.isEmpty()) {
                    M.toast({html: '<span class="mr-3">Por favor firme la solicitud.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                } else {
                    $('#firma').val(signaturePad.toDataURL());
                }
                let validacionCliente = await validarCliente();
                if (validacionCliente.cliente) {
                    console.log(validacionCliente.cliente);
                    Swal.fire({
                        title: 'El cliente ya existe',
                        text: 'El documento ' +validacionCliente.sucursal.codigo_cli+ ' se encuentra registrado con el nombre: ' +validacionCliente.sucursal.nombre_cliente+ ' y la sucursal ' +validacionCliente.sucursal.sucursal+ ' se encuentra registrada en la dirección ' +validacionCliente.sucursal.direccion+ '.',
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
                console.log(validacion);
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
        @if (Session::has('cliente_creado'))
            let dataSession = JSON.parse('{!! Session::get('cliente_creado') !!}');
            Swal.fire({
                title: 'Cliente creado con éxito',
                text: 'El cliente con cc/nit ' + dataSession.cc_nit + ' y nombre ' + dataSession.nombre_cliente + ' se ha creado exitosamente.',
                icon: 'success'
            });
            @php
                Session::forget('cliente_creado');
            @endphp
        @endif
    </script>
</body>
</html>

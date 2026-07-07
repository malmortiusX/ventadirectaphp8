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
            <form action="{{ route('clientes.externos.empresarios') }}" method="POST" id="form"accept-charset="UTF-8" enctype="multipart/form-data" files="true">
                @csrf
                <input type="hidden" class="hide" name="ciudad_expedicion_empresaria" id="ciudad_expedicion_empresaria">
                <input type="hidden" class="hide" name="ciudad_empresaria" id="ciudad_empresaria">
                <input type="hidden" class="hide" name="ciudad_referenciador" id="ciudad_referenciador">
                <input type="hidden" class="hide" name="firma_empresaria" id="firma_empresaria">
                <input type="hidden" class="hide" name="cop" id="cop" value="49901">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6">
                            <h1 class="title">FORMULARIO DE INSCRIPCIÓN</h1>
                            <div class="breadcrumbs full-width">
                                <a class="breadcrumb">EMPRESARIOS AVICAMPO</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col s12">
                            <div class="card highlighted mt-0">
                                <div class="card-content">
                                    <div class="row mb-2">
                                        <div class="col justify">
                                            <p><b>El empresario Avicampo</b> es una persona natural que desea emprender de forma independiente y bajo su propia cuenta y riesgo en la venta de alimentos perecederos fabricados por la compañía.</p>
                                            <p>Actuará por su propia cuenta y no estará sometido a subordinación laboral de ninguna naturaleza respecto de la compañía. Por consiguiente, en forma clara y explicita declara que no existe ninguna relación de carácter laboral entre las partes o con los trabajadores que contrate el empresario Avicampo, para el desarrollo o ejecución del presente contrato.</p>
                                            <p>El empresario Avicampo se compromete a asumir todos los riesgos y a realizar los suministros con sus propios medios y absoluta autonomía técnica y directiva.</p>
                                        </div>
                                    </div>
                                    <span class="card-title mb-3">Datos deL empresario</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-ciudad_expedicion_empresaria">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_ciudad_expedicion_empresaria">Ciudad de Expedición</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                                <input type="text" class="mdc-text-field__input" data-input="ciudad_expedicion_empresaria" aria-labelledby="lbl_ciudad_expedicion_empresaria" autocomplete="off" required>
                                                <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                                <span id="clear-ciudad_expedicion_empresaria" class="form-clear d-none mdc-icon-clear" style="display: none">
                                                    <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-ciudad_expedicion_empresaria" aria-hidden="true"></div>
                                            </div>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_ciudad_expedicion_empresaria">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
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
                                    <span class="card-title mb-3">Información Sobre el Referenciador (Persona que lo inscribió en el programa)</span>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombres_referenciador">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombres_referenciador" name="nombres_referenciador" id="nombres_referenciador" required maxlength="30" max="9999999999" min="0">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombres_referenciador">Nombres</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-apellidos_referenciador">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_apellidos_referenciador" name="apellidos_referenciador" id="apellidos_referenciador" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_apellidos_referenciador">Apellidos</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 30</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono_referenciador">
                                                <input type="tel" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono_referenciador" name="telefono_referenciador" id="telefono_referenciador" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono_referenciador">Teléfono</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion_referenciador">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion_referenciador" name="direccion_referenciador" id="direccion_referenciador" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion_referenciador">Dirección</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense mdc-text-field--with-trailing-icon" id="mdc-ciudad_referenciador">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_ciudad_referenciador">Ciudad</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                                <input type="text" class="mdc-text-field__input" data-input="ciudad_referenciador" aria-labelledby="lbl_ciudad_referenciador" autocomplete="off" required>
                                                <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-spinner sending white-text"></i>
                                                <span id="clear-ciudad_referenciador" class="form-clear d-none mdc-icon-clear" style="display: none">
                                                    <i class="mdc-text-field__icon mdc-text-field__icon--trailing fas fa-times"></i>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" id="mdc-helper-ciudad_referenciador" aria-hidden="true"></div>
                                            </div>
                                            <div id="toolbar" class="toolbar mdc-menu-surface--anchor">
                                                <div class="mdc-menu mdc-menu-surface mdc-menu--dense" role="listbox" id="mdc-menu__buscar_ciudad_referenciador">
                                                    <ul class="mdc-list">
                                                        <!-- Items que coincidan con la búsqueda -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-codigo_cedula_referenciador">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_codigo_cedula_referenciador" name="codigo_cedula_referenciador" id="codigo_cedula_referenciador" required maxlength="15">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_codigo_cedula_referenciador">Código o Cédula</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 15</div>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <hr>
                                        </div>
                                    </div>
                                    <span class="card-title">Referencias Familiares</span>
                                    <blockquote>
                                        <h6 class="h6 mb-3">Referencia 1</h6>
                                    </blockquote>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombres_referencia_familiar_1">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombres_referencia_familiar_1" name="nombres_referencia_familiar_1" id="nombres_referencia_familiar_1" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombres_referencia_familiar_1">Nombres</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-apellidos_referencia_familiar_1">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_apellidos_referencia_familiar_1" name="apellidos_referencia_familiar_1" id="apellidos_referencia_familiar_1" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_apellidos_referencia_familiar_1">Apellidos</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-parentesco_referencia_familiar_1">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_parentesco_referencia_familiar_1" name="parentesco_referencia_familiar_1" id="parentesco_referencia_familiar_1" required maxlength="15">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_parentesco_referencia_familiar_1">Parentesco</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion_referencia_familiar_1">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion_referencia_familiar_1" name="direccion_referencia_familiar_1" id="direccion_referencia_familiar_1" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion_referencia_familiar_1">Dirección</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 100</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono_referencia_familiar_1">
                                                <input type="tel" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono_referencia_familiar_1" name="telefono_referencia_familiar_1" id="telefono_referencia_familiar_1" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono_referencia_familiar_1">Teléfono</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 10</div>
                                            </div>
                                        </div>
                                    </div>
                                    <blockquote>
                                        <h6 class="h6 mb-3">Referencia 2</h6>
                                    </blockquote>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombres_referencia_familiar_2">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombres_referencia_familiar_2" name="nombres_referencia_familiar_2" id="nombres_referencia_familiar_2" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombres_referencia_familiar_2">Nombres</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-apellidos_referencia_familiar_2">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_apellidos_referencia_familiar_2" name="apellidos_referencia_familiar_2" id="apellidos_referencia_familiar_2" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_apellidos_referencia_familiar_2">Apellidos</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-parentesco_referencia_familiar_2">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_parentesco_referencia_familiar_2" name="parentesco_referencia_familiar_2" id="parentesco_referencia_familiar_2" required maxlength="15">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_parentesco_referencia_familiar_2">Parentesco</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion_referencia_familiar_2">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion_referencia_familiar_2" name="direccion_referencia_familiar_2" id="direccion_referencia_familiar_2" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion_referencia_familiar_2">Dirección</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 100</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono_referencia_familiar_2">
                                                <input type="tel" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono_referencia_familiar_2" name="telefono_referencia_familiar_2" id="telefono_referencia_familiar_2" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono_referencia_familiar_2">Teléfono</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 10</div>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <hr>
                                        </div>
                                    </div>
                                    <span class="card-title">Referencias Comerciales</span>
                                    <blockquote>
                                        <h6 class="h6 mb-3">Referencia 1</h6>
                                    </blockquote>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombre_referencia_comercial_1">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombre_referencia_comercial_1" name="nombre_referencia_comercial_1" id="nombre_referencia_comercial_1" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombre_referencia_comercial_1">Nombre de la Institución</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion_referencia_comercial_1">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion_referencia_comercial_1" name="direccion_referencia_comercial_1" id="direccion_referencia_comercial_1" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion_referencia_comercial_1">Dirección</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 100</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono_referencia_comercial_1">
                                                <input type="tel" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono_referencia_comercial_1" name="telefono_referencia_comercial_1" id="telefono_referencia_comercial_1" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono_referencia_comercial_1">Teléfono</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 10</div>
                                            </div>
                                        </div>
                                    </div>
                                    <blockquote>
                                        <h6 class="h6 mb-3">Referencia 2</h6>
                                    </blockquote>
                                    <div class="row mb-0">
                                        <div class="col s12 m6 l4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-nombre_referencia_comercial_2">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_nombre_referencia_comercial_2" name="nombre_referencia_comercial_2" id="nombre_referencia_comercial_2" required maxlength="30">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_nombre_referencia_comercial_2">Nombre de la Institución</span>
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
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-direccion_referencia_comercial_2">
                                                <input type="text" class="mdc-text-field__input uppercase" aria-labelledby="lbl_direccion_referencia_comercial_2" name="direccion_referencia_comercial_2" id="direccion_referencia_comercial_2" required maxlength="100">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_direccion_referencia_comercial_2">Dirección</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 100</div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l4 mb-0 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-telefono_referencia_comercial_2">
                                                <input type="tel" class="mdc-text-field__input uppercase" aria-labelledby="lbl_telefono_referencia_comercial_2" name="telefono_referencia_comercial_2" id="telefono_referencia_comercial_2" required maxlength="10">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_telefono_referencia_comercial_2">Teléfono</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                            </label>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg nowrap" aria-hidden="true"></div>
                                                <div class="mdc-text-field-character-counter">0 / 10</div>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col justify">
                                            <p>Autorizo a AVÍCOLA EL MADROÑO S.A. a verificar mis referencias con todas a aquellas entidades que estime conveniente y en caso de incurrir en incumplimiento de alguna de las condiciones de pago, para registrar mis datos en los bancos de información legalmente establecidos, declaro haber leído el manual Paso a Paso y declaro mi conformidad para cumplir con todos los compromisos que adquiero como compradora de las Ventas por Catalogo.</p>
                                            <p>Como titular de los datos y bajo los parámetros de la Ley 1581 de 2012 y las normas que la adicionen y/o modiﬁquen, Autorizo a AVÍCOLA EL MADROÑO S.A. a recolectar, almacenar, usar, circular, procesar, transferir, suprimir, actualizar, y disponer de los datos personales aquí solicitados para cumplir con el desarrollo normal de su objeto social y para dar cumplimiento a las obligaciones legales y contractuales de AVICOLA EL MADROÑO S.A. Sin perjuicio de lo anterior, los datos recolectados por AVÍCOLA EL MADROÑO S.A. son recolectados para las siguienes ﬁnalidades:</p>
                                            <ol>
                                                <li>La Ejecución del contrato suscrito con cualquiera de la Compañía.</li>
                                                <li>Pago de obligaciones contractuales.</li>
                                                <li>Envío de información a entidades gubernamentales o judiciales por solicitud expresa de la misma.</li>
                                                <li>Soporte en procesos de auditoría externa/interna.</li>
                                                <li>Registro de la información de los empleados en la base de datos AVÍCOLA EL MADROÑO S.A.</li>
                                                <li>Contacto con empleados para el envío de información relacionado con la relación contractual y obligacional que tenga lugar.</li>
                                                <li>Recolección de datos para el cumplimiento de los deberes que como responsable de la información y datos personales, le corresponde AVÍCOLA EL MADROÑO S.A.</li>
                                                <li>Con propósitos de seguridad o prevención de fraude.</li>
                                                <li>Cualquier otra ﬁnalidad que resulte en el desarrollo del contrato o la relación entre usted Y AVÍCOLA EL MADROÑO S.A.</li>
                                            </ol>
                                            <p>Además, conozco mis derechos a conocer, actualizar y rectiﬁcar mis datos personales; Todo lo anterior, cumpliendo con lo establecido en la “Política de Tratamiento de Datos Personales”, y “política de términos y condiciones” la cual me ha sido informado y entiendo claramente, que puedo consultar en la página web www.avicolaelmadrono.com. https://avicampo.shop/</p>
                                            <br>
                                            <p style="color:red;">Declaro bajo gravedad de juramento que los recursos no provienen de actividades ilícitas, ni vinculadas con el cultivo, producción o tráﬁco de estupefacientes, ni actividades contempladas en el Código Penal Colombiano o en cualquier norma que lo modiﬁque o adicione, dando cumplimiento a lo señalado en la Circular 100 - 000005 de agosto 2016 expedida por la Superintendencia de Sociedades, el Estatuto Anticorrupción (Ley 190 de 1995).  Autorizo el uso de mis datos personales.</p>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col s12 mb-1">
                                            <div class="mdc-form-field">
                                                <div class="mdc-checkbox mdc-checkbox--touch pl-0">
                                                    <input type="checkbox" class="mdc-checkbox__native-control" id="aceptoConsumidor"/>
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                    <div class="mdc-checkbox__ripple"></div>
                                                </div>
                                                <label for="aceptoConsumidor" class="ml-1 noselect nowrap" style="white-space: pre-line;">Acepto los términos y condiciones (Consumidor). <a class="modal-trigger" href="#modal_tycConsumidor">Clic aquí para ver los términos y condiciones.</a></label>
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
                                                <label for="aceptoEmpresarias" class="ml-1 noselect nowrap" style="white-space: pre-line;">Acepto los términos y condiciones - Empresarios Avicampo. <a class="modal-trigger" href="#modal_tyc">Clic aquí para ver los terminos y condiciones</a></label>
                                            </div>
                                        </div>
                                        <div class="col s12 m12 col-dropify mt-2">
                                            <label class="dropify-label">Cédula del empresario - Cara 1</label>
                                            <input type="file" class="dropify" id="cedula_empresaria_cara_1" name="cedula_empresaria_cara_1" accept=".jpg,.jpeg,.png,.webp" data-allowed-file-extensions="jpg jpeg png webp"/>
                                        </div>
                                        <div class="col s12 m12 col-dropify mt-2">
                                            <label class="dropify-label">Cédula del empresario - Cara 2</label>
                                            <input type="file" class="dropify" id="cedula_empresaria_cara_2" name="cedula_empresaria_cara_2" accept=".jpg,.jpeg,.png,.webp" data-allowed-file-extensions="jpg jpeg png webp"/>
                                        </div>
                                        <div class="col s12 mt-2 col-firma">
                                            <label style="margin-left: 16px;">Firma del empresario</label>
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
                                <span class="mdc-button__label mr-1">{{ isset($cliente) ? "Actualizar" : "Crear" }} Empresaria</span>
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="cargando noselect px-5 center" id="guardando" style="display: none">
                <div id="html-spinner"></div>
                <span class="title mt-1">Guardando Vendedora</span>
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
    <div id="modal_tycConsumidor" class="modal">
        <div class="container justify modal-content modal-fixed-footer">

            <h5 class="center">
                TÉRMINOS Y CONDICIONES
                <br>
                Consumidor
            </h5>
            <p>A partir del veinte (20) de septiembre de 2022 y hasta el treinta y uno (31) de diciembre 2022, Avicampo tendrá vigente la temporada de navidad de ventas por catálogo, en las ciudades de Cartagena, Barranquilla, Bucaramanga, Cucuta, Pereira.  <b>“Catálogo de Navidad 2022”.</b></p>
            <ul>
                <li style="list-style-type: disc;"><b>Medios de difusión:</b></li>
                <p>La temporada de navidad del canal de venta directa, será difundida a través del catálogo de navidad de Avicampo 2022. Adicionalmente, los consumidores podrán consultar los términos y condiciones a través de <a href="https://avicampo.shop" class="link color-primary" target="_blank">https://avicampo.shop</a>.</p>
                <li style="list-style-type: disc;"><b>Participantes:</b></li>
                <p>Podrán participar los consumidores mayores de edad que realicen compras a las empresarios a través del catálogo de Avicampo en la temporada de navidad.</p>
                <li style="list-style-type: disc;"><b>Productos participantes:</b></li>
                <p>Participan los siguientes productos en el catálogo de la temporada de navidad: Pollo Relleno Artesanal 1800gr, Pollo Relleno Artesanal 1200 gr, Fantasía de cerdo1200 gr, Fantasía de cerdo 800gr, Cena Celebración, Mix de pollo, cerdo y pavo 900 gr, Medallón Pavo Finas Hiervas grs 1000 gr.</p>
                <li style="list-style-type: disc;"><b>Obsequio de la temporada:</b></li>
                <p>El canal de venta directa, hará entrega de una bandeja de dip, por la compra de producto de pollo relleno artesanal de 1800 gr y pollo relleno artesanal de 1200 gr. Quienes compren estas referencias, la recibirán totalmente gratis.<br>
                El obsequio aquí ofrecido no será canjeable bajo ninguna circunstancia, Los obsequios se entregan exclusivamente por compras en el canal de venta directa (a través de la empresario) y están sujetos a disponibilidad de color, y referencia.</p>
                <li style="list-style-type: disc;"><b>Entrega de producto:</b></li>
                <p>La entrega de los productos la realizará la empresario de venta directa, quien entregará los productos del catálogo de Avicampo de la temporada de navidad, con sus propios medios y absoluta autonomía técnica y directiva.</p>
            </ul>
            <p>Para quejas, sugerencias o comentarios sobre los productos adquiridos, podrá escribir a nuestra página <a href="https://avicampo.shop" class="link color-primary" target="_blank">https://avicampo.shop</a>. O comunicarse a las siguientes líneas de contacto:<br>
                Regional Oriente tels: 315 233 5626<br>
                Regional Occidente tels: 320 632 0983<br>
                Regional Costa tels: 317 3716564<br>
            </p>
            <ul>
                <li style="list-style-type: disc;">Por favor tenga en cuenta que sus peticiones, quejas o reclamos serán atendidos dentro de los quince (15) días calendario siguientes.</li>
                <li style="list-style-type: disc;">Los Productos fabricados por AVÍCOLA EL MADROÑO S.A. son alimentos perecederos, y el término de garantía legal sobre los mismos se sujeta a la fecha de expiración o vencimiento inserta en cada uno de ellos.</li>
                <li style="list-style-type: disc;">Para el canal de venta por catálogo no será aplicable el derecho de retracto al que se refiere el artículo 47 del Estatuto de Protección al Consumidor (Ley 1480 de 2011), teniendo en cuenta que los productos comercializados mediante este canal son productos perecederos.</li>
                <li style="list-style-type: disc;">El fabricante de los productos es AVÍCOLA EL MADROÑO S.A., sociedad comercial identificada con NIT. 800.000.276-8, con domicilio principal en el Km6 vía Girón Cra12 57-88 Italcol , Girón - Santander.</li>
            </ul>
            <p>Varios:
                <ul>
                    <li style="list-style-type: disc;">Usted ha seleccionado a un(a) EMPRESARIO AVICAMPO para comprar un producto de AVICOLA EL MADROÑO S.A., usted recibirá el Producto directamente por parte de él/ella.</li>
                    <li style="list-style-type: disc;">El contrato de venta será entre el (la) EMPRESARIO AVICAMPO y usted. Por ende, las preguntas que tenga sobre su orden deberán ser resueltas directamente con el EMPRESARIO AVICAMPO.</li>
                    <li style="list-style-type: disc;">El EMPRESARIO AVICAMPO es un vendedor independiente, como resultado de ello, AVÍCOLA EL MADROÑO S.A. no se hace responsable de perdidas, daños, costos, gastos (directos o indirectos) que provengan de los actos u omisiones del EMPRESARIO AVICAMPO.</li>
                    <li style="list-style-type: disc;">Este documento, y todas las relaciones de cualquier tipo que se deriven de él, se regirán por la ley de la República de Colombia.</li>
                </ul>
            </p>
            <p><b>Autorización para el tratamiento de datos personales</b></p>
            <p>Como titular de los datos y bajo los parámetros de la Ley 1581 de 2012 y las normas que la adicionen y/o modiﬁquen, Autorizo a AVÍCOLA EL MADROÑO S.A. a recolectar, almacenar, usar, circular, procesar, transferir, suprimir, actualizar, y disponer de los datos personales aquí solicitados para cumplir con el desarrollo normal de su objeto social y para dar cumplimiento a las obligaciones legales y contractuales de AVICOLA EL MADROÑO S.A. Sin perjuicio de lo anterior, los datos recolectados por AVÍCOLA EL MADROÑO S.A. son recolectados para las siguientes  ﬁnalidades:
                <ul>
                    <li style="list-style-type: upper-roman;">La Ejecución del contrato suscrito con cualquiera de la Compañía.</li>
                    <li style="list-style-type: upper-roman;">Pago de obligaciones contractuales.</li>
                    <li style="list-style-type: upper-roman;">Envío de información a entidades gubernamentales o judiciales por solicitud expresa de la misma.</li>
                    <li style="list-style-type: upper-roman;">Soporte en procesos de auditoría externa/interna.</li>
                    <li style="list-style-type: upper-roman;">Registro de la información de los empleados en la base de datos AVÍCOLA EL MADROÑO S.A.</li>
                    <li style="list-style-type: upper-roman;">Contacto con empleados para el envío de información relacionado con la relación contractual y obligacional que tenga lugar.</li>
                    <li style="list-style-type: upper-roman;">Recolección de datos para el cumplimiento de los deberes que como responsable de la información y datos personales, le corresponde AVÍCOLA EL MADROÑO S.A.</li>
                    <li style="list-style-type: upper-roman;">Con propósitos de seguridad o prevención de fraude.</li>
                    <li style="list-style-type: upper-roman;">Cualquier otra ﬁnalidad que resulte en el desarrollo del contrato o la relación entre usted Y AVÍCOLA EL MADROÑO S.A.</li>
                </ul>
            </p>
            <p>Además, conozco mis derechos a conocer, actualizar y rectiﬁcar mis datos personales; Todo lo anterior, cumpliendo con lo establecido en la “Política de Tratamiento de Datos Personales”, la cual me ha sido informado y entiendo claramente, que puedo consultar en la página web <a href="www.avicolaelmadrono.com" class="link color-primary" target="_blank">www.avicolaelmadrono.com</a>. <a href="https://avicampo.shop/" class="link color-primary" target="_blank">https://avicampo.shop</a></p>
            <p>Declaro bajo gravedad de juramento que los recursos no provienen de actividades ilícitas, ni vinculadas con el cultivo, producción o tráﬁco de estupefacientes, ni actividades contempladas en el Código Penal Colombiano o en cualquier norma que lo modiﬁque o adicione, dando cumplimiento a lo señalado en la Circular 100 - 000005 de agosto 2016 expedida por la Superintendencia de Sociedades, el Estatuto Anticorrupción (Ley 190 de 1995).  Autorizo el uso de mis datos personales.</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
    <div id="modal_tyc" class="modal">
        <div class="container justify modal-content modal-fixed-footer">

            <h5 class="center">
                TERMINOS Y CONDICIONES PARA EMPRESARIOS AVICAMPO
                VENTA POR CATÁLOGO
                <br>
                AVÍCOLA EL MADROÑO S.A.
                NIT. 800000276 - 8
            </h5>
            <p>Los presentes términos y condiciones rigen para los (las) EMPRESARIOS AVICAMPO, a partir del momento en el que se registren como vendedor de catálogo ante AVÍCOLA EL MADROÑO S.A. (en adelante “MADROÑO”), diligenciando el respectivo formulario de registro, bien a través de la página web, WhatsApp o de forma física.</p>
            <p>Se entiende por EMPRESARIO(S) AVICAMPO la persona natural autorizada por MADROÑO para realizar pedidos del catálogo de productos fabricados por MADROÑO.</p>
            <p>En el momento en el que se suscribe el formulario de inscripción, los EMPRESARIOS AVÍCAMPO reconocen haber leído, entendido y aceptado los presentes términos y condiciones.</p>

            <h6>I.    REGISTRO</h6>
            <p>Para que una persona natural adquiera la calidad de EMPRESARIOS AVICAMPO, deberá registrarse como vendedor de catálogo, completando la siguiente información:</p>
            <ul>
                <li>- Número de cédula</li>
                <li>- Nombre completo</li>
                <li>- Correo electrónico</li>
                <li>- Teléfono de contacto actualizado</li>
                <li>- Dirección de despacho</li>
            </ul>
            <p>En el evento que los datos suministrados sean insuficientes, no estén actualizados o sean aparentemente falsos, no podrá completarse el proceso de inscripción.</p>
            <p>Como documentos, deberá adjuntar o enviar por correo electrónico, copia de su cédula de ciudadanía y copia del Registro Único Tributario.</p>
            <p>MADROÑO, se reserva el derecho de negar solicitudes de registro que considere contrarias a sus intereses.</p>

            <h6>II.	COLOCACIÓN DE PEDIDOS</h6>
            <p>A partir del momento en el que MADROÑO aprueba una solicitud de registro, el EMPRESARIO AVÍCAMPO podrá ofrecer el catálogo de Productos de MADROÑO a sus clientes.</p>
            <p>El EMPRESARIO AVÍCAMPO deberá hacer la solicitud de Productos de la siguiente manera:</p>
            <ul>
              <li>- Telefónicamente con el apoyo de la coordinadora </li>
              <li>- Plataforma de pedidos web</li>
            </ul>
            <p>Para que una solicitud de Productos sea despachada al domicilio del EMPRESARIO AVICAMPO, deberá haberla cancelado previamente mediante pago anticipado. Los EMPRESARIOS AVICAMPO no contarán con cupo de crédito rotativo para la solicitud y despacho de Productos.</p>

            <h6>III.	DISPONIBILIDAD DE PRODUCTOS</h6>
            <p>La aprobación de pedidos de Productos estará sujeta a la disponibilidad que de ellos tenga MADROÑO.</p>
            <p>En el evento en que no exista inventario de los Productos solicitados por el EMPRESARIO AVICAMPO, se aplicará el siguiente procedimiento:</p>
            <ul>
                <li>- Telefónicamente se informará los productos próximos a agotarse o agotados.</li>
                <li>- En la pagina Web en el momento del montaje del pedido el producto sin inventario, se registrará como agotado.</li>
            </ul>

            <h6>IV.	FACTURACIÓN </h6>
            <p>En el momento en que se confirme el pedido de Productos y se complete el pago de los mismos, MADROÑO emitirá factura de venta a nombre del EMPRESARIO AVICAMPO.</p>

            <h6>V.	ENTREGA DE PRODUCTOS </h6>
            <p>Todos los pedidos serán despachados a la dirección indicada como <i>Dirección de Despacho</i> por el EMPRESARIO AVICAMPO al momento de diligenciar su solicitud de inscripción. Los pedidos que se entregaran a partir del 1 de diciembre de 2022.</p>
            <p>Teniendo en cuenta que los Productos dispuestos en el catálogo de venta son perecederos y deben conservar una cadena de frío adecuada, MADROÑO se reserva la facultad de entregar productos de forma fraccionada, es decir, limitando el número de Productos para garantizar que la infraestructura dispuesta por el EMPRESARIO AVICAMPO para la conservación de la cadena de frío sea óptima.</p>
            <p>En el momento de la entrega de los Productos solicitados por el EMPRESARIO AVICAMPO en la Dirección de Despacho, MADROÑO entregará al primero un listado de los Productos entregados, a efectos que el EMPRESARIO AVICAMPO verifique el estado de los Productos, indique los faltantes o confirme la entrega efectiva de los productos solicitados.</p>

            <h6>VI.	REQUISITOS PARA LA ENTREGA DE PRODUCTOS</h6>
            <p>El EMPRESARIO AVICAMPO deberá estar presente o dejar carta autorizando, la entrega de los productos.</p>

            <h6>VII.    RESPONSABILIDAD POR LOS PRODUCTOS</h6>
            <p>A partir del momento de la entrega efectiva de Productos, la propiedad sobre los mismos será transferida a el EMPRESARIO AVICAMPO. </p>
            <p>Luego de que el EMPRESARIO AVICAMPO suscriba el comprobante de entrega, no serán de recibo por parte de MADROÑO reclamos relativos al estado de los Productos o productos faltantes.</p>
            <p>Será obligación del EMPRESARIO AVICAMPO efectuar la entrega al consumidor final en la dirección indicada por éste.</p>

            <h6>VIII.	TRAMITE DE RECLAMACIONES</h6>
            <p>En el evento que los consumidores finales presenten reclamaciones sobre los Productos comercializados a través de la venta por catálogo, MADROÑO dispone de los siguientes medios de contacto:</p>
            <ul>
                <li>- Regional Oriente tels:    315 233 5626</li>
                <li>- Regional Occidente tels:  320 632 0983</li>
                <li>- Regional Costa tels:      317 3716564</li>
            </ul>
            <p>Cuando el EMPRESARIO AVICAMPO conozca de alguna reclamación hecha por algún consumidor final sobre los Productos, deberá ponerla en conocimiento de MADROÑO a más tardar dentro del primer (1) día hábil siguiente a la fecha en la que tuviere conocimiento de ésta.</p>
            <p>El EMPRESARIO AVICAMPO deberá informar al consumidor final que el término de garantía legal sobre los Productos, estará sujeto a la fecha de expiración del Producto.</p>

            <h6>IX.	 DERECHO DE RETRACTO</h6>
            <p>Atendiendo a la naturaleza de los Productos contenidos en el catálogo de venta, y de conformidad con lo establecido en el Estatuto de Protección al Consumidor, no serán procedentes los reclamos relativos al derecho de retracto.</p>
            <p>Los EMPRESARIOS AVICAMPO se comprometen a informar al consumidor antes de completar la compra, lo siguiente:</p>
            <ol>
                <li>Los Productos fabricados por MADROÑO son alimentos perecederos.</li>
                <li>Los Productos tienen una vida útil aproximada de 30 días, contados a partir de la fecha de entrega al EMPRESARIO AVICAMPO.</li>
                <li>Los Productos son fabricados por AVÍCOLA EL MADROÑO S.A.</li>
            </ol>

            <h6>X.	VIGENCIA</h6>
            <p>Los presentes términos y condiciones rigen desde el 20 de septiembre hasta el 31 diciembre de 2022.  MADROÑO se reserva el derecho de modificar los presentes términos y condiciones en cualquier momento y de forma unilateral.</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
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

        $('#crear-clientes').addClass('mdc-list-item--active');

        var imagen_cedula = $('.dropify').dropify({
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
        var numDecimales = {{ $empresa->decimales }};

        // Declaración de urls a utilizar
        const urlClientesValidarCliente = '{!! route('ajax.clientes.validarCliente', ['codigo_cli' => 'documento', 'sucursal' => 'sucursal']) !!}';

        // Declaración de elementos de material.io (Mismo orden en el que se renderizan)
        const nombres_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombres_empresaria'));
        const apellidos_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-apellidos_empresaria'));
        const fecha_nacimiento_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha_nacimiento_empresaria'));
        const cedula_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-cedula_empresaria'));
        const ciudad_expedicion_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-ciudad_expedicion_empresaria'));
        const direccion_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_empresaria'));
        const ciudad_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-ciudad_empresaria'));
        const barrio_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-barrio_empresaria'));
        const telefono_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_empresaria'));
        const correo_empresaria = new mdc.textField.MDCTextField(document.querySelector('#mdc-correo_empresaria'));
        const nombres_referenciador = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombres_referenciador'));
        const apellidos_referenciador = new mdc.textField.MDCTextField(document.querySelector('#mdc-apellidos_referenciador'));
        const telefono_referenciador = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_referenciador'));
        const direccion_referenciador = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_referenciador'));
        const ciudad_referenciador = new mdc.textField.MDCTextField(document.querySelector('#mdc-ciudad_referenciador'));
        const codigo_cedula_referenciador = new mdc.textField.MDCTextField(document.querySelector('#mdc-codigo_cedula_referenciador'));
        const nombres_referencia_familiar_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombres_referencia_familiar_1'));
        const apellidos_referencia_familiar_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-apellidos_referencia_familiar_1'));
        const parentesco_referencia_familiar_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-parentesco_referencia_familiar_1'));
        const direccion_referencia_familiar_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_referencia_familiar_1'));
        const telefono_referencia_familiar_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_referencia_familiar_1'));
        const nombres_referencia_familiar_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombres_referencia_familiar_2'));
        const apellidos_referencia_familiar_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-apellidos_referencia_familiar_2'));
        const parentesco_referencia_familiar_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-parentesco_referencia_familiar_2'));
        const direccion_referencia_familiar_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_referencia_familiar_2'));
        const telefono_referencia_familiar_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_referencia_familiar_2'));
        const nombre_referencia_comercial_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombre_referencia_comercial_1'));
        const direccion_referencia_comercial_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_referencia_comercial_1'));
        const telefono_referencia_comercial_1 = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_referencia_comercial_1'));
        const nombre_referencia_comercial_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombre_referencia_comercial_2'));
        const direccion_referencia_comercial_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_referencia_comercial_2'));
        const telefono_referencia_comercial_2 = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_referencia_comercial_2'));

        // Variables
        var ciudades = @json($ciudades);    // Listado de ciudades
        var ciudadDef = '';
        var ciudadExpDef = '';
        var ciudadRefDef = '';


        /**
            Acciones para Input de ciudad de expedición
            04/05/2021
        **/
        {

            // Busca los primeros 10 valores del listado de ciudades que concuerden con lo ingresado en el input
            $('#mdc-ciudad_expedicion_empresaria input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                if(busqueda){
                    $('#clear-ciudad_expedicion_empresaria').show();
                    $('#mdc-menu__buscar_ciudad_expedicion_empresaria').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_ciudad_expedicion_empresaria').empty();
                    if (ciudades.length) {
                        let auxCant = 0;
                        for (let index = 0; index < ciudades.length; index++) {
                            const auxCiudadExpDef = ciudades[index];
                            // Se configura para que no tenga en cuenta las tildes
                            if (auxCiudadExpDef.ciudad.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
                                auxCant++;
                                if (auxCiudadExpDef.id_ciudad == $('#ciudad_expedicion_empresaria').val()) {
                                    $('#mdc-menu__buscar_ciudad_expedicion_empresaria').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxCiudadExpDef.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudadExpDef.ciudad +'</span></li>');
                                } else {
                                    $('#mdc-menu__buscar_ciudad_expedicion_empresaria').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxCiudadExpDef.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudadExpDef.ciudad +'</span></li>');
                                }
                            }
                            if (auxCant == 10) {
                                break;
                            }
                        }
                        if (!auxCant) {
                            $('#mdc-menu__buscar_ciudad_expedicion_empresaria').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_ciudad_expedicion_empresaria').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                    }
                }
            });

            // Restablece el valor por defecto en el compo de ciudad al quitar el foco del campo
            $('#mdc-ciudad_expedicion_empresaria input').blur(function() {
                if(!$('#mdc-menu__buscar_ciudad_expedicion_empresaria').hasClass('mdc-menu-surface--open')) {
                    ciudad_expedicion_empresaria.value = ciudadExpDef;
                }
                if (ciudadExpDef == '' || ciudadExpDef == null) {
                    $('#clear-ciudad_expedicion_empresaria').hide();
                } else {
                    $('#clear-ciudad_expedicion_empresaria').show();
                }
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
            $('#mdc-ciudad_expedicion_empresaria input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_expedicion_empresaria').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').first().data('value');
                        seleccionarCiudadExp(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_expedicion_empresaria').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_expedicion_empresaria').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_expedicion_empresaria .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    ciudad_expedicion_empresaria.value = ciudadExpDef;
                    $('#mdc-ciudad_expedicion_empresaria input').blur();
                    $('#mdc-menu__buscar_ciudad_expedicion_empresaria').removeClass('mdc-menu-surface--open');
                    if (ciudadExpDef == '' || ciudadExpDef == null) {
                        $('#clear-ciudad_expedicion_empresaria').hide();
                    } else {
                        $('#clear-ciudad_expedicion_empresaria').show();
                    }
                }
                if (ciudadExpDef == '' || ciudadExpDef == null) {
                    $('#clear-ciudad_expedicion_empresaria').hide();
                } else {
                    $('#clear-ciudad_expedicion_empresaria').show();
                }
            });

            // Selecciona la ciudad en la cual se hace click
            $('#mdc-menu__buscar_ciudad_expedicion_empresaria').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarCiudadExp(index, value);
            });

            // Selecciona la primer ciudad de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_ciudad_expedicion_empresaria').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarCiudadExp(index, value);
                }
            });

            // Limpia el campo de ciudad, pero no altera el campo por defecto
            $('#clear-ciudad_expedicion_empresaria').click(function() {
                ciudad_expedicion_empresaria.value = '';
                ciudad_expedicion_empresaria.valid = true;
                $(this).hide();
                $('#mdc-ciudad_expedicion_empresaria input').focus();
            });

            // Selecciona la ciudad con base en el index del listado y el id
            function seleccionarCiudadExp(index, value) {
                if (index === undefined || index === null) {
                    ciudad_expedicion_empresaria.value = ciudadExpDef;
                } else {
                    let auxCiudadExpDef = ciudades[index];
                    ciudadExpDef = auxCiudadExpDef.ciudad;
                    $('#ciudad_expedicion_empresaria').val(value);
                    ciudad_expedicion_empresaria.value = ciudadExpDef;
                }
                $('#mdc-ciudad_expedicion_empresaria input').blur();
                $('#mdc-menu__buscar_ciudad_expedicion_empresaria').removeClass('mdc-menu-surface--open');
                if (ciudadExpDef == '' || ciudadExpDef == null) {
                    $('#clear-ciudad_expedicion_empresaria').hide();
                } else {
                    $('#clear-ciudad_expedicion_empresaria').show();
                }
            }
        }

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
            Acciones para Input de ciudad del referenciador
            03/10/2022
        **/
        {
            // Busca los primeros 10 valores del listado de ciudades que concuerden con lo ingresado en el input
            $('#mdc-ciudad_referenciador input').keyup(function(){
                let busqueda = $(this).val().toUpperCase();
                if(busqueda){
                    $('#clear-ciudad_referenciador').show();
                    $('#mdc-menu__buscar_ciudad_referenciador').addClass('mdc-menu-surface--open');
                    $('#mdc-menu__buscar_ciudad_referenciador').empty();
                    if (ciudades.length) {
                        let auxCant = 0;
                        for (let index = 0; index < ciudades.length; index++) {
                            const auxCiudad = ciudades[index];
                            // Se configura para que no tenga en cuenta las tildes
                            if (auxCiudad.ciudad.normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, ""))) {
                                auxCant++;
                                if (auxCiudad.id_ciudad == $('#ciudad_referenciador').val()) {
                                    $('#mdc-menu__buscar_ciudad_referenciador').append('<li tabindex="0" class="mdc-list-item mdc-list-item--selected red-on-hover" aria-selected="true" data-index="'+ index +'" data-value="'+ auxCiudad.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudad.ciudad +'</span></li>');
                                } else {
                                    $('#mdc-menu__buscar_ciudad_referenciador').append('<li tabindex="0" class="mdc-list-item red-on-hover" data-index="'+ index +'" data-value="'+ auxCiudad.id_ciudad +'" role="option"><span class="mdc-list-item__ripple"></span><span class="mdc-list-item__text">'+ auxCiudad.ciudad +'</span></li>');
                                }
                            }
                            if (auxCant == 10) {
                                break;
                            }
                        }
                        if (!auxCant) {
                            $('#mdc-menu__buscar_ciudad_referenciador').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                        }
                    } else {
                        $('#mdc-menu__buscar_ciudad_referenciador').append('<li class="mdc-list-item cursor-default" role="option"><span class="mdc-list-item__text">No Hay Resultados</span></li>');
                    }
                }
            });

            // Restablece el valor por defecto en el compo de ciudad al quitar el foco del campo
            $('#mdc-ciudad_referenciador input').blur(function() {
                if(!$('#mdc-menu__buscar_ciudad_referenciador').hasClass('mdc-menu-surface--open')) {
                    ciudad_referenciador.value = ciudadRefDef;
                }
                if (ciudadRefDef == '' || ciudadRefDef == null) {
                    $('#clear-ciudad_referenciador').hide();
                } else {
                    $('#clear-ciudad_referenciador').show();
                }
            });

            // Configura las acciones al presionar las teclas Enter, Abajo, Arriba y Esc; mientras el foco está en el input
            $('#mdc-ciudad_referenciador input').keydown(function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_referenciador').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').first().data('value');
                        seleccionarCiudad(index, value);
                    }
                } else if (e.key === 'Down' || e.keyCode === 40) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_referenciador').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').first().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').first().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').first().focus();
                        }
                    }
                } else if (e.key === 'Up' || e.keyCode === 38) {
                    e.preventDefault();
                    if ($('#mdc-menu__buscar_ciudad_referenciador').hasClass('mdc-menu-surface--open')) {
                        let index = $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').last().data('index');
                        let value = $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').last().data('value');
                        if (index != undefined || index != null) {
                            $('#mdc-menu__buscar_ciudad_referenciador .mdc-list-item').last().focus();
                        }
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
                    e.preventDefault();
                    ciudad.value = ciudadRefDef;
                    $('#mdc-ciudad_referenciador input').blur();
                    $('#mdc-menu__buscar_ciudad_referenciador').removeClass('mdc-menu-surface--open');
                    if (ciudadRefDef == '' || ciudadRefDef == null) {
                        $('#clear-ciudad_referenciador').hide();
                    } else {
                        $('#clear-ciudad_referenciador').show();
                    }
                }
                if (ciudadRefDef == '' || ciudadRefDef == null) {
                    $('#clear-ciudad_referenciador').hide();
                } else {
                    $('#clear-ciudad_referenciador').show();
                }
            });

            // Selecciona la ciudad en la cual se hace click
            $('#mdc-menu__buscar_ciudad_referenciador').on('click', '.mdc-list-item', function() {
                let value = $(this).data('value');
                let index = $(this).data('index');
                seleccionarCiudad(index, value);
            });

            // Selecciona la primer ciudad de la lista, en caso de que se oprima Enter mientras el foco está en el input
            $('#mdc-menu__buscar_ciudad_referenciador').on('keydown', '.mdc-list-item', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    let value = $(this).data('value');
                    let index = $(this).data('index');
                    seleccionarCiudad(index, value);
                }
            });

            // Limpia el campo de ciudad, pero no altera el campo por defecto
            $('#clear-ciudad_referenciador').click(function() {
                ciudad_referenciador.value = '';
                ciudad_referenciador.valid = true;
                $(this).hide();
                $('#mdc-ciudad_referenciador input').focus();
            });

            // Selecciona la ciudad con base en el index del listado y el id
            function seleccionarCiudad(index, value) {
                if (index === undefined || index === null) {
                    ciudad_referenciador.value = ciudadRefDef;
                } else {
                    let auxCiudad = ciudades[index];
                    ciudadRefDef = auxCiudad.ciudad;
                    $('#ciudad_referenciador').val(value);
                    ciudad_referenciador.value = ciudadRefDef;
                }
                $('#mdc-ciudad_referenciador input').blur();
                $('#mdc-menu__buscar_ciudad_referenciador').removeClass('mdc-menu-surface--open');
                $('#clear-ciudad_referenciador').show();
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
                        ciudad_referenciador.value = ciudadRefDef;
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
                let url = urlClientesValidarCliente.replace('documento', cedula_empresaria.value).replace('sucursal', '00');
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
                if (!ciudad_expedicion_empresaria.valid || ciudad_expedicion_empresaria.value == null || ciudad_expedicion_empresaria.value == '' || $('#ciudad_expedicion_empresaria').val() == null || $('#ciudad_expedicion_empresaria').val() == '') {
                    ciudad_expedicion_empresaria.valid = false;
                    ciudad_expedicion_empresaria.helperTextContent = 'Seleccione la ciudad de expedición de la cédula del empresario.';
                    M.toast({html: '<span class="mr-3">Error en la ciudad de expedición de la cédula del empresario.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
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
                if (!nombres_referenciador.valid || nombres_referenciador.value == null || nombres_referenciador.value == '') {
                    nombres_referenciador.valid = false;
                    nombres_referenciador.helperTextContent = 'Ingrese los nombres del referenciador.';
                    M.toast({html: '<span class="mr-3">Error en los nombres del referenciador.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!apellidos_referenciador.valid || apellidos_referenciador.value == null || apellidos_referenciador.value == '') {
                    apellidos_referenciador.valid = false;
                    apellidos_referenciador.helperTextContent = 'Ingrese los apellidos del referenciador.';
                    M.toast({html: '<span class="mr-3">Error en los apellidos del referenciador.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono_referenciador.valid || telefono_referenciador.value == null || telefono_referenciador.value == '') {
                    telefono_referenciador.valid = false;
                    telefono_referenciador.helperTextContent = 'Ingrese el teléfono del referenciador.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono del referenciador.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion_referenciador.valid || direccion_referenciador.value == null || direccion_referenciador.value == '') {
                    direccion_referenciador.valid = false;
                    direccion_referenciador.helperTextContent = 'Ingrese la dirección del referenciador.';
                    M.toast({html: '<span class="mr-3">Error en la dirección del referenciador.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!ciudad_referenciador.valid || ciudad_referenciador.value == null || ciudad_referenciador.value == '' || $('#ciudad_referenciador').val() == null || $('#ciudad_referenciador').val() == '') {
                    ciudad_referenciador.valid = false;
                    ciudad_referenciador.helperTextContent = 'Seleccione la ciudad del referenciador.';
                    M.toast({html: '<span class="mr-3">Error en la ciudad del referenciador.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!codigo_cedula_referenciador.valid || codigo_cedula_referenciador.value == null || codigo_cedula_referenciador.value == '') {
                    codigo_cedula_referenciador.valid = false;
                    codigo_cedula_referenciador.helperTextContent = 'Ingrese el código o cédula del referenciador.';
                    M.toast({html: '<span class="mr-3">Error en el código o cédula del referenciador.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!nombres_referencia_familiar_1.valid || nombres_referencia_familiar_1.value == null || nombres_referencia_familiar_1.value == '') {
                    nombres_referencia_familiar_1.valid = false;
                    nombres_referencia_familiar_1.helperTextContent = 'Ingrese los nombres de la referencia familiar 1.';
                    M.toast({html: '<span class="mr-3">Error en los nombres de la referencia familiar 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!apellidos_referencia_familiar_1.valid || apellidos_referencia_familiar_1.value == null || apellidos_referencia_familiar_1.value == '') {
                    apellidos_referencia_familiar_1.valid = false;
                    apellidos_referencia_familiar_1.helperTextContent = 'Ingrese los apellidos de la referencia familiar 1.';
                    M.toast({html: '<span class="mr-3">Error en los apellidos de la referencia familiar 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!parentesco_referencia_familiar_1.valid || parentesco_referencia_familiar_1.value == null || parentesco_referencia_familiar_1.value == '') {
                    parentesco_referencia_familiar_1.valid = false;
                    parentesco_referencia_familiar_1.helperTextContent = 'Ingrese el parentesco de la referencia familiar 1.';
                    M.toast({html: '<span class="mr-3">Error en el parentesco de la referencia familiar 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion_referencia_familiar_1.valid || direccion_referencia_familiar_1.value == null || direccion_referencia_familiar_1.value == '') {
                    direccion_referencia_familiar_1.valid = false;
                    direccion_referencia_familiar_1.helperTextContent = 'Ingrese la dirección de la referencia familiar 1.';
                    M.toast({html: '<span class="mr-3">Error en la dirección de la referencia familiar 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono_referencia_familiar_1.valid || telefono_referencia_familiar_1.value == null || telefono_referencia_familiar_1.value == '') {
                    telefono_referencia_familiar_1.valid = false;
                    telefono_referencia_familiar_1.helperTextContent = 'Ingrese el teléfono de la referencia familiar 1.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono de la referencia familiar 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!nombres_referencia_familiar_2.valid || nombres_referencia_familiar_2.value == null || nombres_referencia_familiar_2.value == '') {
                    nombres_referencia_familiar_2.valid = false;
                    nombres_referencia_familiar_2.helperTextContent = 'Ingrese los nombres de la referencia familiar 2.';
                    M.toast({html: '<span class="mr-3">Error en los nombres de la referencia familiar 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!apellidos_referencia_familiar_2.valid || apellidos_referencia_familiar_2.value == null || apellidos_referencia_familiar_2.value == '') {
                    apellidos_referencia_familiar_2.valid = false;
                    apellidos_referencia_familiar_2.helperTextContent = 'Ingrese los apellidos de la referencia familiar 2.';
                    M.toast({html: '<span class="mr-3">Error en los apellidos de la referencia familiar 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!parentesco_referencia_familiar_2.valid || parentesco_referencia_familiar_2.value == null || parentesco_referencia_familiar_2.value == '') {
                    parentesco_referencia_familiar_2.valid = false;
                    parentesco_referencia_familiar_2.helperTextContent = 'Ingrese el parentesco de la referencia familiar 2.';
                    M.toast({html: '<span class="mr-3">Error en el parentesco de la referencia familiar 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion_referencia_familiar_2.valid || direccion_referencia_familiar_2.value == null || direccion_referencia_familiar_2.value == '') {
                    direccion_referencia_familiar_2.valid = false;
                    direccion_referencia_familiar_2.helperTextContent = 'Ingrese la dirección de la referencia familiar 2.';
                    M.toast({html: '<span class="mr-3">Error en la dirección de la referencia familiar 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono_referencia_familiar_2.valid || telefono_referencia_familiar_2.value == null || telefono_referencia_familiar_2.value == '') {
                    telefono_referencia_familiar_2.valid = false;
                    telefono_referencia_familiar_2.helperTextContent = 'Ingrese el teléfono de la referencia familiar 2.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono de la referencia familiar 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!nombre_referencia_comercial_1.valid || nombre_referencia_comercial_1.value == null || nombre_referencia_comercial_1.value == '') {
                    nombre_referencia_comercial_1.valid = false;
                    nombre_referencia_comercial_1.helperTextContent = 'Ingrese los nombres de la referencia comercial 1.';
                    M.toast({html: '<span class="mr-3">Error en los nombres de la referencia comercial 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion_referencia_comercial_1.valid || direccion_referencia_comercial_1.value == null || direccion_referencia_comercial_1.value == '') {
                    direccion_referencia_comercial_1.valid = false;
                    direccion_referencia_comercial_1.helperTextContent = 'Ingrese la dirección de la referencia comercial 1.';
                    M.toast({html: '<span class="mr-3">Error en la dirección de la referencia comercial 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono_referencia_comercial_1.valid || telefono_referencia_comercial_1.value == null || telefono_referencia_comercial_1.value == '') {
                    telefono_referencia_comercial_1.valid = false;
                    telefono_referencia_comercial_1.helperTextContent = 'Ingrese el teléfono de la referencia comercial 1.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono de la referencia comercial 1.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!nombre_referencia_comercial_2.valid || nombre_referencia_comercial_2.value == null || nombre_referencia_comercial_2.value == '') {
                    nombre_referencia_comercial_2.valid = false;
                    nombre_referencia_comercial_2.helperTextContent = 'Ingrese los nombres de la referencia comercial 2.';
                    M.toast({html: '<span class="mr-3">Error en los nombres de la referencia comercial 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!direccion_referencia_comercial_2.valid || direccion_referencia_comercial_2.value == null || direccion_referencia_comercial_2.value == '') {
                    direccion_referencia_comercial_2.valid = false;
                    direccion_referencia_comercial_2.helperTextContent = 'Ingrese la dirección de la referencia comercial 2.';
                    M.toast({html: '<span class="mr-3">Error en la dirección de la referencia comercial 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }
                if (!telefono_referencia_comercial_2.valid || telefono_referencia_comercial_2.value == null || telefono_referencia_comercial_2.value == '') {
                    telefono_referencia_comercial_2.valid = false;
                    telefono_referencia_comercial_2.helperTextContent = 'Ingrese el teléfono de la referencia comercial 2.';
                    M.toast({html: '<span class="mr-3">Error en el teléfono de la referencia comercial 2.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }

                if (!$('#aceptoConsumidor').is(':checked')) {
                    M.toast({html: '<span class="mr-3">Por favor acepte los términos y condiciones (consumidor).</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    $('#aceptoConsumidor').focus();
                    return false;
                }
                if (!$('#aceptoEmpresarias').is(':checked')) {
                    M.toast({html: '<span class="mr-3">Por favor acepte los términos y condiciones (empresarias).</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    $('#aceptoEmpresarias').focus();
                    return false;
                }
                if (signaturePad.isEmpty()) {
                    M.toast({html: '<span class="mr-3">Por favor firme la solicitud.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                } else {
                    $('#firma_empresaria').val(signaturePad.toDataURL());
                }
                let validacionCliente = await validarCliente();
                if (validacionCliente.cliente) {
                    console.log(validacionCliente.cliente);
                    Swal.fire({
                        title: 'El cliente ya existe',
                        text: 'El documento ' +validacionCliente.sucursal.documento+ ' se encuentra registrado con el nombre: ' +validacionCliente.sucursal.nombre_cliente+ ' y la sucursal ' +validacionCliente.sucursal.sucursal+ ' se encuentra registrada en la dirección ' +validacionCliente.sucursal.direccion+ '.',
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
                title: 'Empresario registrado con éxito',
                text: 'Su usuario y contraseña son: ' + dataSession.cedula + '.',
                icon: 'success',
                onClose: goToHome
            });

            function goToHome() {
                document.location.href='www.avicampo.shop';
            }
            @php
                Session::forget('cliente_creado');
            @endphp
        @elseif (Session::has('cliente_actualizado'))
            let dataSession = JSON.parse('{!! Session::get('cliente_actualizado') !!}');
            Swal.fire({
                title: 'Empresario actualizado con éxito',
                text: 'El empresario con documento ' + dataSession.cedula + ' y nombre ' + dataSession.nombre_cliente + ' se ha actualizado exitosamente.',
                icon: 'success'
            });
            @php
                Session::forget('cliente_actualizado');
            @endphp

        @endif
    </script>
</body>
</html>

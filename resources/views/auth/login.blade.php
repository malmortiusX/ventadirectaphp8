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
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/materialize/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/material.io/material-components-web.min.css') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style>
        :root {
            --mdc-theme-primary: {{ $empresa->color }};
            --mdc-theme-primary-rgb: {{ $empresa->color_rgb }};
            --mdc-theme-secondary: {{ $empresa->color2 }};
            --mdc-theme-secondary-rgb: {{ $empresa->color2_rgb }};
        }
    </style>
</head>
<body>
    <div id="login" class="container-full">
        <div class="row full-height mb-0">
            <div id="background-login" class="col s12 l8 xl9 full-height px-0 hide-on-med-and-down" style="background-color: black">
                <div id="slider-login" class="full-height">
                    <img src="{{ asset($empresa->login) }}" alt="Pollo Asado">
                </div>
            </div>
            <div class="col s12 l4 xl3 full-height valign-wrapper">
                <form method="POST" action="{{ route('auth.authentication') }}" class="full-width px-4" id="login-form">
                @csrf
                    <div class="row my-2">
                        <div class="col s12 mb-2 center">
                            <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo">
                        </div>
                        <div class="col s12 mb-1">
                            <label class="mdc-text-field mdc-text-field--outlined @error('usuario') mdc-text-field--invalid @enderror">
                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_usuario" name="usuario" id="usuario" required @isset($inputs['usuario']) value="{{ $inputs['usuario'] }}" @endisset>
                                <span class="mdc-notched-outline">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="lbl_usuario">Usuario</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                            </label>
                            <div class="mdc-text-field-helper-line">
                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="my-helper-id" aria-hidden="true">
                                    @error('usuario')
                                        El usuario no se encuentra registrado
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col s12 mb-1">
                            <label class="mdc-text-field mdc-text-field--outlined @error('clave') mdc-text-field--invalid @enderror">
                                <input type="password" class="mdc-text-field__input" aria-labelledby="lbl_clave" name="clave" id="clave" required>
                                <span class="mdc-notched-outline">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="lbl_clave">Contraseña</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                            </label>
                            <div class="mdc-text-field-helper-line">
                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="my-helper-id" aria-hidden="true">
                                    @error('clave')
                                        La contraseña es errónea
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col s12 mb-2">
                            <div class="mdc-touch-target-wrapper">
                                <div class="mdc-checkbox mdc-checkbox--touch">
                                    <input type="checkbox" class="mdc-checkbox__native-control" id="remember" name="remember"/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                    <div class="mdc-checkbox__ripple"></div>
                                </div>
                                <label for="remember" class="noselect nowrap">Mantener la sesión iniciada</label>
                            </div>
                        </div>
                        <div class="col s12 center-align mb-2">
                            <button class="mdc-button mdc-button--raised mdc-button--large" id="submit">
                                <span class="mdc-button__label mr-1">Iniciar Sesión</span>
                                <i class="fas fa-sign-in-alt send"></i>
                                <i class="fas fa-spinner sending" style="display: none"></i>
                            </button>
                        </div>
                        <div class="col s12 center-align mb-2">
                            <a style="color: var(--mdc-theme-secondary);" href="#modal_comunicate" class="link modal-trigger">¿Tienes Dudas?</a>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <div id="modal_comunicate" class="modal" style="border-radius: 15px;">
        <div class="container center modal-content modal-fixed-footer">

            <h5>
                ¡COMUNICATE CON NOSOTROS!
            </h5>
            <ul>
                <li><h5>Regional Oriente:<br><a style="color: var(--mdc-theme-secondary);" class="link" href="tel:+573152335626"> 315-2335626 </a></h5></li>
                <li><h5>Regional Costa:<br><a style="color: var(--mdc-theme-secondary);" class="link" href="tel:+573173716454"> 317-3716454 </a></h5></li>
                <li><h5>Regional Eje Cafetero:<br><a style="color: var(--mdc-theme-secondary);" class="link" href="tel:+573206320983"> 320-6320983 </a></h5></li>
            </ul>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendor/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('vendor/material.io/material-components-web.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2@10.js') }}"></script>
    <script type="text/javascript">
        const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
            return new mdc.textField.MDCTextField(el);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.modal').modal();

            var imagenSlider = $('#slider-login img');
            if (imagenSlider.width() < $('#slider-login').width()) {
                imagenSlider.attr('width', '100%');
                imagenSlider.attr('height', 'auto');
            }

            $('#login-form').submit(function(){
                $('#submit').attr('disabled', 'disabled');
                $('#submit .send').hide();
                $('#submit .sending').show();
            });
        });
    </script>
</body>
</html>

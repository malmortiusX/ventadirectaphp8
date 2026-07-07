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

    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/materialize/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/material.io/material-components-web.min.css') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        :root {
            --mdc-theme-primary: {{ $empresa->color }};
            --mdc-theme-primary-rgb: {{ $empresa->color_rgb }};
            --mdc-theme-secondary: {{ $empresa->color2 }};
            --mdc-theme-secondary-rgb: {{ $empresa->color2_rgb }};
        }
        
        .content {
            display: none;
        }

        .content--active {
            display: block;
        }

        button:focus {
            background-color: #fff;
        }

        .mdc-button, .mdc-button.mdc-button--large {
            padding: 25px 30px;
        }

        main {
            max-width: 100%;
            background-size: cover;
            background-position: center;
        }
    </style>
    @yield('styles')
    <title>Consultar Guía de Transporte | Avícola el Madroño</title>
</head>
<body>
    <div id="login" class="container-full">
        <div class="row full-height mb-0">
            <div class="col s12 l4 full-height valign-wrapper justify-content-center">
                <div class="full-width px-4">
                    <div class="mx-auto" style="max-width: 450px;">
                        @yield('content')
                    </div>
                </div>
            </div>
            <div class="col s12 l8 full-height px-0 hide-on-med-and-down" id="guia-content">
                <main class="main-content container-full" id="main-content"  style="background-image: url({{ asset('imagenes/backgrounds/guias.jpg') }})">
                    <section class="div-main">
                        <button class="btn btn-floating btn-large waves-effect waves-light" type="button" id="botonMenu"><i class="fas fa-bars"></i></button>
                    </section>
                    <footer>
                        <div class="row mb-0">
                            <div class="col s12 m6">
                                <Label>Copyright © {{ date('Y') }} | <a class="link" style="color: var(--mdc-theme-secondary);" href="https://avicolaelmadrono.com/" target="_blank">Avicola El Madroño S.A.</a></Label>
                            </div>
                            <div class="col s12 m6 right-align">
                                <Label>Sistema de Consulta de Guías de Transporte</Label>
                            </div>
                        </div>
                    </footer>
                </main>
            </div>
          </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendor/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('vendor/material.io/material-components-web.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
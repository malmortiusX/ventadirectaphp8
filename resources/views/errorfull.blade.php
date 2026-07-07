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

    <title>{{ config('app.name', 'Avicampo') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/materialize/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/material.io/material-components-web.min.css') }}">
    @yield('styles')
    <link href="{{ asset('css/styles.css') }}?1.1.2" rel="stylesheet">
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
    <main class="main-content container-full" id="main-content">
        <section class="div-main">
            <div class="container-full vertical-align">
                <div class="row mb-0">
                    <div class="col s12 center">
                        <h2 class="pt-2 center my-0">Ops!</h2>
                        <img src="{{ asset('imagenes/ilustraciones/404.svg') }}" alt="" sizes="" srcset="" style="width: 450px; max-width:100%;">
                        <p class="pb-2 center my-0 subtitle-1">{!! $mensaje !!}</p>
                    </div>
                </div>
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
    <script>
        var numDecimales = {{ $empresa->decimales }};
        @isset($idMenu)
            $('#{{ $idMenu }}').addClass('mdc-list-item--active');
        @endisset
    </script>
</body>
</html>
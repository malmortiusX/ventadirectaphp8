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
            <div class="container">
                <div class="row">
                    <div class="col s12 center hide-on-med-and-up">
                        <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo">
                    </div>
                    <div class="col s12 m6">
                        <h1 class="title">AUTORIZACIÓN DE USO DE DATOS PERSONALES</h1>
                        <div>
                            AVÍCOLA EL MADROÑO S.A.
                            NIT. 800000276 - 8
                        </div>
                    </div>
                    <div class="col m6 hide-on-small-only pr-5" style ="text-align: right;">
                        <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo mb-0">
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col s12">
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
                        <p class="color-error">Declaro bajo gravedad de juramento que los recursos  no provienen de actividades ilícitas, ni vinculadas con el cultivo, producción o tráfico de estupefacientes, ni actividades contempladas en el Código Penal Colombiano o en cualquier norma que lo modifique o adicione, dando cumplimiento a lo señalado en la Circular 100 - 000005 de Agosto 2016 expedida por la Superintendencia de Sociedades, el Estatuto Anticorrupción (Ley 190 de 1995).</p>
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
</body>
</html>

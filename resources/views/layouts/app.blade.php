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
    <link rel="stylesheet" href="{{ asset('vendor/materialize/css/materialize.css') }}?1.1">
    <link rel="stylesheet" href="{{ asset('vendor/material.io/material-components-web.min.css') }}?2.1">
    @yield('styles')
    <link href="{{ asset('css/styles.css') }}?1.1.6" rel="stylesheet">
    <style>
        :root {
            --mdc-theme-primary: {{ $empresa->color }};
            --mdc-theme-primary-rgb: {{ $empresa->color_rgb }};
            --mdc-theme-secondary: {{ $empresa->color2 }};
            --mdc-theme-secondary-rgb: {{ $empresa->color2_rgb }};
            --mdc-checkbox-checked-color: {{ $empresa->color }};
        }
    </style>
</head>
<body>
    <aside class="mdc-drawer mdc-drawer--dense mdc-drawer--dismissible mdc-drawer--modal" id="menu">
        <div class="mdc-drawer__header">
            <div class="avicampo-avatar center">
                <img src="{{ asset($empresa->logo) }}" alt="">
            </div>
            <p class="subtitle subtitle-3 capitalize center my-0 nowrap">{{ mb_strtolower($usuario->nombres .' '. $usuario->apellidos) }}</p>
            @switch($usuario->nivel)
                @case('u_ventadirecta')
                    <label class="margin-auto">Venta Directa - {{ $usuario->codigo_vendedor }}</label>
                    <label class="margin-auto capitalize">{{ mb_strtolower($usuario->ciudad) }}</label>
                    @break
                @case('u_movil')
                    <label class="margin-auto">Usuario Movil - {{ $usuario->codigo_vendedor }}</label>
                    @break
                @case('u_movil_especial')
                    <label class="margin-auto">Usuario Movil Especial - {{ $usuario->codigo_vendedor }}</label>
                    @break
                @case('u_comercial')
                    <label class="margin-auto">Usuario Comercial - {{ $usuario->codigo_vendedor }}</label>
                    @break
                @case('u_callcenter')
                    <label class="margin-auto">Call Center{{ $usuario->codigo_vendedor ? ' - ' . $usuario->codigo_vendedor : '' }}</label>
                    @break
                @case('u_supervisor')
                    <label class="margin-auto">Supervisor{{ $usuario->codigo_vendedor ? ' - ' . $usuario->codigo_vendedor : '' }}</label>
                    @break
                @case('u_administrador')
                    <label class="margin-auto">Administrador</label>
                    @break
                @case('u_ventas')
                    <label class="margin-auto">Ventas</label>
                    @break
                @default
                    <label class="margin-auto">Usuario</label>
            @endswitch
            <hr class="mb-0 mt-2">
        </div>
        <div class="mdc-drawer__content">
            <div class="mdc-list">
                <a id="dashboard" class="mdc-list-item" href="{{ route('dashboard') }}">
                    <span class="mdc-list-item__ripple"></span>
                    <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/store.png') }}"></i>
                    <span class="mdc-list-item__text">Inicio</span>
                </a>
                @if ($usuario->nivel != 'u_supervisor')
                    <a id="pedidos-create" class="mdc-list-item" href="{{ route('pedidos.create') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/add-to-shopping-cart-e-commerce-button.png') }}"></i>
                        <span class="mdc-list-item__text">Nuevo Pedido</span>
                    </a>
                    @if ($usuario->nivel == 'u_ventadirecta')
                    <a id="abonos-index" class="mdc-list-item" href="{{ route('abonos.index') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/commercial-ticket-of-shopping.png') }}"></i>
                        <span class="mdc-list-item__text">Abonos</span>
                    </a>
                    @endif
                    <a id="pedidos-index" class="mdc-list-item" href="{{ route('pedidos.index') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/commercial-event-on-calendar.png') }}"></i>
                        <span class="mdc-list-item__text">Historial</span>
                    </a>
                    @if ($usuario->nivel == 'u_comercial')
                        <a id="pedidos-misPedidos" class="mdc-list-item" href="{{ route('pedidos.misPedidos') }}">
                            <span class="mdc-list-item__ripple"></span>
                            <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/shopping-bag-with-dollar-sign.png') }}"></i>
                            <span class="mdc-list-item__text">Mis Pedidos</span>
                        </a>
                    @endif
                    @if ($usuario->nivel != 'u_ventadirecta')
                    <a id="productos-index" class="mdc-list-item" href="{{ route('productos.index') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/commercial-ticket-of-shopping.png') }}"></i>
                        <span class="mdc-list-item__text">Ventas por Producto</span>
                    </a>
                    @endif
                @endif
                @if ($usuario->nivel == 'u_movil' || $usuario->nivel == 'u_movil_especial' || $usuario->nivel == 'u_callcenter')
                    <a id="rutero" class="mdc-list-item" href="{{ route('rutero.index') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/timer-or-chronometer.png') }}"></i>
                        <span class="mdc-list-item__text">Rutero</span>
                    </a>
                @endif
                @if ($usuario->nivel == 'u_movil' || $usuario->nivel == 'u_movil_especial' || $usuario->nivel == 'u_supervisor')
                    <a id="encuestas" class="mdc-list-item" href="{{ route('encuesta.show') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/e-commerce-search.png') }}"></i>
                        <span class="mdc-list-item__text">Encuesta</span>
                @endif
                @if($empresa->nombre != 'Italcol')
                    @if ($usuario->nivel == 'u_movil' || $usuario->nivel == 'u_movil_especial' || $usuario->nivel == 'u_comercial' || $usuario->nivel == 'u_administrador')
                        <a id="pedidos-semanales" class="mdc-list-item" href="{{ route('pedidos.semanales.index') }}">
                            <span class="mdc-list-item__ripple"></span>
                            <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/shopping-basket-commercial-tool.png') }}"></i>
                            <span class="mdc-list-item__text">Pedido Semanal</span>
                        </a>
                        @if ($empresa->pqrs)
                            <a id="pqrs" class="mdc-list-item" href="{{ route('pqrs.index') }}">
                                <span class="mdc-list-item__ripple"></span>
                                <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/verified-commercial-list.png') }}"></i>
                                <span class="mdc-list-item__text">PQRS</span>
                            </a>
                        @endif
                        @if ($usuario->crea_clientes == 1)
                            <a id="crear-clientes" class="mdc-list-item" href="{{ route('clientes.create') }}">
                                <span class="mdc-list-item__ripple"></span>
                                <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/call-center-woman.png') }}"></i>
                                <span class="mdc-list-item__text">Crear Cliente</span>
                            </a>
                        @endif
                        @if ($usuario->bloquear_descuento == 0)
                            <a id="descuentos" class="mdc-list-item" href="{{ route('descuentos.index', ['fecha_descuento' => date('Y-m-d')]) }}">
                                <span class="mdc-list-item__ripple"></span>
                                <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/commercial-percentage-discount-label.png') }}"></i>
                                <span class="mdc-list-item__text">Sol. Descuento</span>
                            </a>
                        @endif
                        <a id="sondeos" class="mdc-list-item" href="{{ route('sondeos.index') }}">
                            <span class="mdc-list-item__ripple"></span>
                            <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/e-commerce-search.png') }}"></i>
                            <span class="mdc-list-item__text">Sondeo Precios</span>
                        </a>
                    @endif
                    @if ($usuario->nivel == 'u_supervisor')
                        <a id="sondeos" class="mdc-list-item" href="{{ route('sondeos.index') }}">
                            <span class="mdc-list-item__ripple"></span>
                            <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/e-commerce-search.png') }}"></i>
                            <span class="mdc-list-item__text">Sondeo Precios</span>
                        </a>
                    @endif
                    @if ($usuario->nivel == 'u_ventas')
                        @if ($empresa->pqrs)
                            <a id="pqrs" class="mdc-list-item" href="{{ route('pqrs.index') }}">
                                <span class="mdc-list-item__ripple"></span>
                                <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/verified-commercial-list.png') }}"></i>
                                <span class="mdc-list-item__text">PQRS</span>
                            </a>
                        @endif
                    @endif
                @endif
                @if ($usuario->nivel == 'u_administrador')
                    <a id="encuestas" class="mdc-list-item" href="{{ route('encuesta.show') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/e-commerce-search.png') }}"></i>
                        <span class="mdc-list-item__text">Encuesta</span>
                    </a>
                    <a id="actualizar" class="mdc-list-item" href="{{ route('actualizar') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/circular-arrows-couple.png') }}"></i>
                        <span class="mdc-list-item__text">Actualizar</span>
                    </a>
                    <a id="ipbd" class="mdc-list-item" href="{{ route('ipbd') }}">
                        <span class="mdc-list-item__ripple"></span>
                        <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/cube-outline.png') }}"></i>
                        <span class="mdc-list-item__text">Ip Base de Datos</span>
                    </a>
                @endif
                <a id="logout" class="mdc-list-item" href="{{ url('/logout') }}">
                    <span class="mdc-list-item__ripple"></span>
                    <i class="mdc-list-item__graphic mr-2" aria-hidden="true"><img class="icono" src="{{ asset('vendor/icons/unlocked-circular-padlock.png') }}"></i>
                    <span class="mdc-list-item__text">Cerrar sesión</span>
                </a>
            </div>
        </div>
    </aside>
    <div class="mdc-drawer-scrim"></div>
    <main class="main-content container-full" id="main-content">
        <section class="div-main">
            @yield('content')
            <button class="btn btn-floating btn-large waves-effect waves-light" type="button" id="botonMenu"><i class="fas fa-bars"></i></button>
        </section>
        <footer>
            <div class="row mb-0">
                <div class="col s12 m6">
                    <Label>Copyright © {{ date('Y') }} | <a class="link" style="color: var(--mdc-theme-secondary);" href="https://avicolaelmadrono.com/" target="_blank">Avicola El Madroño S.A.</a></Label>
                </div>
                <div class="col s12 m6 right-align">
                    <Label>Sistema de Pedidos Madroño Móvil | V 2.2.21</Label>
                </div>
            </div>
        </footer>
    </main>
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendor/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('vendor/material.io/material-components-web.min.js') }}?2.1"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2@10.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
    <script>
        // Instantiate MDC Drawer
        const drawerEl = document.querySelector('.mdc-drawer');
        const drawer = new mdc.drawer.MDCDrawer.attachTo(drawerEl);
        if ($( window ).width() > 1200) {
            drawer.open = true;
        } else {
            drawer.open = false;
        }

        document.querySelector('.mdc-drawer-scrim').addEventListener('click', () => {
            drawer.open = !drawer.open;
        });

        document.querySelector('#botonMenu').addEventListener('click', () => {
            drawer.open = !drawer.open;
        });

        $(window).resize(function() {
            if ($( window ).width() > 1200) {
                drawer.open = true;
            } else {
                drawer.open = false;
            }
        });

        var numDecimales = {{ $empresa->decimales }};
    </script>
    @yield('scripts')
</body>
</html>

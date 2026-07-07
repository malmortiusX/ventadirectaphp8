@extends('layouts.app')

@section('content')
    @php
        setlocale(LC_ALL, 'es_ES', 'es', 'ES');
    @endphp
    <form action="{{ route('pedidos.semanales.store') }}" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h1 class="title">Pedidos Semanales</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Pedidos Semanales</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 right-align hide-on-small-only">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="full-width center mb-1">
                                <div class="col s12 center">
                                    <p class="fz-25 mt-0 mb-1">Hola, <b class="capitalize">{{ mb_strtolower($usuario->nombres) }}</b></p>
                                    <p class="fz-18 mb-2 mt-0">Por favor elige una de las siguientes opciones para continuar.</p>
                                </div>
                                <div class="mx-1 mt-2" style="width: 150px; display: inline-block;">
                                    <div class="card highlighted my-0 card-item cursor-pointer" style="background-color: #f2f2f2;" data-url="{{ route('pedidos.semanalescf.create') }}" tabindex="0">
                                        <div class="card-content center relative">
                                            <i class="card-checked-icon fas fa-check-circle"></i>
                                            <div class="card-item-icono no-line-height">
                                                <img src="{{ asset('imagenes/iconos/salchicha.svg') }}" alt="">
                                            </div>
                                            <h3 class="card-title subtitle-3 capitalize font-gilroy mt-1 nowrap noselect" style="margin-bottom: 3px;">Carnes Frías</h3>
                                            <p class="fz-15 nowrap noselect">Semana {{ $semana->weekOfYear }}</p>
                                            <label class="noselect nowrap cursor-pointer">{{ $carnesFrias ? ($carnesFrias->estado ? 'Cerrado' : 'Abierto') : 'Sin Crear' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mx-1 mt-2" style="width: 150px; display: inline-block;">
                                    <div class="card highlighted my-0 card-item cursor-pointer" style="background-color: #f2f2f2;" data-url="{{ route('pedidos.semanales.show', ['semana' => $semana->weekOfYear, 'ano' => $semana->year]) }}" tabindex="0">
                                        <div class="card-content center relative">
                                            <i class="card-checked-icon fas fa-check-circle"></i>
                                            <div class="card-item-icono no-line-height">
                                                <img src="{{ asset('imagenes/iconos/pollo.svg') }}" alt="">
                                            </div>
                                            <h3 class="card-title subtitle-3 capitalize font-gilroy mt-1 nowrap noselect" style="margin-bottom: 3px;">Pollo</h3>
                                            <p class="fz-15 nowrap noselect">Semana {{ $semana->weekOfYear }}</p>
                                            <label class="noselect nowrap cursor-pointer">{{ $polloS1 ? ($polloS1->estado ? 'Cerrado' : 'Abierto') : 'Sin Crear' }}</label>
                                        </div>
                                    </div>
                                </div>
                                <!--div class="mx-1 mt-2" style="width: 150px; display: inline-block;">
                                    <div class="card highlighted my-0 card-item cursor-pointer" style="background-color: #f2f2f2;" data-url="{{ route('pedidos.semanales.show', ['semana' => $semana->weekOfYear + 1, 'ano' => $semana->year]) }}" tabindex="0" {{ $polloS1 ? ($polloS1->estado ? '' : 'disabled') : 'disabled' }}>
                                        <div class="card-content center relative">
                                            <i class="card-checked-icon fas fa-check-circle"></i>
                                            <div class="card-item-icono no-line-height">
                                                <img src="{{ asset('imagenes/iconos/pollo.svg') }}" alt="">
                                            </div>
                                            <h3 class="card-title subtitle-3 capitalize font-gilroy mt-1 nowrap noselect" style="margin-bottom: 3px;">Pollo</h3>
                                            <p class="fz-15 nowrap noselect">Semana {{ $semana->weekOfYear + 1 }}</p>
                                            <label class="noselect nowrap cursor-pointer">{{ $polloS2 ? ($polloS2->estado ? 'Cerrado' : 'Abierto') : 'Sin Crear' }}</label>
                                        </div>
                                    </div>
                                </div-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--div class="col s12 center">
                    <h3 class="fz-20 mb-3">Seleccione un pedido.{{-- $limite->formatLocalized("%A %d de %B del %Y") --}}</h3>
                    <div class="row mb-0">
                        <div class="col s12 m4">
                            <div class="card highlighted card-item">
                                <div class="card-content center">
                                    <img src="{{ asset('imagenes/iconos/pollo.svg') }}" alt="" height="50px">
                                    <span class="card-subtitle subtitle-2 highlighted uppercase">Pollo - S{{ $semana->weekOfYear }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div-->
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('dashboard')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#pedidos-semanales').addClass('mdc-list-item--active');

        $('.card-item').click(function() {
            window.location.href = $(this).data('url');
        });

        $('.card-item').keyup(function(e) {
            if(e.keyCode == 32) {
                $(this).click();
            }
        });
    </script>
@endsection
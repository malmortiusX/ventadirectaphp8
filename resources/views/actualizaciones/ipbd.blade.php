@extends('layouts.app')

@php
    $empresa = App\Models\TblEmpresa::first();
@endphp

@section('styles')
    <style>
        .current blockquote {
            border-color: var(--mdc-theme-secondary);
            color: white;
        }

        .card:not(.current) .ip-bd {
            background-color: rgba(var(--mdc-theme-secondary-rgb), 0.3);
        }

        .current.highlighted .card.ip-bd label {
            color: #828282;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('ipbd') }}" id="form" method="POST">
        @csrf
        <input type="hidden" name="archivo" class="hide" id="archivo">
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Ip Base de Datos</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Ip Base de Datos</a>
                    </div>
                </div>
                <div class="col m6 right-align hide-on-small-only">
                    <a href="{{ route('dashboard') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                @forelse ($archivos as $archivo)
                    <div class="col s12 m6 l4 xl3">
                        <div class="card highlighted {{ $archivo['nombre'] == $actual ? 'bg-primary current' : '' }}">
                            <div class="card-content">
                                <blockquote class="mt-0 pl-2">
                                    <h3 class="subtitle subtitle-2">{{ $archivo['nombre'] }}</h3>
                                </blockquote>
                                <div class="card ip-bd">
                                    <div class="card-content px-2 py-1">
                                        <label>Base de Datos Principal</label>
                                        <div class="d-flex">
                                            <div style="width: 50%;">{{ $archivo['servidor_bd'] }}</div>
                                            <div style="width: 50%;">{{ $archivo['nombre_bd'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card ip-bd">
                                    <div class="card-content px-2 py-1">
                                        <label>Base de Datos PQRS</label>
                                        <div class="d-flex">
                                            <div style="width: 50%;">{{ $archivo['servidor_bdpqrs'] }}</div>
                                            <div style="width: 50%;">{{ $archivo['nombre_bdpqrs'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if ($archivo['nombre'] == $actual)
                                    <div class="d-flex valign-wrapper" style="height: 30px;">
                                        <label class="mb-0"><i class="fal fa-check mr-1"></i> Este es el archivo actual</label>
                                    </div>
                                @else
                                    <button type="button" data-nombre="{{ $archivo['nombre'] }}" class="mdc-button mdc-button--raised mdc-button--dense activar-env">
                                        <span class="mdc-button__label">Activar</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col s12 m6 l4 xl3">
                        <div class="card highlighted bg-primary current">
                            <div class="card-content">
                                <blockquote class="mt-0 pl-2">
                                    <h3 class="subtitle subtitle-2">.env</h3>
                                </blockquote>
                                <div class="card ip-bd">
                                    <div class="card-content px-2 py-1">
                                        <label>Base de Datos Principal</label>
                                        <div class="d-flex">
                                            <div style="width: 50%;">{{ env('DB_HOST') }}</div>
                                            <div style="width: 50%;">{{ env('DB_DATABASE') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card ip-bd">
                                    <div class="card-content px-2 py-1">
                                        <label>Base de Datos PQRS</label>
                                        <div class="d-flex">
                                            <div style="width: 50%;">{{ env('PQRS_HOST') }}</div>
                                            <div style="width: 50%;">{{ env('PQRS_DATABASE') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex valign-wrapper" style="height: 30px;">
                                    <label class="mb-0"><i class="fal fa-check mr-1"></i> Este es el archivo actual</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </form>
    <div class="cargando noselect px-5 center" id="guardando" style="display: none">
        <div id="html-spinner"></div>
        <span class="title mt-1">Actualizando Ip de la Base de Datos</span>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Activa la sección en la barra lateral 
            $('#ipbd').addClass('mdc-list-item--active');

            // Muestra el div de actualizando
            $('.activar-env').on('click', async function(e) {
                let nombre = $(this).data('nombre');
                Swal.fire({
                    title: '¿Cambiar Archivo?',
                    text: "Cambiar el archivo de entorno puede causar pérdida de información. Está seguro?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '{{ $empresa->color }}',
                    confirmButtonText: 'Si, cambiar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#guardando').show();
                        $('body').css('overflow', 'hidden');
                        $('.activar-env').attr('disabled', 'disabled');
                        $('#archivo').val(nombre);
                        $('#form').submit();
                    }
                });
            });
        });
    </script>
@endsection
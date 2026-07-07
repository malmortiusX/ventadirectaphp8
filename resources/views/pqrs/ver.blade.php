@extends('layouts.app')

@section('styles')
    <style>
        #btn-buscar-cliente {
            font-size: 18px;
            transform: scale(0.9);
            transition: 0.3s;
        }

        #btn-buscar-cliente:hover {
            transform: scale(1);
            color: var(--mdc-theme-primary, #ff0000);
        }

        #mdc-dialog-clientes .mdc-dialog__container {
            align-items: flex-start;
            padding: 5% 0;
        }

        tr.data-cliente {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    @php
        setlocale(LC_ALL, 'es_MX', 'es', 'ES');
    @endphp
    <form action="{{ route('pqrs.store') }}" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6 l6">
                    <h1 class="title">PQR #{{ $pqr->id }}</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">PQR</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 right-align hide-on-small-only">
                    <a href="{{ route('pqrs.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title mb-3">Detalles de la Solicitud</span>
                            <div class="row mb-0">

                                <div class="col s12 mb-2">
                                    <label>Estado</label>
                                    <span class="card-subtitle highlighted capitalize">
                                        @switch($pqr->status)
                                            @case("10")
                                                Nueva
                                                @break

                                            @case("20")
                                                Falta Información
                                                @break

                                            @case("50")
                                                Asignada
                                                @break

                                            @case("90")
                                                Cerrada
                                                @break

                                            @default
                                                -
                                        @endswitch
                                    </span>
                                </div>

                                <div class="col s12 mb-2">
                                    <label>Resumen</label>
                                    <span class="card-subtitle highlighted capitalize">{{ mb_strToLower($pqr->summary) }}</span>
                                </div>

                                <div class="col s12 mb-2">
                                    <label>Descripción</label>
                                    <span class="card-subtitle highlighted capitalize">{{ mb_strToLower($pqrDescripcion->description) }}</span>
                                </div>

                                @foreach ($pqrCampos as $pqrCampo)
                                    @if ($pqrCampo->field_id == 29 || $pqrCampo->field_id == 21)

                                        <div class="col s12 mb-2">
                                            <label>{{ ucfirst(mb_strToLower($pqrCampo->name)) }}</label>
                                            <span class="card-subtitle highlighted capitalize">{{ date('m/d/Y', $pqrCampo->value) }}</span>
                                        </div>

                                    @else

                                        <div class="col s12 mb-2">
                                            <label>{{ ucfirst(mb_strToLower($pqrCampo->name)) }}</label>
                                            <span class="card-subtitle highlighted capitalize">{{ mb_strToLower($pqrCampo->value) }}</span>
                                        </div>

                                    @endif

                                @endforeach

                                @if ($pqrAdjuntos)

                                    <div class="col s12 mb-2">
                                        <label>Archivos adjuntos</label>
                                        @foreach ($pqrAdjuntos as $pqrAdjunto)
                                            <span class="card-subtitle highlighted capitalize">
                                                <object data="data:{{ $pqrAdjunto->file_type }};base64,{{ base64_encode( $pqrAdjunto->content ) }}" type="{{ $pqrAdjunto->file_type }}" style="height:400px;width:100%"></object>
                                            </span>
                                        @endforeach
                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('pqrs.index')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

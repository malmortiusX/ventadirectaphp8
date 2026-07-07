@extends('layouts.guias')
@php
    $empresa = \App\Models\TblEmpresa::first();
    setlocale(LC_ALL, 'es_ES');
    \Carbon\Carbon::setLocale('es');
@endphp

@section('styles')
    <title>Resultados de Búsqueda | Consultar Guía de Transporte | Avícola el Madroño</title>
    <style>
        .mdc-chip .mdc-chip__icon--leading:not(.mdc-chip__icon--leading-hidden) {
            font-size: 16px;
            line-height: 20px;
            margin-right: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="row my-2">
        <div class="col s12 mb-2 center">
            <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo">
            <h3 class="subtitle subtitle-2 mb-0 mt-1" style="font-family: 'Gilroy';">GUÍAS DE TRANSPORTE</h3>
        </div>
        <div class="col s12 center">
            <div class="mdc-chip mdc-chip--selected noselect">
                <i class="mdc-chip__icon mdc-chip__icon--leading fal fa-truck-moving"></i>
                <div class="mdc-chip__text">{{ $placa }}</div>
            </div>
            <div class="mdc-chip mdc-chip--selected noselect">
                <i class="mdc-chip__icon mdc-chip__icon--leading fal fa-calendar-day"></i>
                <div class="mdc-chip__text">{{ $fecha->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>
    <div class="row mb-0 mt-1">
        <div class="col s12">
            <div class="mdc-data-table mdc-data-table--dense full-width" id="mdc-table-clientes">
                <div class="mdc-data-table__table-container">
                    <table class="mdc-data-table__table">
                        <thead>
                            <tr class="mdc-data-table__header-row">
                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Factura</th>
                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Cliente</th>
                            </tr>
                        </thead>
                        <tbody class="mdc-data-table__content">
                            @foreach ($guias as $guia)
                                <tr class="mdc-data-table__row">
                                    <td class="mdc-data-table__cell">
                                        <a class="link color-primary" href="{{ route('guias.pdf', ['factura' => trim($guia->COP) .'F'. trim($guia->DCTO)]) }}">{{ trim($guia->COP) .'F'. trim($guia->DCTO) }}</a>
                                    </td>
                                    <td class="mdc-data-table__cell">{{ trim($guia->NOMCLIENTE) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col s12 center-align mt-2">
            <a class="mdc-button mdc-button--raised mdc-button--large" href="{{ route('guias.search') }}">
                <span class="mdc-button__label fz-15 mr-1">Volver</span>
                <i class="fal fa-undo fz-15 send"></i>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@endsection
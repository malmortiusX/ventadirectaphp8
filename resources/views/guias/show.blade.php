@extends('layouts.guias')
@php
    $empresa = \App\Models\TblEmpresa::first();
    setlocale(LC_ALL, 'es_ES');
    \Carbon\Carbon::setLocale('es');
@endphp

@section('styles')
    <title>Consultar Guía de Transporte | Avícola el Madroño</title>
@endsection

@section('content')
    <div class="row my-2">
        <div class="col s12 mb-2 center">
            <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo">
            <h3 class="subtitle subtitle-2 mb-0 mt-1" style="font-family: 'Gilroy';">CONSULTAR GUÍA DE TRANSPORTE</h3>
        </div>
    </div>
    <div class="row mb-0 mt-1">
        <div class="col s12">
            <div class="mdc-tab-bar mb-5 white" role="tablist">
                <div class="mdc-tab-scroller">
                    <div class="mdc-tab-scroller__scroll-area">
                        <div class="mdc-tab-scroller__scroll-content">
                            <button class="mdc-tab mdc-tab--active mdc-tab--stacked" role="tab" aria-selected="true" tabindex="0" style="width: 50%;">
                                <span class="mdc-tab__content">
                                    <span class="mdc-tab__text-label" style="font-size: 10px">POR</span>
                                    <span class="mdc-tab__text-label">N° DE FACTURA</span>
                                </span>
                                <span class="mdc-tab-indicator mdc-tab-indicator--active">
                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                </span>
                                <span class="mdc-tab__ripple"></span>
                            </button>
                            <button class="mdc-tab mdc-tab--stacked" role="tab" aria-selected="true" tabindex="0" style="width: 50%;">
                                <span class="mdc-tab__content">
                                    <span class="mdc-tab__text-label" style="font-size: 10px">POR</span>
                                    <span class="mdc-tab__text-label">VEHÍCULO Y FECHA</span>
                                </span>
                                <span class="mdc-tab-indicator">
                                    <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
                                </span>
                                <span class="mdc-tab__ripple"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="GET" action="{{ route('guias.search') }}" id="form">
                <div class="content {{ (isset($factura) && isset($placa) && isset($fecha)) ? ($factura ? 'content--active' : '') : ($fecha && $placa ? '' : 'content--active') }}" style="height: 260px;">
                    <div class="row mb-0">
                        <div class="col s12">
                            <label class="mdc-text-field mdc-text-field--outlined" id="mdc-input-factura">
                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_factura" name="factura" id="factura" required>
                                <span class="mdc-notched-outline">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="lbl_factura">Número de Factura</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                            </label>
                            <div class="mdc-text-field-helper-line">
                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="mdc-input-helper-factura" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="col s12 center-align mt-2">
                            <button class="mdc-button mdc-button--raised mdc-button--large" id="submit">
                                <span class="mdc-button__label fz-15 mr-1">Rastrear</span>
                                <i class="fal fa-truck-moving fz-15 send"></i>
                                <i class="fas fa-spinner fz-15 sending" style="display: none"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="content {{ (isset($factura) && isset($placa) && isset($fecha)) ? ($factura ? '' : ($fecha || $placa ? 'content--active' : '')) : (isset($placa) || isset($fecha) ? 'content--active' : '') }}" style="height: 260px;">
                    <div class="row mb-0">
                        <div class="col s12 mb-1">
                            <label class="mdc-text-field mdc-text-field--outlined" id="mdc-input-placa">
                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_placa" name="placa" id="placa" required disabled>
                                <span class="mdc-notched-outline">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="lbl_placa">Placa del Vehículo</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                            </label>
                            <div class="mdc-text-field-helper-line">
                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="mdc-input-helper-placa" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="col s12">
                            <label class="mdc-text-field mdc-text-field--outlined" id="mdc-input-fecha">
                                <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha" name="fecha" id="fecha" required disabled>
                                <span class="mdc-notched-outline">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="lbl_fecha">Fecha de Entrega</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                            </label>
                            <div class="mdc-text-field-helper-line">
                                <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg" id="mdc-input-helper-fecha" aria-hidden="true"></div>
                            </div>
                        </div>
                        <div class="col s12 center-align mt-2">
                            <button class="mdc-button mdc-button--raised mdc-button--large" id="submit_2">
                                <span class="mdc-button__label fz-15 mr-1">Rastrear</span>
                                <i class="fal fa-truck-moving fz-15 send"></i>
                                <i class="fas fa-spinner fz-15 sending" style="display: none"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Declaración de elementos de material.io (Mismo orden en el que se renderizan)
            const factura = new mdc.textField.MDCTextField(document.querySelector('#mdc-input-factura'));
            const placa = new mdc.textField.MDCTextField(document.querySelector('#mdc-input-placa'));
            const fecha = new mdc.textField.MDCTextField(document.querySelector('#mdc-input-fecha'));
            var tabBar = new mdc.tabBar.MDCTabBar(document.querySelector('.mdc-tab-bar'));
            var contentEls = document.querySelectorAll('.content');

            tabBar.listen('MDCTabBar:activated', function(event) {
                // Hide currently-active content
                document.querySelector('.content--active').classList.remove('content--active');

                // Show content for newly-activated tab
                if (event.detail.index) {
                    factura.disabled = true;
                    placa.disabled = false;
                    fecha.disabled = false;
                } else {
                    factura.disabled = false;
                    placa.disabled = true;
                    fecha.disabled = true;
                }
                contentEls[event.detail.index].classList.add('content--active');
            });

            @if(isset($factura) && isset($placa) && isset($fecha))
                @if ($factura)
                    tabBar.activateTab(0);
                @elseif($fecha && $placa)
                    tabBar.activateTab(1);
                @endif
            @else
            @if (isset($factura) && $factura)
                    tabBar.activateTab(0);
                @elseif((isset($fecha) && $fecha) || (isset($placa) && $placa))
                    tabBar.activateTab(1);
                @endif
            @endif

            $(document).keydown(function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    $('#submit').click();
                }
            })

            @isset($errorFactura)
                factura.value = '{{ $factura }}';
                factura.valid = false;
                factura.helperTextContent = '{{ $errorFactura }}';
                M.toast({html: '<span class="mr-3">{{ $errorFactura }}.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
            @endisset

            @isset($errorPlaca)
                placa.value = '{{ $placa }}';
                placa.valid = false;
                fecha.value = '{{ $fecha->format("Y-m-d") }}';
                fecha.valid = false;
                M.toast({html: '<span class="mr-3">{{ $errorPlaca }}.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
            @endisset
        });
    </script>
@endsection

@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.6/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    @php
        setlocale(LC_TIME, "spanish");
        setlocale(LC_MONETARY, 'it_IT');
    @endphp
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Encuesta</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Encuesta</a>
                    </div>
                </div>
                <div class="col m6 right-align hide-on-small-only">
                    <a href="{{ route('dashboard') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="row">
                        <div class="col s12 relative">
                            <div class="card highlighted">
                                <div class="card-content">
                                    <div class="row mb-0">
                                        <div class="col s12">
                                            <ul class="mdc-list" role="radiogroup">
                                                <li class="mdc-list-item" role="radio" aria-checked="false" id="aceite">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__graphic">
                                                    <div class="mdc-radio">
                                                        <input class="mdc-radio__native-control"
                                                            type="radio"
                                                            id="list-radio-item-1"
                                                            name="list-radio-item-group"
                                                            value="1">
                                                        <div class="mdc-radio__background">
                                                        <div class="mdc-radio__outer-circle"></div>
                                                        <div class="mdc-radio__inner-circle"></div>
                                                        </div>
                                                    </div>
                                                    </span>
                                                    <label class="mdc-list-item__text" for="list-radio-item-1" style="width: 100%;">Conocimiento Mercado de Aceite</label>
                                                </li>
                                                <li class="mdc-list-item" role="radio" aria-checked="false" id="mortadela">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__graphic">
                                                    <div class="mdc-radio">
                                                        <input class="mdc-radio__native-control"
                                                            type="radio"
                                                            id="list-radio-item-2"
                                                            name="list-radio-item-group"
                                                            value="2">
                                                        <div class="mdc-radio__background">
                                                        <div class="mdc-radio__outer-circle"></div>
                                                        <div class="mdc-radio__inner-circle"></div>
                                                        </div>
                                                    </div>
                                                    </span>
                                                    <label class="mdc-list-item__text" for="list-radio-item-2" style="width: 100%;">Satisfacción Mortadela Jamona</label>
                                                </li>
                                                <li class="mdc-list-item" role="radio" aria-checked="false" id="helado">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__graphic">
                                                    <div class="mdc-radio">
                                                        <input class="mdc-radio__native-control"
                                                            type="radio"
                                                            id="list-radio-item-3"
                                                            name="list-radio-item-group"
                                                            value="3">
                                                        <div class="mdc-radio__background">
                                                        <div class="mdc-radio__outer-circle"></div>
                                                        <div class="mdc-radio__inner-circle"></div>
                                                        </div>
                                                    </div>
                                                    </span>
                                                    <label class="mdc-list-item__text" for="list-radio-item-3" style="width: 100%;">Encuesta Helados</label>
                                                </li>
                                                <li class="mdc-list-item" role="radio" aria-checked="false" id="exito">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__graphic">
                                                    <div class="mdc-radio">
                                                        <input class="mdc-radio__native-control"
                                                            type="radio"
                                                            id="list-radio-item-4"
                                                            name="list-radio-item-group"
                                                            value="4">
                                                        <div class="mdc-radio__background">
                                                        <div class="mdc-radio__outer-circle"></div>
                                                        <div class="mdc-radio__inner-circle"></div>
                                                        </div>
                                                    </div>
                                                    </span>
                                                    <label class="mdc-list-item__text" for="list-radio-item-4" style="width: 100%;">Encuesta Foto Éxito Aliados Minimercados</label>
                                                </li>
                                                <li class="mdc-list-item" role="radio" aria-checked="false" id="materialPop">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__graphic">
                                                    <div class="mdc-radio">
                                                        <input class="mdc-radio__native-control"
                                                            type="radio"
                                                            id="list-radio-item-5"
                                                            name="list-radio-item-group"
                                                            value="5">
                                                        <div class="mdc-radio__background">
                                                        <div class="mdc-radio__outer-circle"></div>
                                                        <div class="mdc-radio__inner-circle"></div>
                                                        </div>
                                                    </div>
                                                    </span>
                                                    <label class="mdc-list-item__text" for="list-radio-item-5" style="width: 100%;">Encuesta Colocación de Material POP y Exhibición</label>
                                                </li>
                                                <li class="mdc-list-item" role="radio" aria-checked="false" id="merchCF">
                                                    <span class="mdc-list-item__ripple"></span>
                                                    <span class="mdc-list-item__graphic">
                                                    <div class="mdc-radio">
                                                        <input class="mdc-radio__native-control"
                                                            type="radio"
                                                            id="list-radio-item-6"
                                                            name="list-radio-item-group"
                                                            value="5">
                                                        <div class="mdc-radio__background">
                                                        <div class="mdc-radio__outer-circle"></div>
                                                        <div class="mdc-radio__inner-circle"></div>
                                                        </div>
                                                    </div>
                                                    </span>
                                                    <label class="mdc-list-item__text" for="list-radio-item-6" style="width: 100%;">PORCICAMPO MERCH 2024 ORIENTE</label>
                                                </li>
                                            </ul>
                                            <div id="divEncuesta">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
    $('#encuestas').addClass('mdc-list-item--active');

    $('document').ready(function(){
        $('#aceite').click(function(){
            var stringAceite = "<iframe src='https://docs.google.com/forms/d/e/1FAIpQLSfJc5Bfl2n5c1yQRZyhAAXu0SWUT-id2CQmrATQagbl5VECAQ/viewform?embedded=true' width='100%' height='1204' frameborder='0' marginheight='0' marginwidth='0'>Cargando…</iframe>";
            $('#divEncuesta').html(stringAceite);
        });

        $('#mortadela').click(function(){
            var stringMortadela = "<iframe src='https://docs.google.com/forms/d/e/1FAIpQLSd0kPMWPXLtoprYVlhLXi1XvvGPRgZ7XB7oXz-DHPfSxCSQGw/viewform?embedded=true' width='100%' height='1204' frameborder='0' marginheight='0' marginwidth='0'>Cargando…</iframe>";
            $('#divEncuesta').html(stringMortadela);
        });

        $('#helado').click(function(){
            var stringHelado = "<iframe src='https://docs.google.com/forms/d/e/1FAIpQLSfR_rOtRSMYzYjlJWyGi97zHDlztz_CLjAzLsaAFr3DkESGfw/viewform?embedded=true' width='100%' height='1204' frameborder='0' marginheight='0' marginwidth='0'>Cargando…</iframe>";
            $('#divEncuesta').html(stringHelado);
        });

        $('#exito').click(function(){
            var stringExito = "<iframe src='https://docs.google.com/forms/d/e/1FAIpQLSfouApOgHc81_eSoN-QTQfbRC3lOFUaSvzA8CP247e9Sm0piw/viewform?embedded=true' width='100%' height='1204' frameborder='0' marginheight='0' marginwidth='0'>Cargando…</iframe>";
            $('#divEncuesta').html(stringExito);
        });

        $('#materialPop').click(function(){
            var stringPod = "<iframe src='https://docs.google.com/forms/d/e/1FAIpQLScKyL_J5enzG6CA7iyWXqrPorr-dadUeoxixbLexSlxhIvoVQ/viewform?embedded=true' width='100%' height='1204' frameborder='0' marginheight='0' marginwidth='0'>Cargando…</iframe>";
            $('#divEncuesta').html(stringPod);
        });

        $('#merchCF').click(function(){
            var stringMerchCF = "<iframe src='https://docs.google.com/forms/d/e/1FAIpQLSdDfWYpWjK4dWykKybRy0OWPvf73VOM6uLqRD5-JbXY-g7NCw/viewform?embedded=true' width='100%' height='1204' frameborder='0' marginheight='0' marginwidth='0'>Cargando…</iframe>";
            $('#divEncuesta').html(stringMerchCF);
        });

    });

</script>
@endsection

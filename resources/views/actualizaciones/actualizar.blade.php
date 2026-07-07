@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <form action="{{ route('actualizar') }}" id="form" method="POST">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 m6">
                    <h1 class="title">Actualizar</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Actualizaciones</a>
                    </div>
                </div>
                <div class="col m6 right-align hide-on-small-only">
                    <a href="{{ route('dashboard') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large actualizar" id="actualizar" type="submit">
                        <span class="mdc-button__label mr-1">Actualizar</span>
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted bg-primary white-text">
                        <div class="card-content">
                            <span class="card-title mb-0">Hay cambios en {{ count($detalles) / 2 }} Archivo{{ count($detalles) / 2 == 1 ? '' : 's' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="mdc-data-table mdc-data-table--dense full-width card">
                        <div class="mdc-data-table__table-container">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                    <tr class="mdc-data-table__header-row">
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Archivo</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Tipo</th>
                                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                    @for ($i = 0; $i < count($detalles); $i=$i+2)
                                        <tr class="mdc-data-table__row">
                                            <td class="mdc-data-table__cell" scope="row">
                                                @if (substr($detalles[$i], 6) == substr($detalles[$i+1], 6) || str_contains($detalles[$i+1], 'dev/null'))
                                                    <pre class="my-0">{{ substr($detalles[$i], 6) }}</pre>
                                                @else
                                                    <pre class="my-0">{{ substr($detalles[$i+1], 6) }}</pre>
                                                @endif
                                            </td>
                                            <td class="mdc-data-table__cell">
                                                @if (str_contains($detalles[$i], 'Controllers') || str_contains($detalles[$i+1], 'Controllers'))
                                                    Controlador
                                                @elseif (str_contains($detalles[$i], 'views') || str_contains($detalles[$i+1], 'views'))
                                                    Vista
                                                @elseif (str_contains($detalles[$i], 'Models') || str_contains($detalles[$i+1], 'Models'))
                                                    Modelo
                                                @elseif (str_contains($detalles[$i], 'Middleware') || str_contains($detalles[$i+1], 'Middleware'))
                                                    Middleware
                                                @else
                                                    Otro
                                                @endif
                                            </td>
                                            <td class="mdc-data-table__cell">
                                                @if (substr($detalles[$i], 6) == substr($detalles[$i+1], 6))
                                                    <div class="chip-estado noselect white-text center yellow darken-3" style="min-width: 80px; max-width: 100px;">Modificado</div>
                                                @elseif (str_contains($detalles[$i+1], 'dev/null'))
                                                    <div class="chip-estado noselect white-text center blue" style="min-width: 80px; max-width: 100px;">Creado</div>
                                                @else
                                                    <div class="chip-estado noselect white-text center red" style="min-width: 80px; max-width: 100px;">Borrado</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <a href="{{ route('dashboard') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir_mv">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large actualizar" id="actualizar_mv" type="submit">
                        <span class="mdc-button__label mr-1">Actualizar</span>
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="cargando noselect px-5 center" id="guardando" style="display: none">
        <div id="html-spinner"></div>
        <span class="title mt-1">Descargando Actualizaciones</span>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Activa la sección en la barra lateral 
            $('#actualizar').addClass('mdc-list-item--active');

            // Muestra el div de actualizando
            $('.actualizar').on('click', async function(e) {
                $('#guardando').show();
                $('body').css('overflow', 'hidden');
                $('.actualizar').attr('disabled', 'disabled');
                $('#form').submit();
            });

            // Muestra la alerta de creación
            @if (Session::has('actualizacion'))
                let dataSession = JSON.parse('{!! Session::get('actualizacion') !!}');
                console.log(dataSession);
                Swal.fire({
                    title: 'Sistema Actualizado',
                    text: 'El sistema se actualizó correctamente.',
                    icon: 'success'
                });
                @php
                    Session::forget('actualizacion');
                @endphp
            @endif
        });
    </script>
@endsection
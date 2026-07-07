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
                    <h1 class="title">Nueva PQRS</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a class="breadcrumb">Nuevo PQRS</a>
                    </div>
                </div>
                <div class="col s12 m6 l6 right-align hide-on-small-only">
                    <a href="{{ route('pqrs.index') }}" class="mdc-button mdc-button--outlined mdc-button--large" id="salir">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large" id="enviar_pedido" type="submit">
                        <span class="mdc-button__label mr-1">Guardar PQRS</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title mb-3">Detalles de la Solicitud</span>
                            <div class="row mb-0">
                                @foreach ($opciones as $key => $opcion)
                                    @if ($opcion->type == 3)
                                        <div class="col s12 m4 mb-1">
                                            <div class="mdc-select mdc-select--outlined mdc-select--dense {{ $opcion->require_report ? 'mdc-select--required' : '' }}" id="mdc-select__{{ 'custom_field_' . $opcion->id }}">
                                                <div class="mdc-select__anchor" aria-labelledby="outlined-select-label" {{ $opcion->require_report ? 'aria-required="true"' : '' }}>
                                                    <input type="text" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" class="mdc-select__input-value">
                                                    <span id="{{ 'custom_field_' . $opcion->id }}__selected-text" class="mdc-select__selected-text"></span>
                                                    <span class="mdc-select__dropdown-icon">
                                                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                        </svg>
                                                    </span>
                                                    <span class="mdc-notched-outline">
                                                        <span class="mdc-notched-outline__leading"></span>
                                                        <span class="mdc-notched-outline__notch">
                                                            <span id="outlined-select-label" class="mdc-floating-label">{{ ucfirst(mb_strtolower($opcion->name)) }}</span>
                                                        </span>
                                                        <span class="mdc-notched-outline__trailing"></span>
                                                    </span>
                                                </div>
                                                <!-- Other elements from the select remain. -->
                                                <div class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox">
                                                    <ul class="mdc-list">
                                                        <li class="mdc-list-item mdc-list-item--selected mdc-list-item--disabled" aria-selected="true" aria-disabled="true" data-value="" role="option" style="display: none;"></li>
                                                        @foreach ($opcion->possible_values as $value)
                                                            <li class="mdc-list-item" data-value="{{ $value }}" role="option">
                                                                <span class="mdc-list-item__ripple"></span>
                                                                <span class="mdc-list-item__text">{{ ucfirst(mb_strtolower($value)) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mdc-text-field-helper-line">
                                                <div class="mdc-text-field-helper-text" aria-hidden="false"></div>
                                            </div>
                                        </div>
                                    @else

                                        <div class="col s12 m4 mb-1">
                                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-text-field__{{ 'custom_field_' . $opcion->id }}">
                                                <span class="mdc-notched-outline">
                                                    <span class="mdc-notched-outline__leading"></span>
                                                    <span class="mdc-notched-outline__notch">
                                                        <span class="mdc-floating-label" id="lbl_{{ 'custom_field_' . $opcion->id }}">{{ ucfirst(mb_strtolower($opcion->name)) }}</span>
                                                    </span>
                                                    <span class="mdc-notched-outline__trailing"></span>
                                                </span>
                                                @if ($cliente)
                                                    @switch($opcion->id)
                                                        @case(6)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($cliente->nombre_cliente) }}">
                                                            <i id="btn-buscar-cliente" class="far fa-search mdc-text-field__icon mdc-text-field__icon--trailing" tabindex="0" role="button"></i>
                                                            @break
                                                        @case(9)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($cliente->direccion) }}">
                                                            @break
                                                        @case(10)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($cliente->telefono) }}">
                                                            @break
                                                        @case(12)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->nombres .' '. $usuario->apellidos) }}" readonly>
                                                            @break
                                                        @case(13)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ $usuario->nivel == 'u_administrador' ? 'Sistemas' : 'Vendedor' }}">
                                                            @break
                                                        @case(14)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->telefono) }}">
                                                            @break
                                                        @case(40)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($cliente->cc_nit) }}">
                                                            @break
                                                        @case(42)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->correo) }}" readonly>
                                                            @break
                                                        @case(61)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->codigo_vendedor) }}" readonly>
                                                            @break
                                                        @default
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }}>
                                                    @endswitch

                                                @else

                                                    @switch($opcion->id)
                                                        @case(6)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="">
                                                            <i id="btn-buscar-cliente" class="far fa-search mdc-text-field__icon mdc-text-field__icon--trailing" tabindex="0" role="button"></i>
                                                            @break
                                                        @case(12)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->nombres .' '. $usuario->apellidos) }}" readonly>
                                                            @break
                                                        @case(13)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ $usuario->nivel == 'u_administrador' ? 'Sistemas' : 'Vendedor' }}">
                                                            @break
                                                        @case(14)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->telefono) }}">
                                                            @break
                                                        @case(22)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }}>
                                                            @break
                                                        @case(42)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->correo) }}" readonly>
                                                            @break
                                                        @case(61)
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }} value="{{ trim($usuario->codigo_vendedor) }}" readonly>
                                                            @break
                                                        @default
                                                            <input type="{{ $types[$opcion->type] }}" class="mdc-text-field__input" aria-labelledby="lbl_{{ 'custom_field_' . $opcion->id }}" name="{{ 'custom_field_' . $opcion->id }}" id="{{ 'custom_field_' . $opcion->id }}" {{ $opcion->type == 0 ? 'maxlength=255' : ''}} {{ $opcion->require_report ? 'required' : '' }}>
                                                    @endswitch

                                                @endif

                                            </label>

                                            <div class="mdc-text-field-helper-line">
                                                @if($opcion->type == 0)
                                                    <div class="mdc-text-field-character-counter">0 / 255</div>
                                                @else
                                                    <div class="mdc-text-field-helper-text" aria-hidden="false"></div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="col s12 m4 mb-1">
                                    <div class="mdc-select mdc-select--outlined mdc-select--required mdc-select--dense" id="mdc-select__category_id">
                                        <div class="mdc-select__anchor" aria-labelledby="outlined-select-label" aria-required="true">
                                            <input type="text" name="category_id" id="category_id" class="mdc-select__input-value">
                                            <span id="category_id__selected-text" class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="outlined-select-label" class="mdc-floating-label">Categoría</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item mdc-list-item--selected mdc-list-item--disabled" aria-selected="true" aria-disabled="true" data-value="" role="option" style="display: none;"></li>
                                                @foreach ($categorias as $categoria)
                                                    <li class="mdc-list-item" data-value="{{ $categoria->id }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ ucfirst(strtolower($categoria->name)) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text" aria-hidden="false"></div>
                                    </div>
                                </div>
                                {{-- <div class="col s12 m3 mb-1">
                                    <div class="mdc-select mdc-select--outlined mdc-select--required mdc-select--dense" id="mdc-select__priority">
                                        <div class="mdc-select__anchor" aria-labelledby="outlined-select-label" aria-required="true">
                                            <input type="text" name="priority" id="priority" class="mdc-select__input-value">
                                            <span id="priority__selected-text" class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="outlined-select-label" class="mdc-floating-label">Prioridad</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- Other elements from the select remain. -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface" role="listbox">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item mdc-list-item--selected mdc-list-item--disabled" aria-selected="true" aria-disabled="true" data-value="" role="option" style="display: none;"></li>
                                                @foreach ($prioridades as $prioridad)
                                                    <li class="mdc-list-item" data-value="{{ $prioridad['id'] }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ ucfirst(strtolower($prioridad['text'])) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text" aria-hidden="false"></div>
                                    </div>
                                </div> --}}
                                <div class="col s12 m8 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-text-field__summary">
                                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_summary" name="summary" id="summary" required maxlength="128">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_summary">Resumen</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-character-counter">0 / 128</div>
                                    </div>
                                </div>
                                {{-- <div class="col s12 mb-1">
                                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--textarea-dense" id="mdc-text-field__description">
                                        <span class="mdc-text-field__resizer">
                                            <textarea class="mdc-text-field__input" rows="5" cols="80" aria-label="lbl_description" name="description" id="description" required></textarea>
                                        </span>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_description">Descripción</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <div class="mdc-text-field-helper-line">
                                        <div class="mdc-text-field-helper-text" aria-hidden="false"></div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <a class="mdc-button mdc-button--outlined mdc-button--large" href="{{route('pqrs.index')}}">
                        <span class="mdc-button__label">Salir</span>
                    </a>
                    <button class="mdc-button mdc-button--raised mdc-button--large enviar_pedido" id="crear_pedido_mv" type="submit">
                        <span class="mdc-button__label mr-1">Guardar PQRS</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div id="mdc-dialog-clientes" class="mdc-dialog highlighted">
        <div class="mdc-dialog__container">
            <div class="mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
                <div class="mdc-dialog__content" id="my-dialog-content">
                    <div class="row mb-0 black-text" style="max-width: 320px;">
                        <div class="col s12 center">
                            <label class="">Nueva PQRS</label>
                            <span class="card-title subtitle-1 d-block capitalize font-gilroy mb-1">BUSCAR CLIENTES</span>
                        </div>
                        <div class="col s12 mt-2">
                            <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense" id="mdc-buscar_cliente">
                                <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_buscar_cliente" name="mdc-buscar_cliente" autocomplete="off">
                                <span class="mdc-notched-outline">
                                    <span class="mdc-notched-outline__leading"></span>
                                    <span class="mdc-notched-outline__notch">
                                        <span class="mdc-floating-label" id="lbl_buscar_cliente">Buscar por CC/NIT o por Nombre</span>
                                    </span>
                                    <span class="mdc-notched-outline__trailing"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="row mb-0 mt-3">
                        <div class="col s12">
                            <div class="mdc-data-table mdc-data-table--dense full-width" id="mdc-table-clientes">
                                <div class="mdc-data-table__table-container">
                                    <table class="mdc-data-table__table">
                                        <thead>
                                            <tr class="mdc-data-table__header-row">
                                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">CC/NIT</th>
                                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody class="mdc-data-table__content">
                                            <tr class="mdc-data-table__row">
                                                <td class="mdc-data-table__cell" colspan="2" scope="row">Busca un cliente por nombre o cc/nit</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdc-dialog__actions">
                    <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="cancel">
                        <div class="mdc-button__ripple"></div>
                        <span class="mdc-button__label">Cerrar</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mdc-dialog__scrim"></div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pqrs').addClass('mdc-list-item--active');

            var clientesListado = [];
            var urlBuscarClientes = '{!! route('ajax.clientes.buscar', ['busqueda' => 'null']) !!}';

            // Inicializa los textFields de Material.io
            const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
                return new mdc.textField.MDCTextField(el);
            });

            // Inicializa los selects de Material.io
            const selects = [].map.call(document.querySelectorAll('.mdc-select'), function(el) {
                return new mdc.select.MDCSelect(el);
            });

            const category_id = new mdc.select.MDCSelect(document.querySelector('#mdc-select__category_id'));
            category_id.listen('MDCSelect:change', (el) => {
                if (category_id.value) {
                    $('#category_id').val(category_id.value);
                    console.log($('#category_id').val());
                }
            });

            @foreach ($opciones as $key => $opcion)
                @if ($opcion->type == 3)
                    const {{ 'custom_field_' . $opcion->id }} = new mdc.select.MDCSelect(document.querySelector('#mdc-select__{{ 'custom_field_' . $opcion->id }}'));
                    {{ 'custom_field_' . $opcion->id }}.listen('MDCSelect:change', (el) => {
                        if ({{ 'custom_field_' . $opcion->id }}.value) {
                            $('#{{ 'custom_field_' . $opcion->id }}').val({{ 'custom_field_' . $opcion->id }}.value);
                        }
                    });
                @else
                    const {{ 'custom_field_' . $opcion->id }} = new mdc.textField.MDCTextField(document.querySelector('#mdc-text-field__{{ 'custom_field_' . $opcion->id }}'));
                @endif
            @endforeach
            const busquedaCliente = new mdc.textField.MDCTextField(document.querySelector('#mdc-buscar_cliente'));

            $('#btn-buscar-cliente').click(function(){
                dialogClientes.open();
            });

            $('#mdc-buscar_cliente input').keyup(async function(){
                var busqueda = $(this).val().toUpperCase();
                if(busqueda.length > 2){
                    let data = await buscarCliente(busqueda);
                    let clientes = data.clientes;
                    if (clientes.length) {
                        $('#mdc-table-clientes .mdc-data-table__content').empty();
                        for (let index = 0; index < clientes.length; index++) {
                            const cliente = clientes[index];
                            $('#mdc-table-clientes .mdc-data-table__content').append('<tr class="mdc-data-table__row data-cliente" data-index="' +index+ '"><td class="mdc-data-table__cell" scope="row">' +cliente.cc_nit+ '</td><td class="mdc-data-table__cell nowrap capitalize" scope="row">' +cliente.nombre_cliente.toLowerCase()+ '</td></tr>');
                        }
                        clientesListado = clientes;
                    } else {
                        $('#mdc-table-clientes .mdc-data-table__content').empty().append('<tr class="mdc-data-table__row"><td class="mdc-data-table__cell" colspan="2" scope="row">No hay clientes con esas características</td></tr>');
                    }
                } else {
                    $('#mdc-table-clientes .mdc-data-table__content').empty().append('<tr class="mdc-data-table__row"><td class="mdc-data-table__cell" colspan="2" scope="row">Busca un cliente por nombre o cc/nit</td></tr>');
                }
            });

            $('#mdc-table-clientes').on('click', '.data-cliente', function(){
                let index = $(this).data('index');
                let cliente = clientesListado[index];
                console.log(cliente);
                custom_field_6.value = cliente.nombre_cliente.trim();
                custom_field_9.value = cliente.direccion.trim();
                custom_field_10.value = cliente.telefono.trim();
                custom_field_11.value = cliente.correo.trim();
                custom_field_40.value = cliente.cc_nit.trim();

                busquedaCliente.value = '';
                $('#mdc-table-clientes .mdc-data-table__content').empty().append('<tr class="mdc-data-table__row"><td class="mdc-data-table__cell" colspan="2" scope="row">Busca un cliente por nombre o cc/nit</td></tr>');
                dialogClientes.close();
            });

            const buscarCliente = async function(busqueda) {
                let urlBuscar = urlBuscarClientes.replace('null', busqueda);
                try {
                    const clientes = await $.ajax({
                        'url': urlBuscar,
                        'context': document.body
                    }).done(function(response) {
                        return response;
                    });
                    return clientes;
                } catch(e) {
                    console.error(e);
                    return false;
                }
            }

            const dialogClientes = new mdc.dialog.MDCDialog(document.querySelector('#mdc-dialog-clientes'));
            const tableClientes = new mdc.dataTable.MDCDataTable(document.querySelector('#mdc-table-clientes'));
            @if (!isset($cliente))
                dialogClientes.open();
            @endif
        });
    </script>
@endsection

@extends('layouts.app')

@section('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('content')
    <form action="{{ route('registro-facturas-anuladas.store') }}" method="POST" id="mainForm">
        @csrf
        <div class="container-full">
            <div class="row">
                <div class="col s12 l6">
                    <h1 class="title">Registro de Facturas Anuladas</h1>
                    <div class="breadcrumbs full-width">
                        <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                        <a href="{{ route('registro-facturas-anuladas.index') }}" class="breadcrumb">Facturas Anuladas</a>
                        <a class="breadcrumb">Nuevo Registro</a>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-2">Datos del Cliente</span>
                            <div class="row mb-0">
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('nit') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-nit">
                                        <input type="text" class="mdc-text-field__input" aria-labelledby="lbl_nit"
                                            name="nit" id="nit" value="{{ old('nit') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_nit">NIT</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('nit')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('nombre_cliente') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-nombre_cliente">
                                        <input type="text" class="mdc-text-field__input"
                                            aria-labelledby="lbl_nombre_cliente" name="nombre_cliente" id="nombre_cliente"
                                            value="{{ old('nombre_cliente') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_nombre_cliente">Nombre del
                                                    Cliente</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('nombre_cliente')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('telefono_cliente') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-telefono_cliente">
                                        <input type="tel" class="mdc-text-field__input"
                                            aria-labelledby="lbl_telefono_cliente" name="telefono_cliente"
                                            id="telefono_cliente" value="{{ old('telefono_cliente') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_telefono_cliente">Teléfono del
                                                    Cliente</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('telefono_cliente')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('direccion_cliente') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-direccion_cliente">
                                        <input type="text" class="mdc-text-field__input"
                                            aria-labelledby="lbl_direccion_cliente" name="direccion_cliente"
                                            id="direccion_cliente" value="{{ old('direccion_cliente') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_direccion_cliente">Dirección del
                                                    Cliente</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('direccion_cliente')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col s12">
                    <div class="card highlighted">
                        <div class="card-content">
                            <span class="card-title mb-2">Datos del Documento</span>
                            <div class="row mb-0">
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('centro_operacion') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-centro_operacion">
                                        <input type="text" class="mdc-text-field__input"
                                            aria-labelledby="lbl_centro_operacion" name="centro_operacion"
                                            id="centro_operacion" value="{{ old('centro_operacion') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_centro_operacion">Centro de
                                                    Operación</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('centro_operacion')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('tipo_documento') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-tipo_documento">
                                        <input type="text" class="mdc-text-field__input"
                                            aria-labelledby="lbl_tipo_documento" name="tipo_documento"
                                            id="tipo_documento" value="{{ old('tipo_documento') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_tipo_documento">Tipo de
                                                    Documento</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('tipo_documento')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('numero_documento') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-numero_documento">
                                        <input type="text" class="mdc-text-field__input"
                                            aria-labelledby="lbl_numero_documento" name="numero_documento"
                                            id="numero_documento" value="{{ old('numero_documento') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_numero_documento">Número de
                                                    Documento</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('numero_documento')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('fecha') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-fecha">
                                        <input type="date" class="mdc-text-field__input" aria-labelledby="lbl_fecha"
                                            name="fecha" id="fecha" max="{{ now()->toDateString() }}"
                                            value="{{ old('fecha') }}" required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label mdc-floating-label--float-above"
                                                    id="lbl_fecha">Fecha</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    @error('fecha')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--label-floating {{ $errors->has('valor') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-valor">
                                        <input type="text" inputmode="numeric" class="mdc-text-field__input"
                                            aria-labelledby="lbl_valor" id="valor_formato"
                                            value="{{ old('valor') ? number_format((float) old('valor'), 0, ',', '.') : '' }}"
                                            required>
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_valor">Valor</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                    </label>
                                    <input type="hidden" name="valor" id="valor" value="{{ old('valor') }}">
                                    @error('valor')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 m4 mb-2 no-line-height">
                                    <div class="mdc-select mdc-select--outlined full-width {{ old('tipo_devolucion') ? 'mdc-select--filled' : '' }}"
                                        id="mdc-select-tipo_devolucion">
                                        <div class="mdc-select__anchor" aria-labelledby="tipo_devolucion-select-label"
                                            role="button" aria-haspopup="listbox" aria-expanded="false" tabindex="0">
                                            <input type="hidden" name="tipo_devolucion" id="tipo_devolucion"
                                                class="mdc-select__input-value" value="{{ old('tipo_devolucion') }}"
                                                required>
                                            <span id="tipo_devolucion__selected-text"
                                                class="mdc-select__selected-text"></span>
                                            <span class="mdc-select__dropdown-icon">
                                                <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5">
                                                    <polygon class="mdc-select__dropdown-icon-inactive" stroke="none"
                                                        fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                                                    <polygon class="mdc-select__dropdown-icon-active" stroke="none"
                                                        fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                                                </svg>
                                            </span>
                                            <span class="mdc-notched-outline">
                                                <span class="mdc-notched-outline__leading"></span>
                                                <span class="mdc-notched-outline__notch">
                                                    <span id="tipo_devolucion-select-label"
                                                        class="mdc-floating-label {{ old('tipo_devolucion') ? 'mdc-floating-label--float-above' : '' }}">Tipo
                                                        de Devolución</span>
                                                </span>
                                                <span class="mdc-notched-outline__trailing"></span>
                                            </span>
                                        </div>
                                        <!-- $tiposDevolucion: array asociativo ['clave' => 'Etiqueta'] pasado desde el controlador -->
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu--dense"
                                            role="listbox">
                                            <ul class="mdc-list">
                                                @foreach ($tiposDevolucion as $clave => $etiqueta)
                                                    <li class="mdc-list-item {{ old('tipo_devolucion') == $clave ? 'mdc-list-item--selected' : '' }}"
                                                        {{ old('tipo_devolucion') == $etiqueta ? 'aria-selected="true"' : '' }}
                                                        data-value="{{ $etiqueta }}" role="option">
                                                        <span class="mdc-list-item__ripple"></span>
                                                        <span class="mdc-list-item__text">{{ $etiqueta }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @error('tipo_devolucion')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col s12 mb-2">
                                    <label
                                        class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--label-floating {{ $errors->has('observacion') ? 'mdc-text-field--invalid' : '' }}"
                                        id="mdc-observacion">
                                        <span class="mdc-notched-outline">
                                            <span class="mdc-notched-outline__leading"></span>
                                            <span class="mdc-notched-outline__notch">
                                                <span class="mdc-floating-label" id="lbl_observacion">Observación</span>
                                            </span>
                                            <span class="mdc-notched-outline__trailing"></span>
                                        </span>
                                        <span class="mdc-text-field__resizer">
                                            <textarea class="mdc-text-field__input" rows="4" cols="40" aria-labelledby="lbl_observacion"
                                                name="observacion" id="observacion" required>{{ old('observacion') }}</textarea>
                                        </span>
                                    </label>
                                    @error('observacion')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                                aria-hidden="false">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col s12 right-align">
                    <a class="mdc-button mdc-button--raised mdc-button--large mr-1"
                        href="{{ route('registro-facturas-anuladas.index') }}">
                        <span class="mdc-button__label">Cancelar</span>
                    </a>
                    <button type="submit" class="mdc-button mdc-button--raised mdc-button--large">
                        <span class="mdc-button__label mr-1">Guardar</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#registro-facturas-anuladas').addClass('mdc-list-item--active');

        // Text fields
        const nit = new mdc.textField.MDCTextField(document.querySelector('#mdc-nit'));
        const nombreCliente = new mdc.textField.MDCTextField(document.querySelector('#mdc-nombre_cliente'));
        const direccionCliente = new mdc.textField.MDCTextField(document.querySelector('#mdc-direccion_cliente'));
        const telefonoCliente = new mdc.textField.MDCTextField(document.querySelector('#mdc-telefono_cliente'));
        const centroOperacion = new mdc.textField.MDCTextField(document.querySelector('#mdc-centro_operacion'));
        const tipoDocumento = new mdc.textField.MDCTextField(document.querySelector('#mdc-tipo_documento'));
        const numeroDocumento = new mdc.textField.MDCTextField(document.querySelector('#mdc-numero_documento'));
        const fecha = new mdc.textField.MDCTextField(document.querySelector('#mdc-fecha'));
        const valor = new mdc.textField.MDCTextField(document.querySelector('#mdc-valor'));
        const observacion = new mdc.textField.MDCTextField(document.querySelector('#mdc-observacion'));

        // Select
        const selectTipoDevolucion = new mdc.select.MDCSelect(document.querySelector('#mdc-select-tipo_devolucion'));
        selectTipoDevolucion.listen('MDCSelect:change', (el) => {
            $('#tipo_devolucion').val(selectTipoDevolucion.value);
        });

        // Máscara de moneda para "Valor" (separador de miles). El valor crudo viaja en el input oculto #valor.
        $('#valor_formato').on('input', function() {
            let raw = $(this).val().replace(/\D/g, '');
            $('#valor').val(raw);
            $(this).val(raw ? new Intl.NumberFormat('es-CO').format(raw) : '');
        });

        @if (Session::has('success'))
            Swal.fire({
                title: '¡Listo!',
                text: '{{ Session::get('success') }}',
                icon: 'success'
            });
            @php Session::forget('success'); @endphp
        @endif
    </script>
@endsection

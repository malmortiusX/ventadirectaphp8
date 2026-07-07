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
            <div class="col s12 l6">
                <h1 class="title">Abonos</h1>
                <div class="breadcrumbs full-width">
                    <a href="{{ route('dashboard') }}" class="breadcrumb">Dashboard</a>
                    <a href="{{ route('abonos.index') }}" class="breadcrumb">Abonos</a>
                    <a class="breadcrumb">Nuevo Abono</a>
                </div>
            </div>
        </div>
        <div class="row mb-0 mt-3" id="listado_abonos" class="display responsive" width="100%" style="width:100%">
            <div class="col s12">
                <div class="card mb-0">
                    <div class="card-content">
                        <span class="card-title mb-1">Datos del Abono</span>
                        <div class="row mb-1">
                            <div class="col s12 m6 mt-2">
                                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--dense"  id="cantidad_abono">
                                    <input type="number" min="0" class="mdc-text-field__input" aria-labelledby="lbl_cantidad_abono" name="cantidad_abono" pattern="[0-9]*" value="{{ $valor }}">
                                    <span class="mdc-notched-outline">
                                        <span class="mdc-notched-outline__leading"></span>
                                        <span class="mdc-notched-outline__notch">
                                            <span class="mdc-floating-label" id="lbl_cantidad_abono">Cantidad a abonar</span>
                                        </span>
                                        <span class="mdc-notched-outline__trailing"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col s12">
                                <button class="mdc-button mdc-button--raised mdc-button--large pagar_wompi" type="submit">
                                    <span class="mdc-button__label mr-1">Pagar con Wompi</span>
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col s12">
                                <form action="https://checkout.wompi.co/p/" method="GET" id="form">
                                    <!-- OBLIGATORIOS -->
                                    @if($usuario->regional != "EJE CAFETERO")
                                    <!-- Esta es la llave del madroño -->
                                    <input type="hidden" name="public-key" value="pub_prod_QApyzjKRxJbTlGe55WojidvzjOWos9Qd" />
                                    <!-- ---------- -->
                                    @else
                                    <!-- Esta es la llave de san marino -->
                                    <input type="hidden" name="public-key" value="pub_prod_FMigTO55Zw2hbwl3G5vR73SXGX7QvPrF" />
                                    <!-- ---------- -->
                                    @endif
                                    <input type="hidden" name="currency" value="COP" />
                                    <input type="hidden" name="amount-in-cents" value="MONTO_EN_CENTAVOS" id="amount-in-cents"/>
                                    <input type="hidden" name="reference" value="REFERENCIA_DE_PAGO" id="reference"/>
                                    <!-- OPCIONALES -->
                                    <input type="hidden" name="signature:integrity" value="" id="signature"/>
                                    <input type="hidden" name="redirect-url" value="{{ route('abonos.recepcion') }}" />
                                    <input type="hidden" name="customer-data:email" value="CORREO_DEL_PAGADOR" id="email"/>
                                    <input type="hidden" name="customer-data:full-name" value="NOMBRE_DEL_PAGADOR" id="full-name"/>
                                    <input type="hidden" name="customer-data:phone-number" value="NUMERO_DE_TELEFONO_DEL_PAGADOR" id="phone-number"/>
                                    <input type="hidden" name="customer-data:legal-id" value="DOCUMENTO_DE_IDENTIDAD_DEL_PAGADOR" id="legal-id"/>
                                    <input type="hidden" name="customer-data:legal-id-type" value="TIPO_DEL_DOCUMENTO_DE_IDENTIDAD_DEL_PAGADOR" id="legal-id-type"/>
                                    {{-- <input type="hidden" name="shipping-address:address-line-1" value="DIRECCION_DE_ENVIO" />
                                    <input type="hidden" name="shipping-address:country" value="PAIS_DE_ENVIO" />
                                    <input type="hidden" name="shipping-address:phone-number" value="NUMERO_DE_TELEFONO_DE_QUIEN_RECIBE" />
                                    <input type="hidden" name="shipping-address:city" value="CIUDAD_DE_ENVIO" />
                                    <input type="hidden" name="shipping-address:region" value="REGION_DE_ENVIO" /> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mdc-snackbar">
        <div class="mdc-snackbar__surface">
            <div class="mdc-snackbar__label" role="status" aria-live="polite">Hay errores en las fechas.</div>
            <div class="mdc-snackbar__actions">
                <button type="button" class="mdc-button mdc-snackbar__action">
                    <div class="mdc-button__ripple"></div>
                    <span class="mdc-button__label">
                        <i class="fas fa-times send"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/Responsive-2.2.6/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            // Selección del item en el menú
            $('#abonos-index').addClass('mdc-list-item--active');

            const cantidad_abono = new mdc.textField.MDCTextField(document.querySelector('#cantidad_abono'));

            var idPedido = 0;
            var usuario = @json($usuario);

            // Ejecuta la función de validación antes de enviar el formulario
            $('.pagar_wompi').on('click', async function(e) {
                // $('#guardando').show();
                $('body').css('overflow', 'hidden');
                $('.pagar_wompi').attr('disabled', 'disabled');
                e.preventDefault();
                let validacion = await validar();
                if (validacion) {
                    $.ajax({
                        method: 'POST',
                        url: '{!! route('ajax.abonoWompi.guardar') !!}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            valor: cantidad_abono.value,
                            id_usuario: usuario.id_usuario,
                            id_pedido: idPedido
                        }
                    }).done(function(response) {

                        console.log(response);
                        $('#signature').val(response.signature);
                        $('#amount-in-cents').val(response.pagoWompi.valor + '00');
                        $('#reference').val(response.pagoWompi.id);
                        $('#email').val(usuario.correo);
                        $('#full-name').val(usuario.nombres + ' ' + usuario.apellidos);
                        $('#phone-number').val(usuario.telefono);
                        $('#legal-id').val(usuario.documento);
                        $('#legal-id-type').val('CC');

                        $('#form').submit();
                        $('body').css('overflow', '');
                        $('.pagar_wompi').removeAttr('disabled');

                    });
                } else {
                    // $('#guardando').hide();
                    $('body').css('overflow', '');
                    $('.pagar_wompi').removeAttr('disabled');
                }
            });

            const validar = async function() {

                if (!cantidad_abono.valid || cantidad_abono.value == null || cantidad_abono.value == '') {
                    cantidad_abono.valid = false;
                    cantidad_abono.helperTextContent = 'Ingrese una cantidad válida.';
                    M.toast({html: '<span class="mr-3">Error en la cantidad a abonar.</span><a class="btn btn-flat white-text px-0" onclick="M.Toast.getInstance(this.parentElement).dismiss();"><i class="fas fa-times"></i></a>', classes: 'red darken-2 white-text'});
                    return false;
                }

                return true;
            }
        });
    </script>
@endsection

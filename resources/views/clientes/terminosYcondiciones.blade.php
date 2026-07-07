@php
    $empresa = \App\Models\TblEmpresa::first();
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', $empresa->nombre) }}</title>
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('imagenes/favicon/' . mb_strtolower($empresa->nombre) . '.svg') }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/materialize/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/material.io/material-components-web.min.css') }}">
    @yield('styles')
    <link href="{{ asset('css/styles.css') }}?1.1.1" rel="stylesheet">
    <link href="{{ asset('vendor/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --mdc-theme-primary: {{ $empresa->color }};
            --mdc-theme-primary-rgb: {{ $empresa->color_rgb }};
            --mdc-theme-secondary: {{ $empresa->color2 }};
            --mdc-theme-secondary-rgb: {{ $empresa->color2_rgb }};
        }
        .col-firma .wrapper {
            position: relative;
            max-width: 400px;
            width: 100%;
            height: 200px;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .col-firma img {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .col-firma .signature-pad {
            position: absolute;
            left: 0;
            top: 0;
            max-width: 400px;
            width: 100%;
            height: 200px;
            border: solid 1px rgba(0,0,0,.38);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <main class="main-content container-full" id="main-content" style="max-width: inherit;">
        <section class="div-main">
            <div class="container">
                <div class="row">
                    <div class="col s12 center hide-on-med-and-up">
                        <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo">
                    </div>
                    <div class="col s12 m6">
                        <h1 class="title">TERMINOS Y CONDICIONES PARA EMPRESARIOS AVICAMPO VENTA POR CATÁLOGO</h1>
                        <div>
                            AVÍCOLA EL MADROÑO S.A.
                            NIT. 800000276 - 8
                        </div>
                    </div>
                    <div class="col m6 hide-on-small-only pr-5" style ="text-align: right;">
                        <img src="{{ asset($empresa->logo) }}" alt="Avicampo Logo" class="card-logo mb-0">
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col s12">
                        <p>Los presentes términos y condiciones rigen para los (las) EMPRESARIOS AVICAMPO, a partir del momento en el que se registren como vendedor de catálogo ante AVÍCOLA EL MADROÑO S.A. (en adelante “MADROÑO”), diligenciando el respectivo formulario de registro, bien a través de la página web, WhatsApp o de forma física.</p>
                        <p>Se entiende por EMPRESARIO(S) AVICAMPO la persona natural autorizada por MADROÑO para realizar pedidos del catálogo de productos fabricados por MADROÑO.</p>
                        <p>En el momento en el que se suscribe el formulario de inscripción, los EMPRESARIOS AVÍCAMPO reconocen haber leído, entendido y aceptado los presentes términos y condiciones.</p>

                        <h6>I.    REGISTRO</h6>
                        <p>Para que una persona natural adquiera la calidad de EMPRESARIOS AVICAMPO, deberá registrarse como vendedor de catálogo, completando la siguiente información:</p>
                        <ul>
                            <li>- Número de cédula</li>
                            <li>- Nombre completo</li>
                            <li>- Correo electrónico</li>
                            <li>- Teléfono de contacto actualizado</li>
                            <li>- Dirección de despacho</li>
                        </ul>
                        <p>En el evento que los datos suministrados sean insuficientes, no estén actualizados o sean aparentemente falsos, no podrá completarse el proceso de inscripción.</p>
                        <p>Como documentos, deberá adjuntar o enviar por correo electrónico, copia de su cédula de ciudadanía y copia del Registro Único Tributario.</p>
                        <p>MADROÑO, se reserva el derecho de negar solicitudes de registro que considere contrarias a sus intereses.</p>

                        <h6>II.	COLOCACIÓN DE PEDIDOS</h6>
                        <p>A partir del momento en el que MADROÑO aprueba una solicitud de registro, el EMPRESARIO AVÍCAMPO podrá ofrecer el catálogo de Productos de MADROÑO a sus clientes.</p>
                        <p>El EMPRESARIO AVÍCAMPO deberá hacer la solicitud de Productos de la siguiente manera:</p>
                        <ul>
                        <li>- Telefónicamente con el apoyo de la coordinadora </li>
                        <li>- Plataforma de pedidos web</li>
                        </ul>
                        <p>Para que una solicitud de Productos sea despachada al domicilio del EMPRESARIO AVICAMPO, deberá haberla cancelado previamente mediante pago anticipado. Los EMPRESARIOS AVICAMPO no contarán con cupo de crédito rotativo para la solicitud y despacho de Productos.</p>

                        <h6>III.	DISPONIBILIDAD DE PRODUCTOS</h6>
                        <p>La aprobación de pedidos de Productos estará sujeta a la disponibilidad que de ellos tenga MADROÑO.</p>
                        <p>En el evento en que no exista inventario de los Productos solicitados por el EMPRESARIO AVICAMPO, se aplicará el siguiente procedimiento:</p>
                        <ul>
                            <li>- Telefónicamente se informará los productos próximos a agotarse o agotados.</li>
                            <li>- En la pagina Web en el momento del montaje del pedido el producto sin inventario, se registrará como agotado.</li>
                        </ul>

                        <h6>IV.	FACTURACIÓN </h6>
                        <p>En el momento en que se confirme el pedido de Productos y se complete el pago de los mismos, MADROÑO emitirá factura de venta a nombre del EMPRESARIO AVICAMPO.</p>

                        <h6>V.	ENTREGA DE PRODUCTOS </h6>
                        <p>Todos los pedidos serán despachados a la dirección indicada como <i>Dirección de Despacho</i> por el EMPRESARIO AVICAMPO al momento de diligenciar su solicitud de inscripción. Los pedidos que se entregaran a partir del 1 de diciembre de 2022.</p>
                        <p>Teniendo en cuenta que los Productos dispuestos en el catálogo de venta son perecederos y deben conservar una cadena de frío adecuada, MADROÑO se reserva la facultad de entregar productos de forma fraccionada, es decir, limitando el número de Productos para garantizar que la infraestructura dispuesta por el EMPRESARIO AVICAMPO para la conservación de la cadena de frío sea óptima.</p>
                        <p>En el momento de la entrega de los Productos solicitados por el EMPRESARIO AVICAMPO en la Dirección de Despacho, MADROÑO entregará al primero un listado de los Productos entregados, a efectos que el EMPRESARIO AVICAMPO verifique el estado de los Productos, indique los faltantes o confirme la entrega efectiva de los productos solicitados.</p>

                        <h6>VI.	REQUISITOS PARA LA ENTREGA DE PRODUCTOS</h6>
                        <p>El EMPRESARIO AVICAMPO deberá estar presente o dejar carta autorizando, la entrega de los productos.</p>

                        <h6>VII.    RESPONSABILIDAD POR LOS PRODUCTOS</h6>
                        <p>A partir del momento de la entrega efectiva de Productos, la propiedad sobre los mismos será transferida a el EMPRESARIO AVICAMPO. </p>
                        <p>Luego de que el EMPRESARIO AVICAMPO suscriba el comprobante de entrega, no serán de recibo por parte de MADROÑO reclamos relativos al estado de los Productos o productos faltantes.</p>
                        <p>Será obligación del EMPRESARIO AVICAMPO efectuar la entrega al consumidor final en la dirección indicada por éste.</p>

                        <h6>VIII.	TRAMITE DE RECLAMACIONES</h6>
                        <p>En el evento que los consumidores finales presenten reclamaciones sobre los Productos comercializados a través de la venta por catálogo, MADROÑO dispone de los siguientes medios de contacto:</p>
                        <ul>
                            <li>- Regional Oriente tels:    315 233 5626</li>
                            <li>- Regional Occidente tels:  320 632 0983</li>
                            <li>- Regional Costa tels:      317 3716564</li>
                        </ul>
                        <p>Cuando el EMPRESARIO AVICAMPO conozca de alguna reclamación hecha por algún consumidor final sobre los Productos, deberá ponerla en conocimiento de MADROÑO a más tardar dentro del primer (1) día hábil siguiente a la fecha en la que tuviere conocimiento de ésta.</p>
                        <p>El EMPRESARIO AVICAMPO deberá informar al consumidor final que el término de garantía legal sobre los Productos, estará sujeto a la fecha de expiración del Producto.</p>

                        <h6>IX.	 DERECHO DE RETRACTO</h6>
                        <p>Atendiendo a la naturaleza de los Productos contenidos en el catálogo de venta, y de conformidad con lo establecido en el Estatuto de Protección al Consumidor, no serán procedentes los reclamos relativos al derecho de retracto.</p>
                        <p>Los EMPRESARIOS AVICAMPO se comprometen a informar al consumidor antes de completar la compra, lo siguiente:</p>
                        <ol>
                            <li>Los Productos fabricados por MADROÑO son alimentos perecederos.</li>
                            <li>Los Productos tienen una vida útil aproximada de 30 días, contados a partir de la fecha de entrega al EMPRESARIO AVICAMPO.</li>
                            <li>Los Productos son fabricados por AVÍCOLA EL MADROÑO S.A.</li>
                        </ol>

                        <h6>X.	VIGENCIA</h6>
                        <p>Los presentes términos y condiciones rigen desde el 20 de septiembre hasta el 31 diciembre de 2022.  MADROÑO se reserva el derecho de modificar los presentes términos y condiciones en cualquier momento y de forma unilateral.</p>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="row mb-0">
                <div class="col s12 m6">
                    <Label>Copyright © {{ date('Y') }} | <a class="link" style="color: var(--mdc-theme-secondary);" href="https://avicolaelmadrono.com/" target="_blank">Avicola El Madroño S.A.</a></Label>
                </div>
                <div class="col s12 m6 right-align">
                    <Label>Sistema de Pedidos Madroño Móvil</Label>
                </div>
            </div>
        </footer>
    </main>
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendor/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('vendor/material.io/material-components-web.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2@10.js') }}"></script>
    <script src="{{ asset('vendor/signature_pad/signature_pad.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
</body>
</html>

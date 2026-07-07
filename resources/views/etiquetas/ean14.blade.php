<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ str_replace(chr(29), '', $cadena) }}</title>
        <style>
            @page { size: 10.5cm 6.5cm; }
            html {
                margin: 0;
            }
        </style>
    </head>
    <body style="font-family: 'Arial'; font-size: 10px;">
        <div style="width: 8.5cm;">
            <div style="width: 100%; text-align: center">
                <b>AVÍCOLA EL MADROÑO S.A.</b>
            </div>
            <br>
            <div style="width: 100%; overflow: hidden; text-overflow: clip; white-space: nowrap;">
                <b>PRODUCTO: {{ $referencia }}</b>
            </div>
            <hr style="border-color: black; margin: 0;">
            <div style="width: 100%; overflow: hidden; text-overflow: clip; white-space: nowrap;">
                <b>{{ $descripcion }}</b>
            </div>
            <div style="width: 100%; border: solid 1px black;">
                <div style="width: 100%; text-align: center">
                    <b>Peso Neto (Kg):</b>
                </div>
                <div style="width: 100%; text-align: center">
                    <b style="font-size: 35px;">{{ $peso }}</b>
                </div>
            </div>
            <br>
            <div style="width: 100%; text-align:center;">
                <img src="data:image/png;base64,{{ $barcode->generate() }}" />
            </div>
        </div>
    </body>
    <script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            window.print();
            console.log('print');
        });
    </script>
</html>

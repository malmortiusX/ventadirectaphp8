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
    <body style="font-family: 'Arial'; font-size: 11px;">
        <div style="width: 8.5cm; margin-left: 0.75cm;">
            <br>
            <br>
            <br>
            <div style="width: 100%; text-align: center">
                <b>AVÍCOLA EL MADROÑO S.A.</b>
            </div>
            <hr style="border-color: black;">
            <div style="width: 100%; overflow: hidden; text-overflow: clip; white-space: nowrap;">
                <b>PRODUCTO: {{ $referencia }}&emsp;{{ $descripcion }}</b>
            </div>
            <div style="width: 100%; display: inline-flex">
                <div style="width: 27%;">
                    <b>Peso Neto:</b>
                </div>
                <div style="width: 32%;">
                    <b>Vencimiento:</b>
                </div>
                <div style="width: 20%;">
                    <b>Lote:</b>
                </div>
                <div style="width: 21%;">
                    <b>Unidades:</b>
                </div>
            </div>
            <div style="width: 100%; display: inline-flex">
                <div style="width: 27%;">
                    <b>{{ $peso }} Kg</b>
                </div>
                <div style="width: 32%;">
                    <b>{{ $f_venc->format('d/m/Y') }}</b>
                </div>
                <div style="width: 20%;">
                    <b>{{ $lote }}</b>
                </div>
                <div style="width: 21%;">
                    <b>{{ $unidades }}</b>
                </div>
            </div>
            <hr style="border-color: black;">
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

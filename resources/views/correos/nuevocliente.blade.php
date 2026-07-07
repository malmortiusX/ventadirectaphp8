<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Creación de cliente - Avicampo SA</title>
</head>
<body>

    <div style="max-width: 500px; margin: auto; background-color: #ffffff;font-family:'Product Sans',-apple-system,'Poppins',BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;">
        <table width="auto" cellpadding="0" cellspacing="0" style="margin-bottom: 40px;">
            <tbody>
                <tr valign="top">
                    <td align="center" style="padding-top: 20px;">
                        <a href="http://201.221.132.94/avicampo-movil/admin/" target="_blank">
                            <img src="https://190.0.54.22/imagenes/logos/avicampo-logo.png" height="100px" border="0" style="display: block;" align="middle">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="padding-top: 0px; text-align: center;" align="middle">
                        <h2 style="font-size: 30px; color: #000; margin-bottom: 0; margin-top: 0;"><span style="text-transform: capitalize;">{{ mb_strtolower($usuario->nombres) }}</span> ha creado un cliente</h2>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" align="center" style="padding-top: 30px">
                        <img src="https://190.0.54.22/imagenes/ilustraciones/clientes.svg">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="padding-top: 30px; color: #000; font-size: 18px;">
                        <p style="text-align: justify; margin-top: 0px">Estimado Leonardo, este correo es para notificarle que el usuario <b>{{ $usuario->codigo_vendedor ? $usuario->codigo_vendedor . ' - ' : '' }} <span style="text-transform: capitalize">{{ mb_strtolower($usuario->nombres .' '. $usuario->apellidos) }}</span></b> acaba de crear el siguiente cliente:</p>
                        <div style="color: #717171; font-size: 16px; margin-top: 20px; margin-bottom: 20px">
                            <p style="margin-top: 0; margin-bottom: 0; text-transform: capitalize;">{{ mb_strtolower($cliente->nombre_cliente .' - '. $cliente->tipoCliente->nombre_tipo_cliente) }}</p>
                            <p style="margin-top: 0; margin-bottom: 0; text-transform: capitalize;">{{ mb_strtolower($cliente->direccion . ($cliente->barrio ? ' - '.$cliente->barrio : '')) }}</p>
                            <p style="margin-top: 0; margin-bottom: 0;">{{ $cliente->telefono }}</p>
                            <p style="margin-top: 0; margin-bottom: 0; text-transform: capitalize;">{{ mb_strtolower($cliente->ciudadCl->ciudad) }}</p>
                            <p style="margin-top: 0; margin-bottom: 0;">Lista de precio: <b>{{ $cliente->lista_precio }}</b></p>
                        </div>
                        <p style="text-align: justify; margin-top: 0px; margin-bottom: 0px;">Para aprobar la lista de precio puede ingresar al backoffice dando click <a style="text-decoration: none; color: #ff0000" href="http://201.221.132.94/avicampo-movil/admin/">aquí</a>.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <td colspan="2" align="center" style="padding-top: 40px; padding-bottom: 10px;">
                        <a href="http://201.221.132.94/avicampo-movil/admin/" target="_blank">
                            <img src="https://190.0.54.22/imagenes/logos/avicampo-logo.png" width="120" border="0" style="display:block">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Noto Sans','Ubuntu','Droid Sans','Helvetica Neue',sans-serif;font-size:12px;line-height:16px;color:#5e6c84;text-align:center" align="center">
                        <p style="margin: 0px;">Sistema de Pedidos Madroño Móvil | V 2.3</p>
                        <p style="margin: 0px;">Bucaramanga, Santander - Colombia</p>
                        <a style="color: #ff5050; text-decoration: none;" href="https://avicolaelmadrono.com/" target="_blank">Avicola El Madroño S.A.</a>
                        <p style="margin: 0px;">Copyright © {{ date('Y') }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
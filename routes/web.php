<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    if (session('token') && session('user')) {
        return redirect(route('dashboard'));
    } else {
        return redirect(route('auth.login'));
    }
});


Route::get('/private-storage/{ruta}', 'ArchivosController')->where(['ruta' => '.*']);
Route::get('/external-storage/{ruta}', 'ArchivosExternosController')->where(['ruta' => '.*']);

Route::get('/login', 'AuthController@login')->name('auth.login');
Route::post('/login', 'AuthController@authentication')->name('auth.authentication');
Route::get('/logout', 'AuthController@logout')->name('auth.logout');
Route::get('/dashboard', 'DashboardController')->name('dashboard');
Route::get('/pedidos', 'PedidosController@index')->name('pedidos.index');
Route::get('/pedidos/nuevo', 'PedidosController@create')->name('pedidos.create');
Route::post('/pedidos/nuevo', 'PedidosController@store')->name('pedidos.store');
Route::get('/pedidos/nuevoLlamada', 'PedidosController@createLlamada')->name('pedidos.createLlamada');
Route::post('/pedidos/validarCliente/{pedido}', 'PedidosController@validaCliente')->name('pedidos.validaCliente');
Route::get('/pedidos/{id}', 'PedidosController@show')->name('pedidos.show');
Route::post('/pedidos/{id}/editar', 'PedidosController@update')->name('pedidos.update');
Route::get('/pedidos/{id}/pdf', 'PedidosController@pdf')->name('pedidos.pdf');
Route::get('/pedidos/multiPdf/{pedidos}', 'PedidosController@multiPdf')->name('pedidos.multiPdf');
Route::post('/pedidos/{id}/enRuta', 'PedidosController@enRuta')->name('pedidos.enRuta');
Route::post('/pedidos/{id}/despachado', 'PedidosController@despachado')->name('pedidos.despachado');
Route::get('/misPedidos', 'PedidosController@misPedidos')->name('pedidos.misPedidos');
Route::post('/misPedidos/enRutaMulti', 'PedidosController@enRutaMulti')->name('misPedidos.enRutaMulti');
Route::post('/misPedidos/entregadosMulti', 'PedidosController@entregadosMulti')->name('misPedidos.entregadosMulti');
Route::get('/abonos', 'AbonosController@index')->name('abonos.index');
Route::get('/abonos/nuevo/{valor?}', 'AbonosController@create')->name('abonos.create');
Route::get('/abonos/recepcion', 'AbonosController@recepcion')->name('abonos.recepcion');


Route::view('/correos/pedidoEnRuta', 'correos.pedidoEnRuta');

Route::get('/productos', 'ProductosController@index')->name('productos.index');

Route::get('/pqrs', 'PqrsController@index')->name('pqrs.index');
Route::get('/pqrs/show/{id}', 'PqrsController@show')->name('pqrs.show');
Route::get('/pqrs/create', 'PqrsController@create')->name('pqrs.create');
Route::post('/pqrs/store', 'PqrsController@store')->name('pqrs.store');

Route::get('/rutero', 'RuteroController@index')->name('rutero.index');
Route::get('/clientes/nuevo', 'ClientesController@create')->name('clientes.create');
Route::post('/clientes/nuevo', 'ClientesController@store')->name('clientes.store');
Route::post('/clientes/nuevo/pdv', 'ClientesController@storePdv')->name('clientes.store.pdv');
Route::get('/clientes/rutero/{codigo_vendedor?}', 'ClientesController@rutero')->name('clientes.rutero');
Route::get('/clientes/{cc_nit}', 'ClientesController@show')->name('clientes.show');
Route::get('/clientes/{idCliente}/correo', 'ClientesController@correo')->name('clientes.correo');
Route::get('/descuentos', 'SolicitudesSDescuentoController@index')->name('descuentos.index');
Route::get('/descuentos/nuevo', 'SolicitudesSDescuentoController@create')->name('descuentos.create');
Route::post('/descuentos/nuevo', 'SolicitudesSDescuentoController@store');
Route::get('/sondeos-precios', 'SondeoPreciosController@index')->name('sondeos.index');
Route::get('/sondeos-precios/nuevo', 'SondeoPreciosController@create')->name('sondeos.create');
Route::post('/sondeos-precios/nuevo', 'SondeoPreciosController@store');
Route::get('/actualizar', 'ActualizacionController@show')->name('actualizar');
Route::post('/actualizar', 'ActualizacionController@update');
Route::get('/ipbd', 'ActualizacionController@ipbd')->name('ipbd');
Route::post('/ipbd', 'ActualizacionController@ipbdupdate');

Route::get('/registro-facturas-anuladas', 'FacturasAnuladasController@index')->name('registro-facturas-anuladas.index');
Route::post('/registro-facturas-anuladas', 'FacturasAnuladasController@store')->name('registro-facturas-anuladas.store');

Route::get('/encuesta', 'EncuestaController@show')->name('encuesta.show');

Route::get('/pedidos-semanales', 'PedidosSemanalesController@index')->name('pedidos.semanales.index');
Route::post('/pedidos-semanales/pollo/nuevo', 'PedidosSemanalesController@store')->name('pedidos.semanales.store');
Route::get('/pedidos-semanales/pollo/{ano}/{semana}/{vendedor?}', 'PedidosSemanalesController@show')->name('pedidos.semanales.show');
Route::post('/pedidos-semanales/pollo/{ano}/{semana}/cerrar/{vendedor?}', 'PedidosSemanalesController@close')->name('pedidos.semanales.close');
Route::get('/pedidos-semanales/carnes-frias/nuevo', 'PedidosSemanalesCfController@create')->name('pedidos.semanalescf.create');
Route::post('/pedidos-semanales/carnes-frias/nuevo', 'PedidosSemanalesCfController@store')->name('pedidos.semanalescf.store');
Route::get('/pedidos-semanales/carnes-frias/{ano}/{semana}/{vendedor?}', 'PedidosSemanalesCfController@show')->name('pedidos.semanalescf.show');
Route::post('/pedidos-semanales/carnes-frias/{ano}/{semana}/cerrar/{vendedor?}', 'PedidosSemanalesCfController@close')->name('pedidos.semanalescf.close');

// Rutas get de ajax
Route::get('/ajax/centdist/{vendedor}', 'AjaxController@centdistVendedor')->name('ajax.centdist.vendedor');
Route::get('/ajax/pedidos/buscar/{inicio}/{fin}', 'AjaxController@pedidosBuscar')->name('ajax.pedidos.fechas.buscar');
Route::get('/ajax/pedidos/totales/{inicio}/{fin}', 'AjaxController@pedidosTotales')->name('ajax.pedidos.totales');
Route::get('/ajax/pedidos/clientes/buscar/{busqueda?}', 'AjaxController@clientesVdBuscar')->name('ajax.pedidos.clientes.buscar');
Route::get('/ajax/misPedidos/buscar/{inicio}/{fin}/{estado}', 'AjaxController@misPedidosBuscar')->name('ajax.misPedidos.fechas.buscar');
Route::get('/ajax/misPedidosDash/buscar', 'AjaxController@misPedidosBuscarDashboard')->name('ajax.misPedidos.dash.buscar');
Route::get('/ajax/clientes/buscar/{busqueda}', 'AjaxController@clientesBuscar')->name('ajax.clientes.buscar');
Route::get('/ajax/clientes/buscar/{vendedor}/{busqueda}', 'AjaxController@clientesVendedorBuscar')->name('ajax.clientes.vendedor.buscar');
Route::get('/ajax/clientes/{cliente}/productos', 'AjaxController@clientesProductos')->name('ajax.clientes.productos');
Route::get('/ajax/productos/buscar/{busqueda}', 'AjaxController@productosBuscar')->name('ajax.pedidos.productos.buscar');
Route::get('/ajax/pqrproductos/buscar/{producto}/{cliente}', 'AjaxController@pqrProductosBuscar')->name('ajax.pqr.productos.buscar');
Route::get('/ajax/pqr/buscar/{inicio}/{fin}', 'AjaxController@pqrsBuscar')->name('ajax.pqr.fechas.buscar');
Route::get('/ajax/{pedido}/productos/buscar/{busqueda}', 'AjaxController@pedidoBuscarProductos')->name('ajax.pedido.productos.buscar');
Route::get('/ajax/{pedido}/cambiar-fecha-entrega/{fecha_entrega}', 'PedidosController@cambiarFechaEntrega')->name('ajax.pedido.cambiarFechaEntrega');
Route::get('/ajax/pedidos-semanales/productos/{busqueda}', 'PedidosSemanalesController@productos')->name('ajax.pedidos.semanales.productos');
Route::get('/ajax/pedidos-semanales-cf/productos/{busqueda}', 'PedidosSemanalesCfController@productos')->name('ajax.pedidos.semanalescf.productos');
Route::get('/rutero/clientes/{fecha}', 'RuteroController@clientes')->name('rutero.clientes');
Route::get('/rutero/reg-llamada/{cliente}/{clienteVd}', 'RuteroController@regLlamada')->name('rutero.regLlamada');
Route::get('/rutero/pedidos-cliente/{fecha}/{cliente}', 'RuteroController@pedidosCliente')->name('rutero.pedidosCliente');
Route::get('/ajax/clientes/validarCliente/{codigo_cli}/{sucursal}', 'ClientesController@validarCliente')->name('ajax.clientes.validarCliente');
Route::get('/ajax/clientes/validarVendedorVD/{documento_vendedorVD}', 'ClientesController@validarVendedorVD')->name('ajax.clientes.validarVendedorVD');
Route::get('/ajax/descuentos/obtenerProductosListaPrecio/{lista_precio}/{busqueda}', 'SolicitudesSDescuentoController@obtenerProductosListaPrecio')->name('ajax.descuentos.obtenerProductosListaPrecio');
Route::get('/ajax/sondeos/obtenerProductos/{busqueda}', 'SondeoPreciosController@obtenerProductos')->name('ajax.sondeos.obtenerProductos');
Route::get('/ajax/sondeos/obtenerPrecioProducto/{producto}/{listaprecio}', 'SondeoPreciosController@obtenerPrecioProducto')->name('ajax.sondeos.obtenerPrecioProducto');

// Rutas post de ajax
Route::post('ajax/clientesvd/guardar', 'AjaxController@guardarClienteVd')->name('ajax.clientesvd.guardar');
Route::post('ajax/clientesvd/editar', 'AjaxController@editarClienteVd')->name('ajax.clientesvd.editar');
Route::post('ajax/clientes/coordenadas', 'AjaxController@guardarCoordenadasCliente')->name('ajax.clientes.coordenadas');
Route::post('ajax/pedidos/crear', 'AjaxController@crearPedido')->name('ajax.pedidos.crear');
Route::post('ajax/pedidos/coordenadas', 'AjaxController@guardarCoordenadas')->name('ajax.pedidos.coordenadas');
Route::post('ajax/pedidos/producto', 'AjaxController@guardarProducto')->name('ajax.pedidos.gurdarProducto');
Route::post('ajax/pedidos/actualizar-producto', 'AjaxController@actualizarProducto')->name('ajax.pedidos.actualizarProducto');
Route::delete('ajax/pedidos/producto', 'AjaxController@eliminarProducto')->name('ajax.pedidos.eliminarProducto');
Route::post('/rutero/registrar-no-compra', 'RuteroController@registrarNoCompra')->name('rutero.registrarNoCompra');
Route::post('ajax/pedidos-semanales/producto', 'PedidosSemanalesController@guardarProducto')->name('ajax.pedidos.semanales.gurdarProducto');
Route::delete('ajax/pedidos-semanales/producto', 'PedidosSemanalesController@eliminarProducto')->name('ajax.pedidos.semanales.eliminarProducto');
Route::post('ajax/pedidos-semanales-cf/producto', 'PedidosSemanalesCfController@guardarProducto')->name('ajax.pedidos.semanalescf.gurdarProducto');
Route::delete('ajax/pedidos-semanales-cf/producto', 'PedidosSemanalesCfController@eliminarProducto')->name('ajax.pedidos.semanalescf.eliminarProducto');
Route::post('ajax/abonos/guardar', 'AjaxController@guardarAbonoWompi')->name('ajax.abonoWompi.guardar');
Route::get('ajax/abonos/actualizaWompi/{busqueda}/{idWompi}', 'AjaxController@actualizaWompi')->name('ajax.abonoWompi.actualizaid');

// Rutas post de ajax para Backoffice
Route::group(['middleware' => ['cors']], function () {
    Route::get('ajax/backOffice/imprimirPedidos', 'AjaxBackOfficeController@imprimirPedidos');
});

// Rutas get externas
Route::get('/gs1128', 'EtiquetasController@gs1128')->name('etiquetas.gs1128');
Route::get('/ean14', 'EtiquetasController@ean14')->name('etiquetas.ean14');
Route::get('/guia-transporte', 'GuiasController@search')->name('guias.search');
Route::get('/guia-transporte/{factura}/pdf', 'GuiasController@pdf')->name('guias.pdf');
Route::get('/gs11282', 'EtiquetasController2@gs1128')->name('etiquetas2.gs1128');
Route::get('/clientes-externos-cop/nuevo/{cop}', 'ClientesExternosController@createExternoCop')->name('clientes.externos.cop');
Route::get('/clientes-externos-nit/nuevo/{nit}', 'ClientesExternosController@createExternoNit')->name('clientes.externos.nit');
Route::post('/clientes-externos-cop/nuevo', 'ClientesExternosController@storeExterno')->name('clientes.externos.store.cop');
Route::get('/clientes-empresarios/nuevo', 'ClientesExternosController@createEmpresario')->name('clientes.externos.empresarios');
Route::post('/clientes-empresarios/nuevo', 'ClientesExternosController@storeEmpresario')->name('clientes.externos.empresarios');
Route::get('/clientes-empresarios/continuacion', 'ClientesExternosController@createEmpresarioContinuacion')->name('clientes.externos.empresarios.continuacion');
Route::post('/clientes-empresarios/continuacion', 'ClientesExternosController@storeEmpresarioContinuacion')->name('clientes.externos.empresarios.continuacion');
Route::view('/habeasData-empresarios', 'clientes.habeasData')->name('clientes.habeasData');
Route::view('/terminosYcondiciones-empresarios', 'clientes.terminosYcondiciones')->name('clientes.terminosYcondiciones');
Route::get('/guia-transporte2', 'GuiasController@cargarFactura')->name('guias.index.fenix');
Route::post('/guia-transporte2', 'GuiasController@cortarFactura')->name('guias.index.fenix');
Route::view('/vista-guia-transporte', 'guias.pdf');

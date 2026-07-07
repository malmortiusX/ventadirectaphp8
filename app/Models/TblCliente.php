<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCliente extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_cliente';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'id_cliente',
        'nombre_cliente',
        'establecimiento',
        'cc_nit',
        'telefono',
        'direccion',
        'ciudad',
        'barrio',
        'correo',
        'interno',
        'ruta',
        'lista_precio',
        'lista_descuento',
        'sucursal',
        'codigo_vendedor',
        'codigo_cli',
        'lu',
        'sec_lu',
        'ma',
        'sec_ma',
        'mi',
        'sec_mi',
        'ju',
        'sec_ju',
        'vi',
        'sec_vi',
        'sa',
        'sec_sa',
        'do',
        'sec_do',
        's1',
        's2',
        's3',
        's4',
        's5',
        'bloqueado',
        'deuda',
        'mora',
        'cupo',
        'plazo',
        'inactivo',
        'descuento_c',
        'fecha_modificacion',
        'id_tipo_cliente',
        'fecha_descuento',
        'latitud',
        'longitud',
        'precision',
        'vendedor_ant',
        'creado_ced',
        'co',
        'cedula',
        'fecha_creacion',
        'estado_cliente',
        'aprobado_com',
        'tope',
        'valor_facturado',
        'tipo_documento',
        'ciudad_exp',
        'firma',
        'fecha_nacimiento',
        'genero',
        'imagen_cedula',
        'tipo_cliente',
        'zona',
        'campana'
    ];

    /**
     * Relaciones de eloquent
     */

    // Lista de Precios del Cliente
    public function listaPrecio() {
        return $this->belongsTo('App\Models\TblListaPrecio', 'lista_precio', 'codigo');
    }

    // Lista de Descuentos del Cliente
    public function listaDescuento() {
        return $this->belongsTo('App\Models\TblListaDescuento', 'lista_descuento', 'codigo');
    }

    // Ciudad
    public function ciudadCl() {
        return $this->belongsTo('App\Models\Ciudad', 'ciudad', 'id_ciudad');
    }

    // CiudadExpedicion
    public function ciudadExp() {
        return $this->belongsTo('App\Models\Ciudad', 'ciudad_exp', 'id_ciudad');
    }

    // Tipo de Cliente
    public function tipoCliente() {
        return $this->belongsTo('App\Models\TblTipoCliente', 'id_tipo_cliente', 'id_tipo_cliente');
    }

    // Pedidos
    public function pedidos() {
        return $this->hasMany('App\Models\TblPedido', 'id_cliente', 'id_cliente')->orderBy('fecha_ingreso', 'desc');
    }

    // No Compras
    public function noCompras() {
        return $this->hasMany('App\Models\TblNoCompra', 'id_cliente', 'id_cliente')->orderBy('fecha_no_compra', 'desc');
    }

    // Solicitudes de Descuento
    public function solicitudesDcto() {
        return $this->hasMany('App\Models\TblSolicitudDescuento', 'id_cliente', 'id_cliente');
    }

    // Abonos
    public function abonos() {
        return $this->hasMany('App\Models\TblAbono', 'cedula', 'cedula');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPedido extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_comercial';
    protected $primaryKey = 'id_comercial';

    protected $fillable = [
        'id_comercial',
        'id_cliente',
        'forma_pago',
        'n_factura',
        'fecha_ingreso',
        'id_usuario',
        'estado',
        'aprobado',
        'despachado',
        'codigo_lista',
        'observacion_pedido',
        'orden_carga',
        'creado_por',
        'fecha_entrega',
        'cop',
        'fecha_cierre',
        'nombre_m',
        'direccion_m',
        'tipo_m',
        'longitud',
        'latitud',
        'precision',
        'impreso',
        'orden',
        'hora_entrega',
        'estado_pedido',
        'en_ruta',
        'id_cliente_vd',
        'nombre_cliente_vd',
        'telefono_cliente_vd',
        'direccion_cliente_vd',
        'ciudad_cliente_vd',
        'valor_total',
        'orden_compra',
        'tipo_cliente'
    ];

    /**
     * Relaciones de eloquent
     */

    // Productos del pedido
    public function productos() {
        return $this->belongsToMany('App\Models\TblProducto', 'tbl_reg_comercial', 'id_comercial', 'id_producto')
            ->withPivot('id_reg_comercial',
                'unidades',
                'peso',
                'valor_un',
                'valor_kg',
                'venta_por',
                'descuento',
                'totald',
                'porcentaje_iva',
                'valor_iva',
                'total',
                'obsequio',
                'tiquetear'
            );
    }

    // Cliente normal
    public function cliente() {
        return $this->belongsTo('App\Models\TblCliente',
            'id_cliente',
            'id_cliente');
    }

    // Cliente final
    public function clienteVd() {
        return $this->belongsTo('App\Models\TblClienteVd', 'id_cliente_vd', 'id_cliente_vd');
    }

    // Cliente normal como final
    public function clienteVd2() {
        return $this->belongsTo('App\Models\TblCliente', 'id_cliente_vd', 'id_cliente');
    }

    // Centro de Distribución
    public function centroDist() {
        return $this->belongsTo('App\Models\TblCentDist', 'cop', 'cop');
    }

    // Vendedor
    public function vendedor() {
        return $this->belongsTo('App\Models\TblUsuario', 'id_usuario', 'id_usuario');
    }

    // Creador
    public function creador() {
        return $this->belongsTo('App\Models\TblUsuario', 'creado_por', 'id_usuario');
    }
}

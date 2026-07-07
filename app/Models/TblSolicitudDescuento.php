<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblSolicitudDescuento extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_solicitud_descuento';
    protected $primaryKey = 'id_solicitud_descuento';

    protected $fillable = [
        'id_solicitud_descuento', 'id_cliente', 'codigo_producto', 'porcentaje', 'kilos', 'unidades', 'fecha', 'usuario_solicita', 'usuario_revisa', 'usuario_aprueba', 'estado', 'fecha_creacion'
    ];

    public function producto(){
        return $this->belongsTo('App\Models\TblProducto', 'codigo_producto', 'codigo');
    }

    public function cliente(){
        return $this->belongsTo('App\Models\TblCliente', 'id_cliente', 'id_cliente');
    }

    public function usuarioSolicita(){
        return $this->belongsTo('App\Models\TblUsuario', 'usuario_solicita', 'id_usuario');
    }

    public function usuarioAprueba(){
        return $this->belongsTo('App\Models\TblUsuario', 'usuario_aprueba', 'id_usuario');
    }
}

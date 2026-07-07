<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPedidoSemanalCf extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_pedidos_cf';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'id_pedido', 'id_usuario', 'cop', 'fecha_ingreso', 'codigo_vendedor', 'semana', 'ano', 'estado', 'marcados'
    ];
    
    public function usuario() {
        return $this->belongsTo('App\Models\TblUsuario', 'id_usuario', 'id_usuario');
    }

    public function vendedor() {
        return $this->belongsTo('App\Models\TblUsuario', 'codigo_vendedor', 'codigo_vendedor');
    }
    
    public function productos() {
        return $this->belongsToMany('App\Models\TblProducto', 'tbl_reg_pedidos_cf', 'id_pedido', 'codigo', 'id_pedido', 'codigo')
                    ->withPivot('klu', 'ulu', 'kma', 'uma', 'kmi', 'umi', 'kju', 'uju', 'kvi', 'uvi', 'ksa', 'usa', 'kdo', 'udo', 'peso_unidad', 'undmed', 'peso');
    }

    // Centro de Distribución
    public function centroDist() {
        return $this->belongsTo('App\Models\TblCentDist', 'cop', 'cop');
    }
}

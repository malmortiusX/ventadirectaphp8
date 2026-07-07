<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TblListaPrecio extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $table = 'tbl_lista_precio';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'id_lista_precio', 'codigo', 'nombre', 'iva_incluido', 'promocion', 'lista_sondeo', 'fecha_activacion', 'fecha_creado', 'fecha_modificado', 'estado'
    ];

    // Productos de la lista
    public function productos() {
        return $this->belongsToMany('App\Models\TblProducto', 'tbl_rel_lista_precio', 'codigo_lista', 'codigo_producto', 'codigo', 'codigo')->withPivot('precio_unidad_inventario', 'precio_unidad_empaque', 'minimocant', 'minimoemp');
    }

    // Buscar Productos de la lista
    public function buscarProductos($nombre) {
        return $this->belongsToMany('App\Models\TblProducto', 'tbl_rel_lista_precio', 'codigo_lista', 'codigo_producto')
            ->withPivot('precio_unidad_inventario', 'precio_unidad_empaque', 'minimocant', 'minimoemp')
            ->where('nombre', 'like', '%' . $nombre . '%')
            ->limit(10)
            ->get();
    }
}

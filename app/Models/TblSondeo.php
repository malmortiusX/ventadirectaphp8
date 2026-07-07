<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblSondeo extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_sondeo';
    protected $primaryKey = 'id_sondeo';

    protected $fillable = [
        'id_sondeo', 'id_usuario', 'fecha_sondeo', 'regional', 'ciudad', 'id_canal', 'lista_precio', 'id_marca', 'otra_marca', 'codigo_producto', 'precio_empaque_avicampo', 'precio_inventario_avicampo', 'precio', 'precio_gramo', 'imagen', 'observaciones'
    ];

    public function usuario(){
        return $this->belongsTo('App\Models\TblUsuario', 'id_usuario', 'id_usuario');
    }

    public function canal(){
        return $this->belongsTo('App\Models\TblCanalVentas', 'id_canal');
    }

    public function marca(){
        return $this->belongsTo('App\Models\TblMarca', 'id_marca');
    }

    public function producto(){
        return $this->belongsTo('App\Models\TblProducto', 'codigo_producto', 'codigo');
    }
}

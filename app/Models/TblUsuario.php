<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\TblCentDist;

class TblUsuario extends Model
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'tbl_usuario';
    protected $primaryKey = 'id_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario',
        'nombres',
        'apellidos',
        'documento',
        'descripcion',
        'login',
        'clave',
        'correo',
        'telefono',
        'direccion',
        'nivel',
        'estado',
        'error_clave',
        'tiempo_bloqueo',
        'ingreso',
        'codigo_vendedor',
        'ultima_actualizacion',
        'fecha_modificado',
        'cop',
        'codcc',
        'porcentaje_maximo',
        'bloquear_descuento',
        'cambio_cop',
        'ciudad',
        'regional',
        'usuariolinux',
        'cambia_codcc',
        'cambia_rutero_varios',
        'color',
        'control_minimo',
        'descuento_volumen',
        'cc_nit_usuario',
        'pedidos_mismo_dia',
        'limite_mismo_dia',
        'crea_clientes',
        'limite_clientes_lv',
        'limite_clientes_sa',
        'correo_jefe',
        'pedido_minimo',
        'mostrar_orden_compra'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'clave', 'pregunta_secreta', 'respuesta_secreta', 'pin', 'lista_precio'
    ];

    /**
     * Relaciones de eloquent
     */

    // Pedidos del usuario
    public function pedidos() {
        return $this->hasMany('App\Models\TblPedido', 'id_usuario', 'id_usuario')->orderBy('fecha_ingreso', 'desc');
    }

    public function pedidosSemanales() {
        return $this->hasMany('App\Models\TblPedidoSemanal', 'codigo_vendedor', 'codigo_vendedor');
    }

    // Cliente asignado al usuario de venta directa
    public function cliente() {
        return $this->hasOne('App\Models\TblCliente', 'codigo_vendedor', 'codigo_vendedor');
    }

    // Clientes del usuario
    public function clientes() {
        return $this->hasMany('App\Models\TblCliente', 'codigo_vendedor', 'codigo_vendedor')->where('inactivo', 0)->where('aprobado_com', 1);
    }

    // Clientes del usuario
    public function clientesvd() {
        return $this->hasMany('App\Models\TblClienteVd', 'id_usuario', 'id_usuario');
    }

    // Centro de distribución principal
    public function centroDist() {
        return $this->belongsTo('App\Models\TblCentDist', 'cop', 'cop');
    }

    // Centros de distribución
    public function centrosDist() {
        return $this->belongsToMany('App\Models\TblCentDist', 'tbl_centdist_usuario', 'id_usuario', 'cop');
    }

    public function plantas() {
        return $this->belongsToMany('App\Models\TblCentDist', 'tbl_plantas_cop', 'codigo_vendedor', 'cop_planta', 'codigo_vendedor', 'cop');
    }

    // Solicitudes de descuento realizadas por el usuario
    public function solicitudesDcto() {
        return $this->hasMany('App\Models\TblSolicitudDescuento', 'usuario_solicita', 'id_usuario');
    }

    // Sondeos realizados por el usuario
    public function sondeos() {
        return $this->hasMany('App\Models\TblSondeo', 'id_usuario', 'id_usuario');
    }

    // Sondeos realizados por el usuario
    public function avisos() {
        return $this->hasMany('App\Models\TblAviso', 'nivel', 'nivel');
    }
}

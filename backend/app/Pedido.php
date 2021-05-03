<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cliente',
        'fecha_pedido',
        'precio_pedido',
        'notas',
        'tipo_entrega',
        'pagado',
        'codigo_pedido',
        'direccion_entrega',
        'entregado',
        'tipo_pago'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'id_cliente' ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha_pedido'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id_cliente' => 'integer',
        'precio_pedido' => 'float',
        'notas' => 'string',
        'tipo_entrega' => 'string',
        'pagado' => 'boolean',
        'codigo_pedido' => 'string',
        'direccion_entrega' => 'string',
        'entregado' => 'boolean',
        'tipo_pago' => 'string'
    ];

    /**
     * The validation rules
     * @var array
     */
    public static $rules = [
        'id_cliente' => 'required|exists:App\User,id',
        'fecha_pedido' => 'required',
        'precio_pedido' => 'required',
        'notas' => 'nullable',
        'tipo_entrega' => 'nullable',
        'pagado' => 'sometimes|required',
        'codigo_pedido' => 'required',
        'direccion_entrega' => 'nullable',
        'entregado' => 'sometimes|required',
        'tipo_pago' => 'required'
    ];


    /**
     * The validation filters
     * 
     * @var array
     */
    public static $filters = [
        'id_cliente' => 'digit',
        'fecha_pedido' => 'trim|format_date:d/m/Y, Y-m-d',
        'precio_pedido' => 'digit',
        'notas' => 'trim|escape|lowercase',
        'tipo_entrega' => 'trim|escape|capitalize',
        'codigo_pedido' => 'trim|escape|uppercase',
        'direccion_entrega' => 'trim|escape|lowercase',
        'tipo_pago' => 'trim|escape|uppercase'
    ];

    /**
     * The model'd default values for attributes
     * 
     * @var array
     */
    protected $attributes = [];

    /**
     * the PedidoComida related with de model
     */
    public function platos () {
        return $this->hasMany(\App\PedidoComida::class, 'id_pedido', 'id');
    }
}

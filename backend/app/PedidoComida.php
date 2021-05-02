<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Casts\DecimalCast;

class PedidoComida extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pedido',
        'id_comida',
        'cantidad',
        'precio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id_pedido' => 'string',
        'id_comida' => 'string',
        'cantidad' => 'integer',
        'precio' => DecimalCast::class,
    ];

    /**
     * The validation rules
     * @var array
     */
    public static $rules = [
        'id_pedido' => 'required|exists:App\Pedido,id',
        'id_comida' => 'required|exists:App\Comida,id',
        'cantidad' => 'required|numeric',
        'precio' => 'required',
    ];


    /**
     * The validation filters
     * 
     * @var array
     */
    public static $filters = [
        'id_pedido' => 'digit',
        'id_comida' => 'digit',
        'cantidad' => 'digit',
        'precio' => 'digit',
    ];

    /**
     * The model'd default values for attributes
     * 
     * @var array
     */
    protected $attributes = [];

    /**
     * the Comida related with the model
     */
    public function comida () {
        return $this->belongsTo(\App\Comida::class, 'id_comida', 'id');
    }
}

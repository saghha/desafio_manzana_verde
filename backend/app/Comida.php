<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\DecimalCast;

class Comida extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'url_photo',
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
        'nombre' => 'string',
        'descripcion' => 'string',
        'url_photo' => 'string',
        'precio' => DecimalCast::class,
    ];

    /**
     * The validation rules
     * @var array
     */
    public static $rules = [
        'nombre' => 'required',
        'descripcion' => 'nullable',
        'url_photo' => 'nullable',
        'precio' => 'required',
    ];


    /**
     * The validation filters
     * 
     * @var array
     */
    public static $filters = [
        'nombre' => 'trim|escape|capitalize',
        'descripcion' => 'trim|escape|lowercase',
        'url_photo' => 'trim|escape',
        'precio' => 'digit',
    ];

    /**
     * The model'd default values for attributes
     * 
     * @var array
     */
    protected $attributes = [];
}

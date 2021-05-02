<?php

namespace App\Http\Requests\PedidoComida;

use App\PedidoComida;
use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class CreatePedidoComidaRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     *  Validation rules to be applied to the input.
     *
     *  @return array
     */
    public function rules()
    {
        return PedidoComida::$rules;
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return PedidoComida::$filters;
    }
}

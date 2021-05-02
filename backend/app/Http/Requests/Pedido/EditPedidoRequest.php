<?php

namespace App\Http\Requests\Pedido;

use App\Pedido;
use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class EditPedidoRequest extends FormRequest
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
        return Pedido::$rules;
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return Pedido::$filters;
    }
}

<?php

namespace App\Http\Requests\Pedido;

use App\Pedido;
use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class CreatePedidoRequest extends FormRequest
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
        return [
            'fecha_pedido' => 'required',
            'precio_pedido' => 'required',
            'notas' => 'nullable',
            'tipo_entrega' => 'nullable',
            'pagado' => 'sometimes|required',
            'codigo_pedido' => 'required',
            'direccion_entrega' => 'nullable',
            'entregado' => 'sometimes|required',
            'tipo_pago' => 'required',
            'platos' => 'required|array|min:1',
            'platos.*.id_comida' => 'required|exists:App\Comida,id',
            'platos.*.cantidad' => 'required',
            'platos.*.precio' => 'required'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return [
            'fecha_pedido' => 'trim|format_date:d/m/Y, Y-m-d',
            'precio_pedido' => 'digit',
            'notas' => 'trim|escape|lowercase',
            'tipo_entrega' => 'trim|escape|capitalize',
            'codigo_pedido' => 'trim|escape|uppercase',
            'direccion_entrega' => 'trim|escape|lowercase',
            'tipo_pago' => 'trim|escape|uppercase',
            'platos.*.id_comida' => 'digit',
            'platos.*.cantidad' => 'digit',
            'platos.*.precio' => 'digit'
        ];
    }
}

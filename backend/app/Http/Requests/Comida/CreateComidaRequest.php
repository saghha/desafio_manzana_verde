<?php

namespace App\Http\Requests\Comida;

use App\Comida;
use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

class CreateComidaRequest extends FormRequest
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
        return Comida::$rules;
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return array
     */
    public function filters()
    {
        return Comida::$filters;
    }
}

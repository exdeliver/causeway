<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostCustomerRequest.
 */
class PostCustomerRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $nameExpression = '/^([_\p{Lu}\p{Lt}][_\p{Nd}\p{Ll}\p{Lm}\p{Lo} \',-."]+)+$/u';

        return [
            'first_name' => 'required|regex:' . $nameExpression,
            'last_name' => 'required|regex:' . $nameExpression,
            'email' => 'required|email|confirmed',
            'address' => 'required',
            'address_number' => 'required',
            'address_suffix' => 'nullable',
            'city' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
        ];
    }
}

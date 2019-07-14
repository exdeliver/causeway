<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostCheckoutRequest
 * @package Exdeliver\Causeway\Requests
 */
class PostCheckoutRequest extends FormRequest
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

        $rules = [
            'first_name' => 'required|regex:' . $nameExpression,
            'last_name' => 'required|regex:' . $nameExpression,
            'email' => 'required|email|confirmed',
            'address' => 'required',
            'address_number' => 'required',
            'address_suffix' => 'nullable',
            'city' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'shipping' => 'required',
            'terms_and_conditions' => 'required',
            'payment' => 'required',
        ];

        $shippableProductRules = [
            'shipping_first_name' => 'required_if:ship_different_address,1|nullable|regex:' . $nameExpression,
            'shipping_last_name' => 'required_if:ship_different_address,1|nullable|regex:' . $nameExpression,
            'shipping_address' => 'required_if:ship_different_address,1',
            'shipping_address_number' => 'required_if:ship_different_address,1',
            'shipping_address_suffix' => 'nullable',
            'shipping_city' => 'required_if:ship_different_address,1',
            'shipping_country' => 'required_if:ship_different_address,1',
            'shipping_zipcode' => 'required_if:ship_different_address,1',
        ];

        return array_merge($rules, $shippableProductRules ?? []);
    }
}
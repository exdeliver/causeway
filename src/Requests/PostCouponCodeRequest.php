<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostCouponCodeRequest
 * @package Exdeliver\Causeway\Requests
 */
class PostCouponCodeRequest extends FormRequest
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
        return [
            'name' => 'required',
            'coupon_code' => 'required|unique:shop_coupon_codes,coupon_code,' . $this->couponcode->id,
            'discount_type' => 'required',
            'discount_amount' => 'required',
        ];
    }
}
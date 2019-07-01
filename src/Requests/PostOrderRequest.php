<?php

namespace Exdeliver\Causeway\Requests;

use Exdeliver\Causeway\Domain\Services\CartService;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostOrderRequest
 * @package Exdeliver\Causeway\Requests
 */
class PostOrderRequest extends FormRequest
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
            'products' => 'array|causeway_shop_product_stock',
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        /** @var CartService $cartService */
        $cartService = app(CartService::class);

        $products = $cartService->all();

        $cartProducts = [];

        foreach ($products as $product) {
            $this->request->add(['products' => [$product->product_id => $product->quantity]]);
        }

        $input = $this->all();

        $this->replace($input);
    }
}

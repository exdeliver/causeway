<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostShopProductRequest
 * @package Exdeliver\Causeway\Requests
 */
class PostShopProductRequest extends FormRequest
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
            'title' => 'required',
            'slug' => 'required',
            'gross_price' => 'required',
            'vat' => 'required',
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = $this->all();

        $input['title'] = strip_tags($this->title);
        $input['description'] = clean($this->description);
        $input['slug'] = str_slug($this->title);

        $this->replace($input);
    }
}

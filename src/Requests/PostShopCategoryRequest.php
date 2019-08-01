<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostShopCategoryRequest.
 */
class PostShopCategoryRequest extends FormRequest
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
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        $input['title'] = strip_tags($this->title);
        $input['description'] = clean($this->description);
        $input['slug'] = str_slug($this->title);
        $input['parent_id'] = empty($input['parent_id']) ? null : $input['parent_id'];

        $this->replace($input);
    }
}

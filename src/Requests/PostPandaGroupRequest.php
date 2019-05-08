<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostGroupRequest
 * @package Exdeliver\Causeway\Requests
 */
class PostGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        if (isset($this->group)) {
            $rules['label'] = 'required|unique:groups,label,' . $this->group->id . ',id';
            $rules['name'] = 'required|unique:groups,name,' . $this->group->id . ',id';
        } else {
            $rules['name'] = 'required|unique:groups,name';
        }

        return $rules;
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        if (isset($this->group)) {
            $input['label'] = str_slug($this->name);
        }
        $this->replace($input);
    }
}

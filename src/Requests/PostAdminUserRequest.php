<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAdminUserRequest extends FormRequest
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
        $rules = [];
        $rules['email'] = 'required|unique:users,email,' . $this->user->id ?? null;
        $rules['first_name'] = 'required';
        $rules['last_name'] = 'required';

        return $rules;
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->except(['roles']));

        $input['roles'] = $this->roles;
        $input['name'] = $this->first_name . ' ' . $this->last_name;

        $this->replace($input);
    }
}

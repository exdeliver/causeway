<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAdminRoleRequest extends FormRequest
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
        $rules['name'] = 'required|unique:roles,name,'.$this->role->id ?? null;
        $rules['guard_name'] = 'required';

        return $rules;
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->except(['permissions']));

        $input['permissions'] = $this->permissions;
        $input['name'] = str_slug($this->name);

        $this->replace($input);
    }
}

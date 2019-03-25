<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostNewThreadRequest extends FormRequest
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
            'content' => 'required',
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        $input['slug'] = str_slug($this->title);

        $input['content'] = clean($this->get('content'));

        $this->replace($input);
    }
}

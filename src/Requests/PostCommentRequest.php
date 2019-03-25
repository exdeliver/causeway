<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends FormRequest
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
            'comment' => 'required',
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        $input['comment'] = clean($this->comment);

        $this->replace($input);
    }
}

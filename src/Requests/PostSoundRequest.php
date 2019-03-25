<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSoundRequest extends FormRequest
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
            'artist' => 'required',
            'name' => 'required',
            'filename' => 'required|mimes:mpga,wav',
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        $input['description'] = clean($this->description);

        $this->replace($input);
    }
}

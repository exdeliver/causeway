<?php

namespace Exdeliver\Causeway\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAdminPhotoAlbumRequest extends FormRequest
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

        if (isset($this->album)) {
            $rules['label'] = 'required|unique:photo_albums,label,'.$this->album->id.',id';
            $rules['name'] = 'required|unique:photo_albums,name,'.$this->album->id.',id';
        } else {
            $rules['name'] = 'required|unique:photo_albums,name';
        }
        $rules['file'] = 'image|max:10240';

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
        $input['name'] = strip_tags($this->name);
        $input['description'] = clean($this->description);

        $this->replace($input);
    }
}

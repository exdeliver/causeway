<?php

namespace Exdeliver\Causeway\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostEventRequest
 * @package Exdeliver\Causeway\Requests
 */
class PostEventRequest extends FormRequest
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
            'start_datetime' => !isset($this->full_day) ? ['required', 'date', request()->start_datetime ? 'before:end_datetime' : ''] : [],
            'end_datetime' => !isset($this->full_day) ? ['date', request()->start_datetime ? 'after:start_datetime' : ''] : [],
        ];
    }

    /**
     * Prepare for validation.
     */
    public function prepareForValidation()
    {
        $input = array_map('trim', $this->all());

        $input['start_datetime'] = isset($this->full_day) ? Carbon::parse($this->start_datetime)->startOfDay() : Carbon::parse($this->start_datetime);
        $input['end_datetime'] = isset($this->full_day) ? Carbon::parse($this->end_datetime)->endOfDay() : Carbon::parse($this->end_datetime);

        $input['slug'] = str_slug($this->title);
        $input['user_id'] = auth()->user()->id;
        $input['description'] = clean($this->description);

        $this->replace($input);
    }
}

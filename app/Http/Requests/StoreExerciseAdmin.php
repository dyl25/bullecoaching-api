<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseAdmin extends FormRequest
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
            'userId' => 'bail|required|numeric|exists:users,id',
            'title' => 'bail|required||string|min:4|max:100',
            'video' => 'bail|sometimes|required|file|mimes:mp4,webm|max:40000',
            'beginingImage' => 'bail|sometimes|required|file|mimes:jpeg,jpg,png|max:1000',
            'endingImage' => 'bail|sometimes|required|file|mimes:jpeg,jpg,png|max:1000',
            'explenation' => 'bail|required|string|min:5',
            'difficulty' => 'bail|required|min:1|max:1|exists:difficulties,id',
            'tags' => 'nullable|array|max:5',
            'tags.*' => 'nullable|string|distinct|min:3'
        ];
    }
}

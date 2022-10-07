<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreelanceProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role_id === 3;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'avatar' => 'nullable|string|mimes:png,jpg,svg,',
            
            'profession' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'description' => 'required|string|max:100',
            
            // 'link' => 'nullable|array',
            'link_name.*' => 'string|distinct:ignore_case|nullable',
            'link_url.*' => 'nullable|required_with:link_name.*|distinct:ignore_case|url',
            
            // 'experience' => 'nullable|array',
            'company.*' => 'string|distinct:ignore_case|nullable',
            'job_title.*' => 'required_with:company.*|string|distinct:ignore_case|nullable',
            'job_description.*' => 'string|nullable',
            'start_at.*' => 'required_with:company.*|date|nullable',
            'end_at.*' => 'date|after_or_equal:start_at.*|nullable',
        ];
    }

    public function messages()
    {
        return [
            'link_url.*.url' => 'This field must be a valid url',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role_id === 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'sub_category' => 'exists:sub_categories,id',
            'title' => 'required|string',
            'type' => 'required|in:1,2,3,4',
            'location' => 'nullable|string',
            'description' => 'required|string',
            'salary' => 'required|numeric',
            'duration' => 'required|numeric',
            'deadline' => 'required|after_or_equal:' . today(),
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:1024',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
            'company' => 'nullable|array',
            'company.name' => 'required_with:company.url|required_with:company.description|string|nullable',
            'company.url' => 'string|url|nullable',
            'company.description' => 'string|nullable',
        ];
    }

    public function messages()
    {
        return [
            'sub_category.exists' => 'The category must be a correct value',
            'tags.*.exists' => 'The tag at #:position must be a correct value',
        ];
    }
}

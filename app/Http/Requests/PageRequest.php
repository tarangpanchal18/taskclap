<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:100',
            'description' => 'required|min:5|max:500',
            'seo_keywords' => 'required|min:5|max:500',
            'seo_description' => 'required|min:5|max:5000',
            'page_image' => 'required|mimes:jpg,jpeg,png,gif|max:5120',
            'status' => 'required',
        ];

        if ($this->method() == 'POST') {
            $rules['image'] = 'required|mimes:jpg,jpeg,png,gif|max:5120';
        }

        return $rules;
    }
}

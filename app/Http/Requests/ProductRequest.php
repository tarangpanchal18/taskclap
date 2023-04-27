<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'category_id' => 'required|integer',
            'sub_category_id' => 'nullable|integer',
            'title' => 'required|min:3|max:100',
            'description' => 'required|min:5|max:500',
            'long_description' => 'nullable|min:5|max:5000',
            'price' => 'required|decimal:0,4',
            'commission' => 'required|integer',
            'approx_duration' => 'required|min:1|max:100',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:5120',
            'status' => 'required',
        ];
    }
}

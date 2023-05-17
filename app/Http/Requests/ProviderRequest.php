<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProviderRequest extends FormRequest
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

        $rule = [
            'category_id' => 'required|array',
            'name' => 'required|min:3|max:100',
            'email' => [
                'nullable', 'min:3', 'max:100', 'email:rfc', Rule::unique('providers', 'email')->ignore($this->provider->id)
            ],
            'phone' => 'required|numeric|digits_between:9,10',
            'address' => 'nullable|min:10|max:1000',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:5120',
            'id_proof' => 'nullable|mimes:jpg,jpeg,png,gif|max:5120',
            'notes' => 'nullable|min:3|max:1000',
            'vehicle_number' => 'nullable|min:10|max:50',
            'status' => 'required',
        ];

        if ($this->method() == 'POST') {
            $rule += [
                'email' => ['nullable', 'min:3', 'max:100', 'email:rfc', Rule::unique('providers', 'email')],
            ];
        }

        return $rule;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PromocodeRequest extends FormRequest
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
        $method = $this->method();
        $rule = [
            'promocode' => [
                'required','alpha_num','min:4','max:10',Rule::unique('promocodes', 'promocode')->ignore($this->route('promocode')->id)
            ],
            'description' => 'required|alpha_num|min:5|max:200',
            'discount_type' => 'required',
            'validity' => 'required',
            'start_date' => 'required_if:validity,Dynamic',
            'end_date' => 'required_if:validity,Dynamic',
            'value' => 'required|numeric|min:1|max:9999',
            'limit' => 'nullable',
            'status' => 'required',
        ];

        if ($method == 'POST') {
            $rule += [
                'promocode' => ['required','alpha_num','min:4','max:10',Rule::unique('promocodes', 'promocode')],
            ];
        }

        return $rule;
    }
}

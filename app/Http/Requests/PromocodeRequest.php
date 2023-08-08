<?php

namespace App\Http\Requests;

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
        return [
            'promocode' => 'required|alpha_num|min:6|max:8',
            'description' => 'required|alpha_num|min:5|max:200',
            'disount_type' => 'required',
            'validity' => 'required',
            'start_date' => 'date|required_if:validity,Dynamic',
            'end_date' => 'date|required_if:validity,Dynamic',
            'type' => 'required',
            'value' => 'required|digits',
            'limit' => 'nullable',
            'status' => 'required',
        ];
    }
}

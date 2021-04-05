<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class NetworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:55|min:8',
            'phone' => "required|unique:networks,phone,{$this->segment(3)},id|max:15|min:10",
            'email' => "required|unique:networks,email,{$this->segment(3)},id|max:55|email",
            'city' => 'required|max:55',
            'uf' => 'required|max:2',
            'network_id' => "nullable|integer|different:id",
        ];
    }

    public function messages()
    {
        return [
            'network_id.different' => 'Você não pode escolher a sí mesmo como padrinho.',
        ];
    }
}

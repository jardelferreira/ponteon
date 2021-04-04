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
            'phone' => 'required|unique:networks,phone|max:15|min:10',
            'city' => 'required|max:55',
            'uf' => 'required|max:2',
            'network_id' => 'nullable|integer',
        ];
    }
}

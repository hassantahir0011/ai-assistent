<?php

namespace App\Http\Requests;

class DripConnectionRequest extends JsonFormRequest
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

        $rules = [
            'api_token' => 'required',


        ];
        return $rules;
    }

    public function messages()
    {
        $error_messages =
            [
                'api_token.required' => "API Token is required."


            ];
        return $error_messages;
    }
}

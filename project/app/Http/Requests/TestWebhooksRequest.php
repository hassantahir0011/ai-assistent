<?php

namespace App\Http\Requests;



class TestWebhooksRequest extends JsonFormRequest
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
            'config_id' => 'required',


        ];
        return $rules;
    }

    public function messages()
    {
        $error_messages =
            [

                'config_id.required' => "No configuration details found.",

            ];
        return $error_messages;
    }
}

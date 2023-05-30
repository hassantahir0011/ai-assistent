<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralEventRequest extends FormRequest
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
            'webhook_topic_id' => 'required'
        ];
        // channel ids of  klaviyo,emma
        $channel_name = config('channel.name');
        if (in_array($channel_name, ['google_sheets', 'post_to_url'])) {
            $rules['post_url'] = 'required';
        }
        else {
            $rules['api_fields'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        $error_messages =
            [
                'post_url.required' => "Please enter url to post webhooks.",
                'webhook_topic_id.required' => "No event details found.",
                'api_fields.required' => "Please store some events setup page.",

            ];
        return $error_messages;
    }
}

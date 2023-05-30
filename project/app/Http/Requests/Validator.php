<?php

namespace App\Http\Requests;

abstract class Validator
{

    protected $input;
    public $messages;
    protected $file_size;
    protected $mimetype;
    public static $mime_types_lengths;
    public static $rules;

    public function __construct($input, $mimetype, $file_size)
    {
        $this->input = $input;
        $this->mimetype = $mimetype;
        $this->file_size = $file_size;

    }

    public function fails()
    {
        $validation = \Validator::make($this->input, [
            'media_link' => [
                function ($attribute, $value, $fail) {
                    if (!in_array($this->mimetype, array_keys(static::$mime_types_lengths)))
                        $fail('Invalid file or content type.Please choose files of required extension.');
                    foreach (static::$mime_types_lengths as $type => $length):
                        if ($type == $this->mimetype && $length < $this->file_size) {
                            $fail("Exceeding file or content size.File object or URL content length should be equal or less than $length kb.");
                            break;
                        }
                    endforeach;
                }
            ],
            'contact_photo_link' => [
                function ($attribute, $value, $fail) {
                    if (!in_array($this->mimetype, array_keys(static::$mime_types_lengths)))
                        $fail('Invalid file or content type.Please choose files of required extension.');
                    foreach (static::$mime_types_lengths as $type => $length):
                        if ($type == $this->mimetype && $length < $this->file_size) {
                            $fail("Exceeding file or content size.File object or URL content length should be equal or less than $length kb.");
                            break;
                        }
                    endforeach;
                }
            ]

        ]);

        if ($validation->fails()) {
            $this->messages = $validation->messages()->get('*');
            return true;
        }

        return false;
    }

    public function messages()
    {

        return $this->messages;
    }
}
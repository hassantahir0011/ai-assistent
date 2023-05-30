<?php

namespace App\Http\Requests;

class GmailUrlValidation extends Validator
{

    public static $rules = [
        'media_link' => ''
    ];

    public static $mime_types_lengths = [
        'image/png' => '2048',
        'image/jpg' => '2048',
        'image/jpeg' => '2048',
        'image/gif' => '2048',
        'image/pdf' => '2048',
        'image/doc' => '2048',
        'image/xls' => '2048',

//        'video/mp4' => '15360'

    ];




}

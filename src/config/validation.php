<?php

use Illuminate\Validation\Rule;

// example rules
$rules = [
    'UserController' => [
        'register' => [
            'name'     => 'required|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->where('status', 1)],
            'password' => 'required|min:6|confirmed',
            'gender'   => 'required|in:male,female',
            'birthday' => 'required|date_format:Y-n-j',
        ],
        'update' => function ($request) {
            return [
                'name'     => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users,email,'.$request->user()->id,
                'gender'   => 'required|in:male,female',
                'birthday' => 'required|date_format:Y-n-j',
            ];
        }
    ],
    'ResetPasswordController' => [
        'getResetMethods' => [
            'keyword' => 'required',
        ],
        'sendToken' => [
            'method'  => 'required|in:mail,phone_number',
            'keyword' => 'required',
        ],
        'reset' => [
            'token'    => 'required',
            'password' => 'required|min:6|confirmed',
        ],
    ],
    'Student\LessonsController' => [
        'create' => [
            'date'        => 'required|date_format:Y-n-j',
            'time'        => 'required|date_format:H:i',
            'duration'    => 'required',
            'teacher_id'  => 'required',
            'language_id' => 'required',
        ],
    ],
];

return [
    'rules' => $rules,
    'namespace' => 'App\Http\Controllers',
];

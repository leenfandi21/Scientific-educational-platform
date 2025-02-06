<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
class UserServices
{
    public function validateData(array $data)
    {
        $rules = [
         'f_name' => 'required',
        's_name' => 'required',
        'phone_number' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'birthday' => 'required|date',
        'gender' => 'required',
        'password' => 'required|min:6',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

    }

    public function validateDatalog(array $data)
    {
        $rules = [

            'email' => 'required|string|email',
            'password' => 'required|min:8',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        return [
            'success' => true,
            'message' => 'Data is valid.',
        ];
    }
    protected function validateDataadmin(array $data)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8',
            'user_type' => 'required|in:user,admin',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
            ];
        }

        return [
            'success' => true,
            'message' => 'Data is valid.',
        ];
    }
}

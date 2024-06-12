<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordExpiredRequest extends FormRequest
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
        return [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed|regex:"^(?=.*[a-z])(?=.*[A-Z]).{8,}$"',
        ];
    }
    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'Password must contain at least 1 uppercase letter and 1 number.',
        ];
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($request, $response)
    {
        return redirect()->route(homeRoute())->withFlashSuccess(trans($response));
    }
}

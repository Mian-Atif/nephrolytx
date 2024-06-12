<?php

namespace App\Http\Requests\Backend\Person;

use App\Http\Requests\Request;

/**
 * Class StorePersonRequest.
 */
class StorePersonRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-person');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|max:50',
            'email'       => 'required|email|max:50',
            'phone'       => 'required',
            'address1'       => 'required|max:100',
            'address2'       => 'required|max:100',
        ];
    }
}

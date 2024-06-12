<?php

namespace App\Http\Requests\Backend\Practice;

use Illuminate\Foundation\Http\FormRequest;

class CreatePracticeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-practice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'person'       => 'required',
//            'name'       => 'required|max:191',
//            'email'       => 'required|email|max:191|unique',
//            'phone'       => 'required',
//            'address1'       => 'required',
//            'address2'       => 'required',
//            'fax'       => 'required',
//            'website'       => 'required',
//            'npi'       => 'required',
//            'speciality'       => 'required',
//            'city'       => 'required',
//            'state'       => 'required',
//            'zip'       => 'required',
//            'owner'       => 'required',
//            'practice_owner_email'       => 'required',
//            'practice_owner_name'       => 'required',
//            'practice_type'       => 'required',
            //Put your rules for the request in here
            //For Example : 'title' => 'required'
            //Further, see the documentation : https://laravel.com/docs/6.x/validation#creating-form-requests
        ];
    }

    public function messages()
    {
        return [
            //The Custom messages would go in here
            //For Example : 'title.required' => 'You need to fill in the title field.'
            //Further, see the documentation : https://laravel.com/docs/6.x/validation#customizing-the-error-messages
        ];
    }
}

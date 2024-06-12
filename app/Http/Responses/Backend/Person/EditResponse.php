<?php

namespace App\Http\Responses\Backend\Person;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var \App\Models\Person\Person
     */
    protected $person;

    /**
     * @param \App\Models\Person\Person $person
     */
    public function __construct($person)
    {
        $this->person = $person;
    }

    /**
     * toReponse.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.person.edit')
            ->withPerson($this->person);
    }
}

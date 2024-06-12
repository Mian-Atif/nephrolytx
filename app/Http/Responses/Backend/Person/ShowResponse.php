<?php

namespace App\Http\Responses\Backend\Person;

use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable
{
    /**
     * @var \App\Models\Person\Person $person
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
     * In Response.
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.person.show')->withPerson($this->person);
    }
}

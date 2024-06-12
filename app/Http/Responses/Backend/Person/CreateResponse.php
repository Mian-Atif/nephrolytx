<?php

namespace App\Http\Responses\Backend\Person;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * @var \App\Models\Person\Person
     */
    protected $person;

    /**
     * @param \Illuminate\Database\Eloquent\Collection $person
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
        return view('backend.person.create')->with([
            'person' => $this->person,
        ]);
    }
}

<?php

namespace App\Http\Responses\Backend\Access\User;

use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable
{
    /**
     * @var \App\Models\Access\Role\Role
     */
    protected $roles;
    protected $persons;

    /**
     * @param \Illuminate\Database\Eloquent\Collection $roles
     */
    public function __construct($roles,$persons)
    {
        $this->roles = $roles;
        $this->persons = $persons;
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
        return view('backend.access.users.create')->with([
            'roles' => $this->roles,
            'persons' => $this->persons,
        ]);
    }
}

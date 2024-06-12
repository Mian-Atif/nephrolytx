<?php

namespace App\Http\Responses\Backend\PracticeUser;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PracticeUser\Practiceuser
     */
    protected $practiceusers;

    /**
     * @param App\Models\PracticeUser\Practiceuser $practiceusers
     */
    public function __construct($practiceusers)
    {
        $this->practiceusers = $practiceusers;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.practiceusers.edit')->with([
            'practiceusers' => $this->practiceusers
        ]);
    }
}
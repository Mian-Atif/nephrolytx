<?php

namespace App\Http\Responses\Backend\PracticeUserManagement;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PracticeUserManagement\PracticeUserManagement
     */
    protected $practiceusermanagements;

    /**
     * @param App\Models\PracticeUserManagement\PracticeUserManagement $practiceusermanagements
     */
    public function __construct($practiceusermanagements)
    {
        $this->practiceusermanagements = $practiceusermanagements;
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
        return view('backend.practiceusermanagements.edit')->with([
            'practiceusermanagements' => $this->practiceusermanagements
        ]);
    }
}
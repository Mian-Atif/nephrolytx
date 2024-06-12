<?php

namespace App\Http\Responses\Backend\PracticeManagement;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PracticeManagement\PracticeManagement
     */
    protected $practicemanagements;

    /**
     * @param App\Models\PracticeManagement\PracticeManagement $practicemanagements
     */
    public function __construct($practicemanagements)
    {
        $this->practicemanagements = $practicemanagements;
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
        return view('backend.practicemanagements.edit')->with([
            'practicemanagements' => $this->practicemanagements
        ]);
    }
}
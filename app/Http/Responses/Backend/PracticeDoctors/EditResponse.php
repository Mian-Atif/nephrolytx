<?php

namespace App\Http\Responses\Backend\PracticeDoctors;

use App\Models\Practice\Practice;
use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PracticeDoctors\PracticeDoctor
     */
    protected $practicedoctors;

    /**
     * @param App\Models\PracticeDoctors\PracticeDoctor $practicedoctors
     */
    public function __construct($practicedoctors)
    {
        $this->practicedoctors = $practicedoctors;
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

        return view('backend.practicedoctors.edit')->with([
            'practicedoctors' => $this->practicedoctors
        ]);
    }
}
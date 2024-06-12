<?php

namespace App\Http\Responses\Backend\PracticeLocations;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\PracticeLocations\PracticeLocation
     */
    protected $practicelocations;

    /**
     * @param App\Models\PracticeLocations\PracticeLocation $practicelocations
     */
    public function __construct($practicelocations)
    {
        $this->practicelocations = $practicelocations;
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
        return view('backend.practicelocations.edit')->with([
            'practicelocations' => $this->practicelocations
        ]);
    }
}
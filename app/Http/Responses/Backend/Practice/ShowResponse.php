<?php

namespace App\Http\Responses\Backend\Practice;

use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable
{
    /**
     * @var \App\Models\practice\practice $practice
     */
    protected $practice;

    /**
     * @param \App\Models\practice\practice $practice
     */
    public function __construct($practice)
    {
        $this->practice = $practice;
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
        return view('backend.practices.show')->withpractice($this->practice);
    }
}

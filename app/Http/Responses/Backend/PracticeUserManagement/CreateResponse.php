<?php

namespace App\Http\Responses\Backend\PracticeUserManagement;

use App\Models\PracticeLocations\PracticeLocation;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;

class CreateResponse implements Responsable
{
    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        $locations  = PracticeLocation::where('practice_id',Auth::user()->practice_id)->get();
        return view('backend.practiceusermanagements.create',compact('locations'));
    }
}
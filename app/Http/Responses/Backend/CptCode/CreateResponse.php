<?php

namespace App\Http\Responses\Backend\CptCode;

use App\Models\BillingManager\BillingManager;
use App\Models\Practice\Practice;
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
        $user = Auth::user();
        $practices=Practice::get();
        if(!is_null($user->roles()->where('name', 'Billing Manager')->first())){
            $practices=BillingManager::where('person_id', $user->person_id)->with('practice')->get();
            $practices=$practices->pluck('practice');
        }
        return view('backend.cptcodes.create',compact('practices'));
    }
}
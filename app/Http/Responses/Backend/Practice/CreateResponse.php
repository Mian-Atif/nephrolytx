<?php

namespace App\Http\Responses\Backend\Practice;

use App\City;
use App\Models\Person\Person;
use App\Models\Speciality;
use App\State;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Config;

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
        $specialities=Speciality::where('model_type','practice')->get();
        $paraciteTypes=Config::get('constants.paracite_type')?Config::get('constants.paracite_type'):'';
        $cities=City::first();
        $states = State::where('country_id',231)->get();
//        $states=State::get();
        $person=Person::with('user')->get();

        return view('backend.practices.create',compact('specialities','paraciteTypes','cities','states','person'));
    }
}
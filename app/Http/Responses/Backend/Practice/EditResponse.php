<?php

namespace App\Http\Responses\Backend\Practice;

use App\AnalyticData;
use App\Models\Speciality;
use App\State;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\PracticeLocations\PracticeLocation;
use App\Models\Practice\Practice;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Practice\Practice
     */
    protected $practices;

    /**
     * @param App\Models\Practice\Practice $practices
     */
    public function __construct($practices)
    {
        $this->practices = $practices;
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
        $user = $this->practices->users;
        $practice_id = $this->practices->id ;

      /*  if ($user->roles()->first()->name == 'Practice User') {
            $person = $user->person;
            $providers = $person->doctors;
            $locations = $person->locations;

        } else {*/
            $practice = Practice::find($practice_id);
            $providersLocation = $practice->getDotorsdata;
            $locations = $practice->getLocationdata;
//        }
        $locations  = $this->practices->getLocationdata;
        $doctors  = $this->practices->getDotorsdata;
        $billingManagers  = $this->practices->getBillingManagers;
        $specialities=Speciality::where('model_type','practice')->get();
        $states = State::get();
        $paraciteTypes=Config::get('constants.paracite_type')?Config::get('constants.paracite_type'):'';
        return view('backend.practices.edit')->with([
            'practice' => $this->practices,
            'specialities' =>$specialities,
            'paraciteTypes' => $paraciteTypes,
            'locations' => $locations,
            'doctors'=>$doctors,
            'billingManagers'=>$billingManagers,
            'providersLocation'=>$providersLocation,
            'locations'=>$locations,
            'states'=>$states,


        ]);
    }
}
<?php

namespace App\Models\Practice\Traits;

/**
 * Class PracticeRelationship
 */
trait PracticeRelationship
{
    /*
    * put you model relationships here
    * Take below example for reference
    */
    /*
     */

    public function detail()
    {
        return $this->belongsTo('App\Models\PracticeProviderDetail','detail_id');
    }


    public function person()
    {
        return $this->belongsTo('App\Models\Person\Person','person_id');
    }


    public function specialities()
    {
        return $this->belongsToMany('App\Models\Speciality','speciality_practice_provider','source_id','speciality_id')->withPivot('type');
    }


    public function  getLocationdata(){

        return $this->hasMany('App\Models\PracticeLocations\PracticeLocation','practice_id')->orderBy('location_name', 'asc');

    }

    public  function  getDotorsdata(){
        return $this->hasMany('App\Models\PracticeDoctors\PracticeDoctor','practice_id');
    }

    public  function  getBillingManagers(){
        return $this->hasMany('App\Models\BillingManager\BillingManager','practice_id');
    }
    public  function  getCptCode(){
        return $this->hasMany('App\Models\CptCode\CptCode','practice_id');
    }
    public  function  getCptCodeInsurance(){
        return $this->hasMany('App\Models\CptCodeInsurancePrices\CptCodeInsurancePrice','practice_id');
    }
    public  function users(){
        return $this->hasMany('App\Models\Access\User\User','practice_id');
    }




}

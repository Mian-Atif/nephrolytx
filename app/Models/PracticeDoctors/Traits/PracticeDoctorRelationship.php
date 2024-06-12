<?php

namespace App\Models\PracticeDoctors\Traits;
use App\Models\Person\Person;
use App\Models\Practice\Practice;
use App\Models\PracticeLocations\PracticeLocation;

/**
 * Class PracticeDoctorRelationship
 */
trait PracticeDoctorRelationship
{
    /*
    * put you model relationships here
    * Take below example for reference
    */
    /*
    public function users() {
        //Note that the below will only work if user is represented as user_id in your table
        //otherwise you have to provide the column name as a parameter
        //see the documentation here : https://laravel.com/docs/6.x/eloquent-relationships
        $this->belongsTo(User::class);
    }
     */

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function practice(){
        return $this->belongsTo(Practice::class);
    }

    public function locations(){
        return $this->belongsToMany(PracticeLocation::class,'practice_location_doctors','doctor_id','location_id');
    }
}

<?php

namespace App\Models\PracticeLocations\Traits;
use App\Models\Addresses\Addresses;
use App\Models\Practice\Practice;
use App\Models\PracticeDoctors\PracticeDoctor;
use App\Models\PracticeLocations\PracticeLocation;

/**
 * Class PracticeLocationRelationship
 */
trait PracticeLocationRelationship
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

    public function address()
    {
        return $this->morphOne(Addresses::class, 'addressable');
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class);
    }


    public function doctors(){
        return $this->belongsToMany(PracticeDoctor::class,'practice_location_doctors','location_id','doctor_id');
    }








}

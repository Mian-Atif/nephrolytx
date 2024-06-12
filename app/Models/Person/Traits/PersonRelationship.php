<?php

namespace App\Models\Person\Traits;

/**
 * Class PersonRelationship
 */
trait PersonRelationship
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
    public function user(){
        return $this->hasOne('App\Models\Access\User\User');
    }

    public function practice(){
        return $this->hasOne('App\Models\Practice\Practice','person_id');
    }

    public function practiceUser(){
        return $this->hasOne('App\Models\PracticeUser\Practiceuser','person_id');
    }

    public function  locations(){

        return $this->belongsToMany('App\Models\PracticeLocations\PracticeLocation','person_practice_privileges','person_id','location_id');

    }

    public  function  doctors(){
        return $this->belongsToMany('App\Models\PracticeDoctors\PracticeDoctor','person_practice_privileges','person_id','doctor_id');
    }



}

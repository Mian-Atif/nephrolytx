<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeProviderDetail extends Model
{
    protected $table='practice_provider_details';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
        'address_1','address_2','last_name','city','state','phone','fax','website','zip_code','npi'
    ];


  /*  public function practice()
    {
        return $this->hasOne('App\Models\Practice\Practice');
    }*/

    public function city()
    {
        return $this->hasOne('App\Models\City','id','country_id');
    }

}

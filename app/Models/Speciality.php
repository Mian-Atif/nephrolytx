<?php


namespace App\Models;


use Arcanedev\Support\Database\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speciality extends Model
{

    use SoftDeletes;
    protected $table='specialities';
    protected $fillable = [
        'id', 'name', 'model_type'
    ];

    public function specialities()
    {
        return $this->belongsToMany('App\Models\Speciality','speciality_practice_provider','speciality_id','source_id')->withPivot('type');
    }


}
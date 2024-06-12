<?php

namespace App\Models\Patient;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient\Traits\PatientAttribute;
use App\Models\Patient\Traits\PatientRelationship;

class Patient extends Model
{
    use ModelTrait,
        PatientAttribute,
    	PatientRelationship {
            // PatientAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'patients';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
        'name','type','email','owner','speciality_id','user_id','detail_id'
    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * Dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}

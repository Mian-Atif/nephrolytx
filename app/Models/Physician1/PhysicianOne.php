<?php

namespace App\Models\Physician1;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Physician1\Traits\PhysicianOneAttribute;
use App\Models\Physician1\Traits\PhysicianOneRelationship;

class PhysicianOne extends Model
{
    use ModelTrait,
        PhysicianOneAttribute,
    	PhysicianOneRelationship {
            // PhysicianOneAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'physicianones';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [

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

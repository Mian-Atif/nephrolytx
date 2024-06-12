<?php

namespace App\Models\PracticeLocations;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\PracticeLocations\Traits\PracticeLocationAttribute;
use App\Models\PracticeLocations\Traits\PracticeLocationRelationship;

class PracticeLocation extends Model
{
    use ModelTrait,
        PracticeLocationAttribute,
    	PracticeLocationRelationship {
            // PracticeLocationAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'practice_locations';

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

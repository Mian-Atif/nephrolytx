<?php

namespace App\Models\PracticeUser;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\PracticeUser\Traits\PracticeuserAttribute;
use App\Models\PracticeUser\Traits\PracticeuserRelationship;

class Practiceuser extends Model
{
    use ModelTrait,
        PracticeuserAttribute,
    	PracticeuserRelationship {
            // PracticeuserAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'practice_users';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [

    ];

    public $timestamps = false;

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

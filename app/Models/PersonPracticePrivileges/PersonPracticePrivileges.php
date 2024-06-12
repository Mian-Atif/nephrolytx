<?php

namespace App\Models\PersonPracticePrivileges;

use App\Models\Access\User\User;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class PersonPracticePrivileges extends Model
{


    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'person_practice_privileges';

    /**
     * Mass Assignable fields of model
     * @var array
     */


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
    public $timestamps = false;

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

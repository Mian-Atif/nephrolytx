<?php

namespace App\Models\Person;

use App\Models\Access\User\User;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person\Traits\PersonAttribute;
use App\Models\Person\Traits\PersonRelationship;

class Person extends Model
{
    use ModelTrait,
        PersonAttribute,
    	PersonRelationship {
            // PersonAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'persons';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'email',
        'address1',
        'address2',
        'taxonomy_code',
        'npi'
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
    public function user()
    {
        return $this->belongsTo(User::class);

    }
}

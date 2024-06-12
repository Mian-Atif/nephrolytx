<?php

namespace App\Models\BillingManager;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\BillingManager\Traits\BillingManagerAttribute;
use App\Models\BillingManager\Traits\BillingManagerRelationship;

class BillingManager extends Model
{
    use ModelTrait,
        BillingManagerAttribute,
    	BillingManagerRelationship {
            // BillingManagerAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'practice_billing_manager';

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

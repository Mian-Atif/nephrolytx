<?php

namespace App\Models\CptCodeInsurancePrices;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\CptCodeInsurancePrices\Traits\CptCodeInsurancePriceAttribute;
use App\Models\CptCodeInsurancePrices\Traits\CptCodeInsurancePriceRelationship;

class CptCodeInsurancePrice extends Model
{
    use ModelTrait,
        CptCodeInsurancePriceAttribute,
    	CptCodeInsurancePriceRelationship {
            // CptCodeInsurancePriceAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'cptcode_insurance_prices';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
//        'insurance_name','cptcode','par_amount','practice_id','state'
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

    public function practice()
    {
        return $this->belongsTo('App\Models\Practice\Practice','practice_id');
    }
    public function cptCodeInsurance()
    {
        return $this->belongsTo('App\Models\CptCodeInsurancePrices\CptCodeInsurancePrice', 'practice_id');
    }
}

<?php

namespace App\Models\CptCode;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\CptCode\Traits\CptCodeAttribute;
use App\Models\CptCode\Traits\CptCodeRelationship;

class CptCode extends Model
{
    use ModelTrait,
        CptCodeAttribute,
    	CptCodeRelationship {
            // CptCodeAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'cptcode_prices';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
        'cpt_code','par_amount','practice_id','state'
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

    public function cptCodePrice()
    {
        return $this->belongsTo('App\Models\CptCode\CptCode', 'practice_id');
    }
}

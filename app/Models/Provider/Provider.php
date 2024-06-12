<?php

namespace App\Models\Provider;

use App\Models\ModelTrait;
use App\PracticeProviderDetail;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provider\Traits\ProviderAttribute;
use App\Models\Provider\Traits\ProviderRelationship;

class Provider extends Model
{
    use ModelTrait,
        ProviderAttribute,
    	ProviderRelationship {
            // ProviderAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'providers';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
    'title','first_name','last_name','mi','suffix','email','taxonomy_code','provider_type','user_id','detail_id'
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


    public function detail()
    {
        return $this->hasOne('App\Models\PracticeProviderDetail','id','detail_id');
    }

}

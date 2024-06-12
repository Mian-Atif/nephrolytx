<?php

namespace App\Models\Practice;

use App\Models\Access\User\User;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Practice\Traits\PracticeAttribute;
use App\Models\Practice\Traits\PracticeRelationship;

class Practice extends Model
{
    use ModelTrait,
        PracticeAttribute,
    	PracticeRelationship {
            // PracticeAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'practices';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
            'name','type','email','owner','speciality_id','user_id','detail_id','tax_id'
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

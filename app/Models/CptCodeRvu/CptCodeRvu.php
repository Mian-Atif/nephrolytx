<?php

namespace App\Models\CptCodeRvu;

use Illuminate\Database\Eloquent\Model;

class CptCodeRvu extends Model
{
    protected $table = 'cptcodeandrvu';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [
        'cptcode','description','workRVU','practiceRVU','malpracticeRVU','totalRVU'
    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [

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
    //
}

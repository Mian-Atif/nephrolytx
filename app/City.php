<?php

namespace App;

use App\Models\Practice\Practice;
use App\Models\PracticeProviderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id','state_id', 'name', 'status'
    ];
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function PracticeProviderDetail()
    {
        return $this->belongsTo(PracticeProviderDetail::class);
    }

}

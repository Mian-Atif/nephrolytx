<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Attribute\UserAttribute;
use App\Models\Access\User\Traits\Relationship\UserRelationship;
use App\Models\Access\User\Traits\Scope\UserScope;
use App\Models\Access\User\Traits\UserAccess;
use App\Models\Access\User\Traits\UserSendPasswordReset;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Http\Controllers\nepanalysis\AnalysisController;
use DateTime;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use UserScope,
        UserAccess,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserRelationship,
        UserSendPasswordReset,
        HasApiTokens;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'status',
        'confirmation_code',
        'confirmed',
        'password',
        'two_factor_code',
        'two_factor_expires_at',
        'created_by',
        'updated_by',
        'person_id',
        'practice_id',
        'password_changed_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'two_factor_expires_at'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.users_table');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'email'       => $this->email,
            'picture'     => $this->getPicture(),
            'confirmed'   => $this->confirmed,
            'role'        => optional($this->roles()->first())->name,
            'permissions' => $this->permissions()->get(),
            'status'      => $this->status,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
        ];
    }

    public function person()
    {
        return $this->hasOne('App\Models\Person\Person', 'id', 'person_id');
    }
    public function practice()
    {
        return $this->hasOne('App\Models\Practice\Practice', 'id', 'practice_id');
    }
    
    public function practiceEndDate()
    {
        
        $analysisController = new AnalysisController();
        return $analysisController->maxDateForNiveBar();
    }
    
    public function practiceEndDateYear()
    {
        
        
        $currentYear = self::practiceEndDate(); // assuming $currentYear is in the format of "Y-m-d", like "2023-03-21"


        $date = DateTime::createFromFormat("m-d-Y", $currentYear); // create a DateTime object from the date string
        //$date->modify("-1 year"); // subtract one year from the date object
        $YearDate = $date->format("Y"); // format the date as a string in the original format
        
        return $YearDate; // outputs "01-31-2022"
    }

    public function practiceP1EndDate()
    {
        
        $currentYear = self::practiceEndDate(); // assuming $currentYear is in the format of "Y-m-d", like "2023-03-21"


        $date = DateTime::createFromFormat("m-d-Y", $currentYear); // create a DateTime object from the date string
        $date->modify("-1 year"); // subtract one year from the date object
        $prevYearDate = $date->format("Y"); // format the date as a string in the original format
        
        return $prevYearDate; // outputs "01-31-2022"
    }

    public function practiceP2EndDate()
    {
        
        $currentYear = self::practiceEndDate(); // assuming $currentYear is in the format of "Y-m-d", like "2023-03-21"


        $date = DateTime::createFromFormat("m-d-Y", $currentYear); // create a DateTime object from the date string
        $date->modify("-2 year"); // subtract one year from the date object
        $prevYearDate = $date->format("Y"); // format the date as a string in the original format
        
        return $prevYearDate; // outputs "01-31-2022"

    }
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }
    //    public function passWordHistories()
    //    {
    //        return $this->hasMany('App\Models\User\PasswordHistory','id');
    //    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
    /**
     * @param string $value
     * added by shafiq on 6 Nov 2020
     * To disale remembber me functionality
     */
    public function setRememberToken($value)
    {
        $this->remember_token = null;
    }
}

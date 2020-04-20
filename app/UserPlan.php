<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_plans';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'plan_id', 'payment_status', 'payment_params', 'plan_expiry_date', 'created_by'];

    public function users()
    {
        return $this->hasOne('App\Users');
    }
    
}

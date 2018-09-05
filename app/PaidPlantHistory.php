<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PaidPlantHistory extends Model {

    public static function boot() {
        static::creating(function ($model) {
//            echo '<pre>';print_r($model->fillable);die;
            if (in_array('created_by', $model->fillable)):
                $model->created_by = (!empty(Auth::id())) ? Auth::id() : '2';
            endif;

            //$model->created_at = \Carbon\Carbon::now();
            // $model->updated_at = \Carbon\Carbon::now();
        });
        static::updating(function ($model) {

            if (in_array('created_by', $model->fillable)):
                $model->created_by = (!empty(Auth::id())) ? Auth::id() : '2';
            endif;
        });
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paid_plan_history';

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
    protected $fillable = ['plan_id', 'previous_expiry_date', 'user_id', 'price_paid', 'project_admin_id', 'expriy_date', 'current_payment_status', 'payment_params', 'created_by'];

    public function plan() {
        return $this->hasOne(\App\Plan::class, 'id', 'plan_id');
    }

}

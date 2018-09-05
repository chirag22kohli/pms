<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class PaidProjectDetail extends Model {

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
    protected $table = 'paid_project_details';

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
    protected $fillable = ['project_id', 'user_id', 'project_admin_id', 'expriy_date', 'current_payment_status', 'payment_params', 'reoccuring_trigger', 'created_by'];

}

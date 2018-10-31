<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class PaidProjectHistoryDetail extends Model {

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
    protected $table = 'paid_project_history_details';

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
    protected $fillable = ['project_id','paid_price', 'user_id', 'project_admin_id', 'expriy_date', 'current_payment_status', 'payment_params', 'reoccuring_trigger', 'created_by'];

     public function userDetail() {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
    public function projectDetail() {
        return $this->hasOne(\App\Project::class, 'id', 'project_id');
    }
    
    public function ownTransaction(){
        return $this->hasMany(\App\PaidProjectHistoryDetail::class, 'project_admin_id', 'project_admin_id');
    }
     public function transactionAdmin(){
        return $this->hasOne(\App\User::class, 'id', 'project_admin_id');
    }
}

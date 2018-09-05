<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Action extends Model {

    public static function boot() {
        static::creating(function ($model) {
//            echo '<pre>';print_r($model->fillable);die;
            if (in_array('created_by', $model->fillable)):
                $model->created_by = (!empty(Auth::id())) ? Auth::id() : '1';
            endif;

            //$model->created_at = \Carbon\Carbon::now();
            // $model->updated_at = \Carbon\Carbon::now();
        });
        static::updating(function ($model) {
            
            if (in_array('created_by', $model->fillable)):
                $model->created_by = (!empty(Auth::id())) ? Auth::id() : '1';
            endif;
        });
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'actions';

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
    protected $fillable = ['url', 'image', 'parm', 'object_id', 'message', 'trigger','size', 'created_by'];

}

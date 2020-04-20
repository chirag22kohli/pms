<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model {

    public static function boot() {
        parent::boot();
        
        
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
    protected $table = 'trackers';

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
    protected $fillable = ['tracker_name', 'updated_vuforia','target_id','height', 'width', 'project_id', 'parm', 'created_by'];

    public function comments() {
        return $this->hasMany('App\Project');
    }

    public function objects() {
        return $this->hasMany(\App\object::class, 'tracker_id', 'id')->with('actions');
    }

}

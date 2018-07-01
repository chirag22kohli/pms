<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
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
    protected $fillable = ['tracker_name', 'height', 'width', 'project_id', 'parm'];

    public function comments()
    {
        return $this->hasMany('App\Project');
    }
    public function objects(){
        return $this->hasMany(\App\object::class, 'tracker_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecentProject extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recent_projects';

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
    protected $fillable = ['user_id','project_id'];

     public function project() {
        return $this->hasOne(\App\Project::class, 'id', 'project_id');
    }
    
}

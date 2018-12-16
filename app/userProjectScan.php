<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userProjectScan extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_project_scans';

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
    protected $fillable = ['project_id', 'user_id', 'project_owner_id', 'count'];

    public function project_owner() {
        return $this->hasOne(\App\User::class, 'id', 'project_owner_id');
    }

    public function project_user() {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
    
    public function project_detail() {
        return $this->hasOne(\App\Project::class, 'id', 'project_id');
    }

}

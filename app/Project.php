<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

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
    protected $fillable = ['name', 'tracker_path', 'project_type', 'price', 'billing_cycle', 'created_by'];

    public function project_owner() {
        return $this->hasOne(\App\User::class, 'id', 'created_by');
    }

}

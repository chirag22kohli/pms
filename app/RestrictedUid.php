<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestrictedUid extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restricted_uids';

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
    protected $fillable = ['project_id', 'uid'];

    public function users()
    {
        return $this->hasMany('App\Project');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserUid extends Model
{
 
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_uid';

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
    protected $fillable = ['user_id','uid', 'uid_id','created_at','updated_at','project_id'];

    
}

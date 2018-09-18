<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'supports';

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
    protected $fillable = ['email', 'reason', 'description'];

    
}

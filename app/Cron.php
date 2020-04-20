<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cron extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'crons';

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
    protected $fillable = ['type', 'date_logged', 'message', 'success', 'params', 'user_id', 'plan_id', 'project_id'];

    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class object extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'objects';

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
    protected $fillable = ['xpos', 'ypos', 'height', 'width', 'project_id', 'type', 'object_div', 'user_id' , 'main_class'];

    
}

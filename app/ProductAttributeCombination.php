<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeCombination extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_attribute_combinations';

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
    protected $fillable = ['product_id', 'value', 'stock', 'user_id'];

    
}

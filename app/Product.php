<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
    protected $fillable = ['sku', 'name', 'price', 'stock', 'image', 'status', 'user_id', 'category_id','description'];

    public function product_options() {
        return $this->hasMany(\App\ProductOption::class, 'product_id', 'id');
    }

    public function product_attribute_combinations() {
        return $this->hasMany(\App\ProductAttributeCombination::class, 'product_id', 'id');
    }
    
    public function vendor_details(){
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

}

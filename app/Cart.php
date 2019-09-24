<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carts';

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
    protected $fillable = ['product_id', 'user_id', 'attributes', 'stock'];

    public function product_detail() {
        return $this->hasMany(\App\Product::class, 'id', 'product_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
    protected $fillable = ['amount', 'user_id', 'client_id', 'is_paid', 'params','address_id'];

     public function order_details() {
        return $this->hasMany(\App\OrderDetail::class, 'order_id', 'id')->with('product_details');
    }
     public function address() {
        return $this->hasOne(\App\UserAddress::class, 'id', 'address_id');
    }
    
    
    
}

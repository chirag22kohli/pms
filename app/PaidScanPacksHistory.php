<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidScanPacksHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paid_scan_packs_histories';

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
    protected $fillable = ['user_id', 'scan_pack_id', 'date_purchased', 'scans_credited', 'payment_params', 'payment_type', 'payment_status','price_paid','month'];

    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserScanPack extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_scan_packs';

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
    protected $fillable = ['user_id', 'scan_pack_id', 'scans', 'scans_used', 'limit_set', 'used_limit', 'total_scan_packs', 'used_scan_packs', 'user_plan_id','month'];

    
}

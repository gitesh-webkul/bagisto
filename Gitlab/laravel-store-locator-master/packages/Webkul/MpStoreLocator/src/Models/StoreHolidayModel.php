<?php

namespace Webkul\MpStoreLocator\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MpStoreLocator\Contracts\StoreHolidayModel as StoreHolidayModelContract;

class StoreHolidayModel extends Model implements StoreHolidayModelContract
{
    protected $table = 'store_holiday';

    const DATE_TYPE_SINGLE = 1;
    const DATE_TYPE_DATE_RANGE = 2;

    const ENABLED   = 'A';
    const DISABLED  = 'D';

    protected $fillable = [
        'name',
        'status',
        'date_type',
        'date_from',
        'date_to',
        'created_at',
        'updated_at'
    ];

    public static function dateType(){
        return [
                1=>'Single Date', 
                2=>'Date Range'
        ];
    }

    public static function statusType(){
        return [
                'A' =>'Enabled', 
                'D' =>'Disabled'
        ];
    }


    
}
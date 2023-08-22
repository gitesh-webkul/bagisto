<?php

namespace Webkul\MpStoreLocator\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\MpStoreLocator\Contracts\StoresModel as StoresModelContract;
use Webkul\Product\Models\Product;
use Webkul\Core\Models\Channel;
use Webkul\Core\Models\Locale;
use  Webkul\Core\Models\Country;
use App;
use DB;

class StoresModel extends Model implements StoresModelContract
{
    protected $table = 'stores';



    const ENABLED   = 'A';
    const DISABLED  = 'D';

    const URGENT_CLOSED_YES   = 'Y';
    const URGENT_CLOSED_NO  = 'N';

    const OPEN_STORES_24   = 1;
    const OPEN_STORES_SAME_TIME  = 2;
    const OPEN_STORES_DIFFERENT_TIME  = 3;

    protected $fillable = [
        'status',
        'store_name',
        'store_lat',
        'store_long',
        'description',
        'urgent_closed',
        'store_opens',
        'same_timing',
        'different_timing',
        'person_name',
        'person_email',
        'person_mobile',
        'person_fax',
        'address_country',
        'address_state',
        'address_city',
        'address_street',
        'address_postal_code',
        'created_at',
        'updated_at'
    ];


    public static function statusType()
    {
        return [
            'A' => 'Enabled',
            'D' => 'Disabled'
        ];
    }

    public function holidays()
    {
        return $this->belongsToMany(
            StoreHolidayModel::class,
            'stores_holiday',
            'stores_id',
            'store_holiday_id'
        );
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'stores_product',
            'stores_id',
            'product_id'
        );
    }

    //StoreProduct
    public function scopeStoreProduct($query, $productIdArr)
    {
        $channel =  Channel::pluck('code')->toArray();
        $locale[]  =  App::getLocale();
        $queryBuilder = DB::table('product_flat');
        $queryBuilder->leftJoin('products', 'product_flat.product_id', '=', 'products.id');
        $queryBuilder->leftJoin('attribute_families', 'products.attribute_family_id', '=', 'attribute_families.id');
        $queryBuilder->leftJoin('product_inventories', 'product_flat.product_id', '=', 'product_inventories.product_id');
        $queryBuilder->select(
            'product_flat.locale',
            'product_flat.channel',
            'product_flat.product_id',
            'products.sku as product_sku',
            'product_flat.product_number',
            'product_flat.name as product_name',
            'products.type as product_type',
            'product_flat.status',
            'product_flat.price',
            'attribute_families.name as attribute_family',
            DB::raw('SUM(' . DB::getTablePrefix() . 'product_inventories.qty) as quantity')
        );
        $queryBuilder->groupBy('product_flat.product_id', 'product_flat.locale', 'product_flat.channel');
        $queryBuilder->whereIn('products.id', $productIdArr);
        $queryBuilder->whereIn('product_flat.locale', $locale);
        $queryBuilder->whereIn('product_flat.channel', $channel);
        return $queryBuilder;
    }


    public static function countriesCollection()
    {
        $countryArr = [];
        $countriesCollection = DB::table('countries')->get();
        
        foreach($countriesCollection as $country){
            $countryArr[] = [
                'title' => $country->name,
                'value' => $country->code,
            ];
        } 
        return $countryArr;
    }


    public static function getProductStoresLocators($productId){
        $storeProduct = DB::table('stores_product')
                            ->join('stores', 'stores_product.stores_id','=','stores.id')
                            ->select('stores.*')
                            ->where('product_id',$productId)->get();
        return $storeProduct;
    }

    public static function getStoresmodel(){
        return StoresModel::all();
    }

}

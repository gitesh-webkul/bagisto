<?php

namespace Webkul\MpStoreLocator\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\MpStoreLocator\Models\StoreHolidayModel;
use Webkul\MpStoreLocator\Models\OrderStorePickupModel;
use DB;

class MpStoreLocatorController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }


    public function storesList(){
        $km = !empty(core()->getConfigData('sales.carriers.pickup_store.within_range')) ? core()->getConfigData('sales.carriers.pickup_store.within_range') : 25;
        
        $latitude  = request()->current_user_lat;
        $longitude = request()->current_user_long;
        // echo "<pre>";
        // print_r(request()->all());exit;
        // echo $latitude." ".$longitude;exit;
        $todayDate = \Carbon\Carbon::today()->format('Y-m-d');

        $closedStoresArr = StoreHolidayModel::where(function($query) use($todayDate){
                                        $query->where([['date_type','=',StoreHolidayModel::DATE_TYPE_SINGLE],['status','=',StoreHolidayModel::ENABLED]]);
                                        $query->whereDate('date_from','=',$todayDate);      
                                    })->orWhere(function($query) use($todayDate){
                                        $query->where([['date_type','=',StoreHolidayModel::DATE_TYPE_DATE_RANGE],['status','=',StoreHolidayModel::ENABLED]]);
                                        $query->whereDate('date_from','<=',$todayDate);
                                        $query->whereDate('date_to','>=',$todayDate);
                                    })
                                    ->join('stores_holiday','store_holiday.id','=','stores_holiday.store_holiday_id')
                                    //->select('stores_holiday.stores_id','stores_holiday.store_holiday_id')
                                    ->pluck('stores_holiday.stores_id')->unique()->toArray();
        if(!empty($latitude) && !empty($longitude)){
            //$stores = \Webkul\MpStoreLocator\Models\StoresModel::all();
                $circle_radius = 3959;
                $stores = \Webkul\MpStoreLocator\Models\StoresModel::select(DB::raw('status,store_name,store_lat,store_long,description,urgent_closed,store_opens,same_timing,address_country,address_state,address_city,address_street,address_postal_code, ( 6367 * acos( cos( radians(' . $latitude . ') ) * cos( radians( store_lat ) ) * cos( radians( store_long ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( store_lat ) ) ) ) AS distance'))
                ->whereNotIn('id',$closedStoresArr)
                ->having('distance', '<', $km)
                ->get();
                if($stores->count() > 0){
                   return ['status'=>200 , 'stores'=>$stores];
                }else{
                    return ['status'=>100];
                }
        }else{
            return ['status'=>100];
        }
    }


    public function saveOrderStorePicker($order){
       
        if($order->shipping_method == "pickup_store_pickup_store"){
            $orderStatus  = DB::table('order_store_pickup')->insert(['order_id'=>$order->id,
                                                            'stores_id'=>(int)request()->store_pickup]);
        } 
    }
}

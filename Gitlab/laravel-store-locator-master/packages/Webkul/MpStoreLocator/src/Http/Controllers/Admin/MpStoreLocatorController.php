<?php

namespace Webkul\MpStoreLocator\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\MpStoreLocator\Models\StoreHolidayModel;
use  Webkul\MpStoreLocator\Models\StoresModel;
use Webkul\Core\Models\CountryState;
use Illuminate\Support\Str;
use DB;

class MpStoreLocatorController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
        $this->middleware('admin');

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $holidays = StoreHolidayModel::all();

        return view($this->_config['view'], compact('holidays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $this->validate(request(), [
            'store_name'      => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            //'person_name' => 'required',
            //'email' => 'required',
            //'mobile' => 'required',
        ]);

        $sameTiming = $differentTiming = NULL;
        if (!empty(request()->store_opens)) {
            if (request()->store_opens == StoresModel::OPEN_STORES_SAME_TIME) {
                $sameTiming = json_encode(request()->timing);
            } elseif (request()->store_opens == StoresModel::OPEN_STORES_DIFFERENT_TIME) {
                $differentTiming = json_encode(request()->timing);
            }
        }

        $saveResponse = StoresModel::create([
            'status' => request()->status,
            'store_name' => request()->store_name,
            'store_lat' => request()->latitude,
            'store_long' => request()->longitude,
            'description' => request()->description,
            'urgent_closed' => request()->urgent_closed,
            'store_opens' => request()->store_opens,
            'same_timing' => $sameTiming,
            'different_timing' => $differentTiming,
            'person_name' => request()->person_name,
            'person_email' => request()->email,
            'person_mobile' => request()->mobile,
            'person_fax' => request()->fax,
            'address_country' => request()->country,
            'address_state' => request()->state_province,
            'address_city' => request()->city,
            'address_street' => request()->street,
            'address_postal_code' => request()->postal_code
        ]);
        if ($saveResponse) {
            /*save holidays*/
            $saveResponse->holidays()->sync(request()->stores_holidays);
            session()->flash('success', trans('mpstorelocator::app.admin.msg.stores_has_been_created_successfully'));
            return redirect()->route($this->_config['redirect']);
        } else {
            session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $holidays = StoreHolidayModel::all();
        $stores =  StoresModel::with(['holidays','products'])->find($id);
        /*Find Product of stores */
        $productIdArr = [];
        if($stores->products->count() > 0){
            $productIdArr =  $stores->products->pluck('id')->all();
        }
        $storeProducts = StoresModel::StoreProduct($productIdArr)->get();
        $holidaysList = [];
        if ($stores->holidays->count() > 0) {
            $holidaysList = $stores->holidays->pluck('id')->all();
        }
        return view($this->_config['view'], compact('holidays', 'stores', 'holidaysList','storeProducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $sameTiming = $differentTiming = NULL;
        if (!empty(request()->store_opens)) {
            if (request()->store_opens == StoresModel::OPEN_STORES_SAME_TIME) {
                $sameTiming = json_encode(request()->timing);
            } elseif (request()->store_opens == StoresModel::OPEN_STORES_DIFFERENT_TIME) {
                $differentTiming = json_encode(request()->timing);
            }
        }
        $storesResponse = StoresModel::find($id);
        if ($storesResponse) {
            $saveResponse = $storesResponse->update([
                'status' => request()->status,
                'store_name' => request()->store_name,
                'store_lat' => request()->latitude,
                'store_long' => request()->longitude,
                'description' => request()->description,
                'urgent_closed' => request()->urgent_closed,
                'store_opens' => request()->store_opens,
                'same_timing' => $sameTiming,
                'different_timing' => $differentTiming,
                'person_name' => request()->person_name,
                'person_email' => request()->email,
                'person_mobile' => request()->mobile,
                'person_fax' => request()->fax,
                'address_country' => request()->country,
                'address_state' => request()->state_province,
                'address_city' => request()->city,
                'address_street' => request()->street,
                'address_postal_code' => request()->postal_code
            ]);
            if ($saveResponse) {
                /*save holidays*/
                $storesResponse->holidays()->sync(request()->stores_holidays);

                session()->flash('success', trans('mpstorelocator::app.admin.msg.stores_has_been_updated_successfully'));
                return redirect()->route($this->_config['redirect']);
            } else {
                session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleteResponse = StoresModel::where('id', $id)->delete();

            session()->flash('success', trans('mpstorelocator::app.admin.msg.delete_stores_successfully'));
        } catch (\Exception $e) {
            session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
        }
        return redirect()->back();
    }


    public function massDelete()
    {
        try {
            $storesIds = Str::of(request()->indexes)->explode(',')->all();
            if (count($storesIds) > 0) {
                $removeAttributes = StoresModel::whereIn('id', $storesIds)->delete();
                if ($removeAttributes) {
                    session()->flash('success', trans('mpstorelocator::app.admin.msg.delete_stores_successfully'));
                } else {
                    session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
                }
            } else {
                session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
            }
        } catch (\Exception $e) {
            session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
        }
        return redirect()->back();
    }


    public function assignProduct($id)
    {
        $storesDetail = StoresModel::find($id);
        return view($this->_config['view'], compact('storesDetail'));
    }

    public function assignProducts()
    {
        if (!empty(request()->products) && (count(request()->products) > 0)) {
            $storesDetail = StoresModel::find(request()->stores_id);
            if ($storesDetail != NULL) {
                $productIdArr = collect(request()->products)->pluck('productId')->all();
                $saveResponse = $storesDetail->products()->sync($productIdArr);
                if($saveResponse){
                    return [
                        'status' => 200,
                        'msg' => trans('mpstorelocator::app.admin.msg.product_assign_successfully')
                    ];
                }else{
                    return [
                        'status' => 100,
                        'msg' => trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')
                    ];
                }
            } else {
                return [
                    'status' => 100,
                    'msg' => trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')
                ];
            }
        } else {
            return [
                'status' => 100,
                'msg' => trans('mpstorelocator::app.admin.msg.please_select_at_least_one_product')
            ];
        }
    }


    public function removeProducts(){
        if(!empty(request('params.query'))){
            $requestParam = request('params.query'); 
            $productId = request('params.query.product_id');
            
            $storesDetail = StoresModel::find(request('params.query.storeid'));
          
            if($storesDetail != NULL){
                $saveResponse = $storesDetail->products()->detach($productId);
                if($saveResponse){
                    $productIdArr = [];
                    $storesDetail = StoresModel::with(['products'])->find(request('params.query.storeid'));
                    if($storesDetail->products->count() > 0){
                        $productIdArr =  $storesDetail->products->pluck('id')->all();
                    }
                    $storeProducts = StoresModel::StoreProduct($productIdArr)->get();
                    return [
                        'status' => 200,
                        'msg' => trans('mpstorelocator::app.admin.msg.record_remove'),
                        'response' => $storeProducts,
                    ];
                }
            }else{
                return [
                    'status' => 100,
                    'msg' => trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')
                ];
            }
        }else{
            return [
                'status' => 100,
                'msg' => trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')
            ];
        }
    }

    public function removeStoresFromProduct(){
        if(!empty(request('params.query'))){
            $requestParam = request('params.query'); 
            $productId = request('params.query.product_id');
            $storesDetail = StoresModel::find(request('params.query.storeid'));
            if($storesDetail != NULL){
                $saveResponse = $storesDetail->products()->detach($productId);
                if($saveResponse){
                    $productIdArr = [];
                    $storeLocators = StoresModel::getProductStoresLocators($productId);
                    return [
                        'status' => 200,
                        'msg' => trans('mpstorelocator::app.admin.msg.record_remove'),
                        'response' => $storeLocators,
                    ];
                }
            }else{
                return [
                    'status' => 100,
                    'msg' => trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')
                ];
            }
        }else{
            return [
                'status' => 100,
                'msg' => trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again')
            ];
        }
    }


    public function assignStores($productId){
        if(request()->method() == "POST"){
            $storeIdArr = explode(',',request()->indexes);
            if(count($storeIdArr) > 0){
                foreach($storeIdArr as $storeID){
                    DB::table('stores_product')->insert([
                                                        'stores_id'=>$storeID,
                                                        'product_id'=>$productId
                                                    ]);
            
                }
                session()->flash('success', trans('mpstorelocator::app.admin.msg.store_assign_successfully'));
                return redirect("admin/catalog/products/edit/$productId");
                
            }
        }
        return view($this->_config['view']);
    }



    public function getState()
    {
        if (!empty(request('query'))) {
            $country = request('query');
            $states = CountryState::where('country_code', $country)->get();
            if ($states->count() > 0) {
                return ['status' => 200, 'states_provience' => $states];
            } else {
                return ['status' => 100];
            }
        } else {
            return ['status' => 100];
        }
    }
}

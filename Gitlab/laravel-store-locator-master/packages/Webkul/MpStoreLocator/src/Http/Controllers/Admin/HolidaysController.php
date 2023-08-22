<?php

namespace Webkul\MpStoreLocator\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\MpStoreLocator\Models\StoreHolidayModel;
use Illuminate\Support\Str;

class HolidaysController extends Controller
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
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'status'      => 'required',
            'holiday_name' => 'required|string',
            'date_type' => 'required',
            'holiday_date' => 'required|date|after_or_equal:today',
        ]);

        if (request()->date_type == StoreHolidayModel::DATE_TYPE_SINGLE) {
            $formData = [
                'name' => request()->holiday_name,
                'status' => request()->status,
                'date_type' => request()->date_type,
                'date_from' => request()->holiday_date ?? NULL,

            ];
        } else {
            $formData = [
                'name' => request()->holiday_name,
                'status' => request()->status,
                'date_type' => request()->date_type,
                'date_from' => request()->holiday_date_from ?? NULL,
                'date_to'  => request()->holiday_date_to ?? NULL,
            ];
        }
        $response = StoreHolidayModel::create($formData);
        if ($response) {
            session()->flash('success', trans('mpstorelocator::app.admin.msg.holiday_has_been_created_successfully'));
        } else {
            session()->flash('success', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
        }
        return redirect()->route('admin.mpstorelocator.manage-holidays');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $holiday = StoreHolidayModel::find($id);
            return view($this->_config['view'] , compact('holiday'));

        } catch (\Exception $e) {
            session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'status'      => 'required',
            'holiday_name' => 'required|string',
            'date_type' => 'required',
        ]);

        if (request()->date_type == StoreHolidayModel::DATE_TYPE_SINGLE) {
            $formData = [
                'name' => request()->holiday_name,
                'status' => request()->status,
                'date_type' => request()->date_type,
                'date_from' => request()->holiday_date ?? NULL,

            ];
        } else {
            $formData = [
                'name' => request()->holiday_name,
                'status' => request()->status,
                'date_type' => request()->date_type,
                'date_from' => request()->holiday_date_from ?? NULL,
                'date_to'  => request()->holiday_date_to ?? NULL,
            ];
        }

        try{
            $holidayData = StoreHolidayModel::find($id);
            if($holidayData != NULL){
                $response = $holidayData->update($formData);
                if ($response) {
                    session()->flash('success', trans('mpstorelocator::app.admin.msg.holiday_has_been_updated_successfully'));
                } else {
                    session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
                }
                return redirect()->route('admin.mpstorelocator.manage-holidays');

            }else{
                session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
            }

        }catch(\Exception $e){
            session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
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
            $deleteResponse = StoreHolidayModel::where('id',$id)->delete();
            //$attributeResponse->delete();
            session()->flash('success', trans('mpstorelocator::app.admin.msg.delete_holidays_successfully'));
        } catch (\Exception $e) {
            session()->flash('error', trans('mpstorelocator::app.admin.msg.something_went_wrong_please_try_again'));
        }
    }


    public function massDelete()
    {
        try {
            $attributeIds = Str::of(request()->indexes)->explode(',')->all();
            if (count($attributeIds) > 0) {
                $removeAttributes = $this->attribute->whereIn('id', $attributeIds)->delete();
                if ($removeAttributes) {
                    session()->flash('success', trans('PurchaseOrder::app.admin.attribute.msg.delete_attribute_successfully'));
                } else {
                    session()->flash('error', trans('PurchaseOrder::app.admin.action.some_thing_went_wrong'));
                }
            } else {
                session()->flash('error', trans('PurchaseOrder::app.admin.action.some_thing_went_wrong'));
            }
        } catch (\Exception $e) {
            session()->flash('error', trans('PurchaseOrder::app.admin.action.some_thing_went_wrong'));
        }
        return redirect()->back();
    }

    public function massChangeStatus(){

        $holidaysIds = explode(',', request()->input('indexes'));
        
        if (count($holidaysIds) > 0) {

            $status = (request('update-options') == StoreHolidayModel::ENABLED) ? StoreHolidayModel::ENABLED : StoreHolidayModel::DISABLED;
            $response = StoreHolidayModel::whereIn('id',$holidaysIds)->update(['status'=> $status]);
        }
        session()->flash('success', trans('mpstorelocator::app.admin.msg.holiday_status_change', ['name' => 'Attribute']));

        return redirect()->back();

    }

    /* public static function storePicukpMethod()
    {
        $configStatus =  core()->getConfigData('sales.carriers.pickup_store.package_status') ?? 0;
        //$configStatus = 0;
        if($configStatus == 1){
            return [
                'code'             => 'stores_pickup',
                'title'            => 'Stores Pickup',
                'description'      => 'Stores Pickup Shipping',
                'active'           => false,
                'is_calculate_tax' => true,
                'default_rate'     => '10',
                'type'             => null,
                'class'            => 'Webkul\Shipping\Carriers\PickupStores',
            ];
        }else{
            return [];
        }
    } */
}

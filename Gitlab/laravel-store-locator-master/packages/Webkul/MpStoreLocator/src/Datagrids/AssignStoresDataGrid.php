<?php

namespace Webkul\MpStoreLocator\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\MpStoreLocator\Models\StoresModel;

class AssignStoresDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    protected $product_id  = NULL;

    public function prepareQueryBuilder()
    {
        $productID = $this->product_id = request()->segment(5);
        
        $assignedStores = DB::table('stores_product')->where('product_id',$productID)->pluck('stores_id')->toArray();
     
        $queryBuilder = DB::table('stores')->whereNotIn('id',$assignedStores);
        
        $this->setQueryBuilder($queryBuilder);
    }

    
    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => 'Id',
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index'      => 'store_name',
            'label'      => trans('mpstorelocator::app.admin.store_name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('mpstorelocator::app.admin.status'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => false,
            'closure'    => function ($row) {
                $statusTypeArr =  StoresModel::statusType();
                return $statusTypeArr[$row->status];
            },
        ]);
        $this->addColumn([
            'index'      => 'store_lat',
            'label'      => trans('mpstorelocator::app.admin.latitude'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index'      => 'store_long',
            'label'      => trans('mpstorelocator::app.admin.longitude'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index'      => 'person_name',
            'label'      => trans('mpstorelocator::app.admin.person_name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                return (!empty($row->person_name)) ? $row->person_name : 'N/A';
            },
        ]);
        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('mpstorelocator::app.admin.created_at'),
            'type'       => 'date',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                return $row->created_at;
            },
            
        ]);
    }

    public function prepareActions()
    {
        $productID  = request()->segment(5);
        $this->addMassAction([
            'type'   => 'update',
            'label'  => trans('mpstorelocator::app.admin.assign_stores'),
            'action' => route('admin.mpstorelocator.stores.assign-stores', [$productID]),
            'method' => 'POST',
            'options' => [
                'Assign'=>'A',
            ],
        ]);
    }
}
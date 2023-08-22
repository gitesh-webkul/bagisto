<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\MpStoreLocator\Models\StoresModel;

class StoresDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('stores');
     
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
        $this->addAction([
            'title'  => trans('mpstorelocator::app.admin.edit'),
            'method' => 'GET',
            'route'  => 'admin.mpstorelocator.stores.edit',
            'icon'   => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title'        => trans('mpstorelocator::app.admin.delete'),
            'method'       => 'POST',
            'route'        => 'admin.mpstorelocator.stores.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'template']),
            'icon'         => 'icon trash-icon',
        ]);
    }
    

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('mpstorelocator::app.admin.delete'),
            'action' => route('admin.mpstorelocator.stores.massdelete', request('id')),
            'method' => 'POST',
        ]);
       
        $this->addMassAction([
            'type'   => 'update',
            'label'  => trans('mpstorelocator::app.admin.change_status'),
            'action' => route('admin.mpstorelocator.stores.mass-status-update', request('id')),
            'method' => 'POST',
            'options' => [
                'Enabled'=>'A',
                'Disabled'=>'D',
            ],
        ]);
    }



}
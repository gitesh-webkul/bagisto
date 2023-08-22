<?php
namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\MpStoreLocator\Models\StoreHolidayModel;

class StoreHolidaysDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('store_holiday')->addSelect('*');

        $this->addFilter('id','id');
        $this->addFilter('name','name');
        $this->addFilter('code', 'code');
        $this->addFilter('attribute_type', 'attribute_type');
        $this->addFilter('is_show_mail','is_show_mail');
        $this->addFilter('status','status');

    
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
            'index'      => 'status',
            'label'      => trans('mpstorelocator::app.admin.status'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                $statusTypeArr =  StoreHolidayModel::statusType();
                return $statusTypeArr[$row->status];
            },
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('mpstorelocator::app.admin.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index'      => 'date_type',
            'label'      => trans('mpstorelocator::app.admin.date_type'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                $dateTypeArr =  StoreHolidayModel::dateType();
                return $dateTypeArr[$row->date_type];
            },

        ]);

        $this->addColumn([
            'index'      => 'date_from',
            'label'      => trans('mpstorelocator::app.admin.holiday_date'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
              
                if($row->date_type == StoreHolidayModel::DATE_TYPE_SINGLE){
                    return $row->date_from;
                }else{
                    return $row->date_from."-".$row->date_to;
                }
            },
        ]);


        

    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('mpstorelocator::app.admin.edit'),
            'method' => 'GET',
            'route'  => 'admin.mpstorelocator.manage-holidays.edit',
            'icon'   => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title'        => trans('mpstorelocator::app.admin.delete'),
            'method'       => 'POST',
            'route'        => 'admin.mpstorelocator.manage-holidays.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'template']),
            'icon'         => 'icon trash-icon',
        ]);


    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('mpstorelocator::app.admin.delete'),
            'action' => route('admin.mpstorelocator.manage-holidays.massdelete', request('id')),
            'method' => 'POST',
        ]);
       
        $this->addMassAction([
            'type'   => 'update',
            'label'  => trans('mpstorelocator::app.admin.change_status'),
            'action' => route('admin.mpstorelocator.manage-holidays.mass-status-update', request('id')),
            'method' => 'POST',
            'options' => [
                'Enabled'=>'A',
                'Disabled'=>'D',
            ],
        ]);

    }


    
}
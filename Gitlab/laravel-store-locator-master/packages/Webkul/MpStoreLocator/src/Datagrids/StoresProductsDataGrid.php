<?php

namespace Webkul\MpStoreLocator\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\Core\Models\Channel;
use Webkul\Core\Models\Locale;
use App;

class StoresProductsDataGrid extends DataGrid
{
    protected $index = 'product_flat.product_id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $channel =  Channel::pluck('code')->toArray();
        $locale[]  =  App::getLocale();
        //queryBuilder = DB::table('table')->addSelect('id');

        //$this->setQueryBuilder($queryBuilder);
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
        $queryBuilder->whereIn('product_flat.locale', $locale);
        $queryBuilder->whereIn('product_flat.channel', $channel);

        $this->addFilter('product_id','product_flat.product_id');
        $this->addFilter('product_number','product_flat.product_number');
        $this->addFilter('product_name','product_flat.name');
        $this->addFilter('product_sku','products.sku');
        $this->addFilter('price','product_flat.price');
        $products = $queryBuilder->get();
       
        $this->setQueryBuilder($queryBuilder);
        
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'p_id',
            'label'      => trans('mpstorelocator::app.admin.select_product'),
            'type'       => 'integer',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'    => function ($row) {
                return '<input type="checkbox" class="productCheckBox" name="products[]" value="' . $row->product_id . '">';
            }
        ]);
        $this->addColumn([
            'index'      => 'product_id',
            'label'      => trans('mpstorelocator::app.admin.product_id'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_number',
            'label'      => trans('mpstorelocator::app.admin.product_number'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('mpstorelocator::app.admin.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'product_sku',
            'label'      => trans('mpstorelocator::app.admin.sku'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'price',
            'label'      => trans('mpstorelocator::app.admin.cost_price'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure'    => function ($row) {
                return '<input type="hidden" class="cost_price" name="costPriceArr[]"  value="' . $row->price . '">' . $row->price ?? '--';
            }
        ]);
    }

    public function prepareActions()
    {

    }
}
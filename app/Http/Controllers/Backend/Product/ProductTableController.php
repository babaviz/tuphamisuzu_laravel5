<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Product\ManageProductRequest;
use App\Repositories\Backend\Product\ProductRepository;
use Yajra\Datatables\Facades\Datatables;


/**
 * Class ProductTableController.
 */
class ProductTableController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $products;

    /**
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * @param ManageProductRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageProductRequest $request)
    {

        return Datatables::of($this->products->getForDataTable($request->get('status'), $request->get('trashed')))
            ->escapeColumns(['name', 'description'])
            ->addColumn('actions', function ($product) {
                return $product->action_buttons;
            })
            ->withTrashed()
            ->make(true);
    }
}

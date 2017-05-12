<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Product\ManageProductRequest;
use App\Http\Requests\Backend\Product\StoreProductRequest;
use App\Http\Requests\Backend\Product\UpdateProductRequest;
use App\Models\Product\Product;
use App\Repositories\Backend\Product\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        var_dump("test");
        return view('backend.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
//        var_dump($request);
        $this->products->create([
            'data' => $request->only('name', 'description'),
        ]);

        return redirect()->route('admin.product.index')->withFlashSuccess(trans('alerts.backend.product.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $id
     * @param  ManageProductRequest  $request
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, ManageProductRequest $request)
    {
        //
        return view('backend.product.show')
            ->withProduct($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @param  ManageProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, ManageProductRequest $request)
    {
        //
        return view('backend.product.edit')
            ->withProduct($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product $product
     * @param  UpdateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
//        var_dump($product); die();
        //
        $this->products->update($product, [
            'data' => $request->only('name', 'description'),
        ]);

        return redirect()->route('admin.product.index')->withFlashSuccess(trans('alerts.backend.products.updated'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}

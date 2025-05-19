<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct_typeRequest;
use App\Http\Requests\UpdateProduct_typeRequest;
use App\Models\Product_type;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    protected $productRepository;
    public function __construct(Product_type $product_type)
    {
        $this->productRepository = new BaseRepository($product_type);
    }




    public function index(Request $request)
    {
        #return Detail::all();
        return response()->json($this->productRepository->getAll($request));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProduct_typeRequest $request)
    {
        return Product_type::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product_type $product_type)
    {
        return $product_type;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduct_typeRequest $request, Product_type $product_type)
    {
        $product_type->update($request->all());
        return $product_type;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product_type $product_type)
    {
        $product_type->delete();
        return response()->json([
            'message' => 'Product type removed'
        ]);
    }
}

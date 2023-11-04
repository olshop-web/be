<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Product\ProductService;
use App\Models\Product;
use App\Models\Product_category;

class ProductController extends Controller
{
    public $service;
    public function __construct(){
        $this->service = new ProductService();
    }
    public function getProduct(){
        $result = $this->service->getProduct();
        return response()->json($result);
    }
    public function create(ProductRequest $request){
        $request->imageValidator();
        $result = $this->service->createProduct($request);

        return response()->json($result);
    }
    public function detail($idProduct){
        $product = Product::with('user')
        ->with('category')
        ->with('variant')
        ->find($idProduct);

        return response()->json($product);
    }
    public function update(ProductRequest $request, $idProduct){
        $result = $this->service->update($request, $idProduct);

        return response()->json($result);
    }
    public function delete($idProduct){
        $result = $this->service->delete($idProduct);

        return response()->json($result);
    }
}

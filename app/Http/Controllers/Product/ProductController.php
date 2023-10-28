<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Product_category;

class ProductController extends Controller
{
    public function getProduct(){
        $productDatas = collect([]);
        $productCategory = Product_category::get();
        $product = Product::orderBy('id', 'desc')
        ->with('category')
        ->with([
            'variant'=>function($variant){
                $variant->with('image');
            }
        ])
        ->get()
        ->sortByDesc('popular');
        $productDatas->put('all', $product->values()->all());
        foreach($productCategory as $category){
            $productUnit = Product::where('product_category_id', $category->id)
            ->with('category')
            ->with([
                'variant'=>function($variant){
                    $variant->with('image');
                }
            ])
            ->orderBy('id', 'desc')
            ->get()
            ->sortByDesc('popular');
            $productDatas->put($category->name, $productUnit->values()->all());
        }
        return response()->json($productDatas);
    }
    public function create(ProductRequest $request){
        $request->create();
    }
    public function detail($idProduct){
        $product = Product::with('user')
        ->with('category')
        ->with('variant')
        ->find($idProduct);
        return response()->json($product);
    }
    public function update(ProductRequest $request, $idProduct){
        $request->update($idProduct);
        return "Data produk berhasil diubah";
    }
    public function delete(ProductRequest $request, $idProduct){
        $request->delete($idProduct);
        return "Data produk berhasil dihapus";
    }
}

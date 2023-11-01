<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_category;
use App\Models\Product;
// use App\Http\Middleware\Authenticate;

class CategoryController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'category'=>'required'
        ]);
        $category = Product_category::create([
            'name'=>$request->category
        ]);
        // return Auth::user();
        return "Categori berhasil ditambahkan";
    }
    public function getCategory(){
        $category = Product_category::get();

        return $category;
    }
    public function edit(Request $request, $idCategory){
        $category = Product_category::find($idCategory)->update([
            'name'=>$request->category
        ]);

        return $category;
    }
    public function delete($idCategory){
        Product::where('product_category_id', $idCategory)->update([
            'status'=>'deactive'
        ]);
        Product_category::find($idCategory)->delete();
        return "Categori berhasil dihapus";
    }
}

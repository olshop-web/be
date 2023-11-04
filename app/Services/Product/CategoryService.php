<?php

namespace App\Services\Product;

use App\Models\Product_category;
use App\Models\Product;
/**
 * Class CategoryService.
 */
class CategoryService
{
	public function createCategory($request){
		$category = Product_category::create([
			'name'=>$request->name
		]);

		return "Kategori berhasil dibuat";
	}
	public function getCategory(){
		$category = Product_category::get();

		return $category;
	}
	public function edit($request, $id){
		$category = Product_category::find($id)->update([
			'name'=>$request->name
		]);

		return "Kategori berhasil diedit";
	}
	public function delete($id){
        Product::where('product_category_id', $id)->update([
            'status'=>'deactive'
        ]);
        Product_category::find($id)->delete();

		return "Kategori berhasil dihapus";
	}
}

<?php

namespace App\Services\Product;

use App\Traits\ImageTrait;
use App\Models\Product;
use App\Models\Product_variant;
use App\Models\Product_category;
use Illuminate\Support\Facades\Auth;
/**
 * Class ProductService.
 */
class ProductService
{
	use ImageTrait;
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
		
		return $productDatas;
	}
	public function createProduct($request){
		$resize = $this->resize($request->image);
		$original = $this->original($request->image);
		$product = Product::create([
			'name'=>$request->name,
			'image'=>'/'.$resize->dirname.'/'.$resize->basename,
			'image_original'=>$original['full'],
			'price'=>$request->price,
			'discon'=>$request->discon,
			'description'=>$request->description,
			'status'=>$request->status,
			'product_category_id'=>$request->category,
			'popular'=>0,
			'user_id'=>Auth::user()->id,
		]);

		return "Produk berhasil ditambahkan";
	}
	public function update($request, $id){
		if($request->image != null){
			$resize = $this->resize($request->image);
			$original = $this->original($request->image);
		}
		$product = Product::find($id);
		Product::find($id)->update([
			'name'=>$request->name,
			'image'=>$request->image != null ? '/'.$resize->dirname.'/'.$resize->basename : $product->image,
			'image_original'=>$request->image != null ? $original['full'] : $product->image_original,
			'price'=>$request->price,
			'discon'=>$request->discon,
			'description'=>$request->description,
			'status'=>$request->status,
			'product_category_id'=>$request->category,
		]);

		return "Data produk berhasil diubah";
	}
	public function delete($id){
		$variants = Product_variant::where('product_id', $id)->with('image')->get();
		foreach($variants as $variant){
			$this->delete($variant->image->image);
			$this->delete($variant->image->image_original);
			Product_variant_image::where('product_variant_id', $variant->id)->delete();
		}
		Product_variant::where('product_id', $id)->delete();
		Product::find($id)->delete();

		return "Data produk berhasil dihapus";
	}
}

<?php

namespace App\Services\Product;

use App\Traits\ImageTrait;
use App\Models\Product_variant;
use App\Models\Product_variant_image;

/**
 * Class VariantService.
 */
class VariantService
{
	use ImageTrait;
	public function saveImage($image, $variant){
		$resize = $this->resize($image);
		$original = $this->original($image);
		$product_variant = Product_variant_image::create([
			'image'=>'/'.$resize->dirname.'/'.$resize->basename,
			'image_original'=>$original['full'],
			'product_variant_id'=>$variant->id
		]);
	}
	public function createVariant($request, $id){
		// return $request->all();
		$product_variant = Product_variant::create([
			'name'=>$request->name,
			'product_id'=>$id,
		]);

		foreach($request->image as $image){
			$resize = $this->resize($image);
			$original = $this->original($image);
			Product_variant_image::create([
				'image'=>'/'.$resize->dirname.'/'.$resize->basename,
				'image_original'=>$original['full'],
				'product_variant_id'=>$product_variant->id
			]);
		}

		return "Varian berhasil disimpan";
	}
	public function deleteVariant($id){
		$variantImage = Product_variant_image::where('product_variant_id', $id)->get();
		foreach($variantImage as $image){
			$this->delete($image);
		}
		Product_variant_image::where('product_variant_id', $id)->delete();
		Product_variant::find($id)->delete();

		return "Varian berhasil dihapus";
	}
	public function updateVariant($request, $id){
		$variant = Product_variant::find($id)->update([
			'name'=>$request->name
		]);

		return "Varian berhasil diubah";
	}
}

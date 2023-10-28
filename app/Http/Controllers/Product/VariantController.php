<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product_variant_image;
use App\Models\Product_variant;
use App\Http\Requests\productVariantRequest;
use App\Traits\ImageTrait;

class VariantController extends Controller
{
    use ImageTrait;

    public function create(productVariantRequest $request, $idProduct){
        dd($request->all());
        $variant = $request->create($idProduct);
        foreach($request->image as $image){
            $request->saveImage($image, $variant);
        }

        return "Varian berhasil disimpan";
    }
    public function delete($id){
        $variantImage = Product_variant_image::where('product_variant_id', $id)->get();
        foreach($variantImage as $image){
            $this->delete($image);
        }
        Product_variant_image::where('product_variant_id', $id)->delete();
        Product_variant::find($id)->delete();
        return "Varian berhasil dihapus";
    }
    public function update(Request $request, $idVariant){
        $request->validate([
            'name'=>'required'
        ]);
        $variant = Product_variant::find($idVariant)->update([
            'name'=>$request->name
        ]);

        return "Varian berhasil dihapus";
    }
}

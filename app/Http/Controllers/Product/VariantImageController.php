<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use App\Models\Product_variant_image;

class VariantImageController extends Controller
{
    use ImageTrait;
    public function delete($idProduct, $idVariantImage){
        $image = Product_variant_image::find($idVariantImage);
        $this->delete($image);

        return "Gambar berhasil di hapus";
    }
}

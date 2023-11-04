<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product_variant_image;
use App\Models\Product_variant;
use App\Services\Product\VariantService;
use App\Http\Requests\productVariantRequest;
use App\Traits\ImageTrait;

class VariantController extends Controller
{
    use ImageTrait;
    public $service;
    public function __construct(){
        $this->service = new VariantService();
    }
    public function create(productVariantRequest $request, $idProduct){
        // return $request->all();
        $result = $this->service->createVariant($request, $idProduct);

        return response()->json($result);
    }
    public function delete($idProduct, $idVariant){
        $result = $this->service->deleteVariant($idVariant);
        
        return response()->json($result);
    }
    public function update(productVariantRequest $request, $idProduct, $idVariant){
        $result = $this->service->updateVariant($request, $idVariant);

        return response()->json($result);

    }
}

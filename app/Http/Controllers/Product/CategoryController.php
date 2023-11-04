<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_category;
use App\Models\Product;
use App\Http\Requests\CategoryRequest;
use App\Services\Product\CategoryService;
use App\Http\Resources\Product\CategoryResource;
use App\Http\Resources\AlertResource;
// use App\Http\Middleware\Authenticate;

class CategoryController extends Controller
{
    public $service;
    public function __construct(){
        $this->service = new CategoryService();
    }
    public function create(CategoryRequest $request){
        $result = $this->service->createCategory($request);

        return response()->json($result);
    }
    public function getCategory(){
        $result = $this->service->getCategory();

        return response()->json($result);
    }
    public function updateCategory(Request $request, $idCategory){
        $result = $this->service->edit($request, $idCategory);
        
        return response()->json($result);
    }
    public function delete($idCategory){
        $result = $this->service->delete($idCategory);

        return response()->json($result);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\AuthRequest;
use App\Http\Resources\User\AuthResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $service;
    public function __construct(){
        return $this->service = new UserService();
    }

    public function userProduct($idUser){
        $datas = $this->service->productUser($idUser);
        // return $datas;
        return new UserResource($datas);
    }

    public function login(AuthRequest $request){
        $datas = $this->service->login($request);

        return new AuthResource($datas);
    }

    public function create(UserRequest $request){
        $datas = $this->service->create($request);

        return new AuthResource($datas);
    }
    public function update(UserRequest $request, $id){
        $datas = $this->service->change($request, $id);

        return new AuthResource($datas);
    }
    public function logout(Request $request){
        $user = $request->user()->tokens()->where('id', $request->id)->delete();
        return new AuthResource(response()->json("Akun berhasil logout"));
    }
}

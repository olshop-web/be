<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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
        // return "asdasd";
        $datas = $this->service->productUser($idUser);
        return response()->json($datas);
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $auth = Auth::user();
            $token = $auth->createToken('auth_token')->plainTextToken;
            return response()->json($token);
        }else{
            return "login gagal";
        }
    }
    public function create(UserRequest $request){
        $request->create();

        return "Akun berhasil di buat";
    }
    public function update(UserRequest $request, $id){
        $request->update($id);

        return "Akun berhasil di buat";
    }
    public function logout(Request $request){
        $user = $request->user()->tokens()->where('id', $request->id)->delete();
        return $user;
    }

}

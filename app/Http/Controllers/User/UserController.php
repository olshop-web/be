<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userProduct($id){
        $user = User::with([
            'product'=>function($product){
                $product->orderBy('id', 'desc');
                $product->with('category');
                $product->with('variant');
            }
        ])->get();
        $datas = collect([...$user]);
        return response()->json($user);
    }
    public function login(Request $request){
        // dd(Auth::user());
       $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

       if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return Auth::user();
    }else{
        return "login gagal";

    }
        // return $request->login();
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
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
    }
}

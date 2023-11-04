<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageTrait;

/**
 * Class UserService.
 */
class UserService
{
	use ImageTrait;
	public function productUser($id){
		$user = User::with([
			'product'=>function($product){
				$product->orderBy('id', 'desc');
				$product->with('category');
				$product->with('variant');
			}
		])
		->find($id);
		return $user;
	}
	public function login($request){
		if (Auth::attempt(['email'=>$request->email,'password'=>$request->password, 'status'=>'active'])) {
			$auth = Auth::user();
			$token = $auth->createToken('auth_token')->plainTextToken;
			return response()->json($token);
		}else{
			return response()->json("Login Gagal");
		}
	}
	public function create($request){
		$resize = $this->resize($request->image);
		$imageOriginal = $this->original($request->image);
		$user = User::create([
			'name'=>$request->name,
			'email'=>$request->email,
			'status'=>$request->status,
			'telp'=>$request->telp,
			'image'=>'/'.$resize->dirname.'/'.$resize->basename,
			'image_original'=>$imageOriginal['full'],
			'password'=>Hash::make($request->password),
		]);
		return response()->json("Akun berhasil dibuat");
	}
	public function change($request, $id){
		if($request->image != null){
			$resize = $this->resize($request->image);
			$imageOriginal = $this->original($request->image);
		}
		$user = User::find($id);
		User::find($id)->update([
			'name'=>$request->name,
			'email'=>$request->email,
			'status'=>$request->status,
			'telp'=>$request->telp,
			'image'=> $request->image != null ? '/'.$resize->dirname.'/'.$resize->basename : $user->image,
			'image_original'=> $request->image != null ? $imageOriginal['full'] : $user->image_original,
			'password'=>$request->password != null ? Hash::make($request->password) : $user->password,
		]);
		return response()->json("Akun berhasil diubah");
	}
}

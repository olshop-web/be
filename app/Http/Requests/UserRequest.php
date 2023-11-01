<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
    public function login($request){
        Validator::make($this->all(),[
            'password'=>'required',
            'email'=>'required|email',
        ]);
        if(Auth::attempt(['email' => $this->email, 'password' => $this->password, 'status' => 'active'])){
            $request->session()->regenerate();
            return Auth::user();
        }else{
            return "Login gagal";
        }
    }
    public function create(){
        Validator::make($this->all(),[
            'name'=>'required',
            'email'=>'required',
            'status'=>'required',
            'telp'=>'required',
            'password'=>'required',
        ]);
        $user = User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'status'=>$this->status,
            'telp'=>$this->telp,
            'password'=>Hash::make($this->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
    }
    public function update($id){
        Validator::make($this->all(),[
            'name'=>'required',
            'email'=>'required',
            'status'=>'required',
            'telp'=>'required',
        ]);

        $user = User::find($id);
        User::find($id)->update([
            'name'=>$this->name,
            'email'=>$this->email,
            'status'=>$this->status,
            'telp'=>$this->telp,
            'password'=>$this->password != null ? Hash::make($this->password) : $user->password,
        ]);
    }

}

        return [
            'name'=>'required',
            'email'=>'required|email',
            'status'=>'required',
            'telp'=>'required',
            'password'=>'required',
        ];

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
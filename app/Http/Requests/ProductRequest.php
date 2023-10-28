<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Product_variant;
use App\Traits\ImageTrait;
// use Illuminate\Support\Facades\Validator;

class ProductRequest extends FormRequest
{
    use ImageTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return Auth::check() ? true : false;
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
            'name'=>'required',
            'price'=>'required',
            'discon'=>'required',
            'description'=>'required',
            'status'=>'required',
            'category'=>'required',
        ];
    }
    public function create(){
        $validator = Validator::make($this->all(), [
            'image'=>'required',
        ]);
        $resize = $this->resize($this->image);
        $original = $this->original($this->image);
        $product = Product::create([
            'name'=>$this->name,
            'image'=>'/'.$resize->dirname.'/'.$resize->basename,
            'image_original'=>$original['full'],
            'price'=>$this->price,
            'discon'=>$this->discon,
            'description'=>$this->description,
            'status'=>$this->status,
            'product_category_id'=>$this->category,
            'popular'=>0,
            'user_id'=>Auth::user()->id,
        ]);
    }
    public function update($id){
        if($this->image != null){
            $resize = $this->resize($this->image);
            $original = $this->original($this->image);
        }
        $product = Product::find($id);
        Product::find($id)->update([
            'name'=>$this->name,
            'image'=>$this->image != null ? '/'.$resize->dirname.'/'.$resize->basename : $product->image,
            'image_original'=>$this->image != null ? $original['full'] : $product->image_original,
            'price'=>$this->price,
            'discon'=>$this->discon,
            'description'=>$this->description,
            'status'=>$this->status,
            'product_category_id'=>$this->category,
        ]);
    }
    public function delete($id){
        $variants = Product_variant::where($id)->with('image')->get();
        foreach($variants as $variant){
            $this->delete($variant->image);
        }
        Product_variant::where($id)->delete();
        Product::find($id)->delete();
    }
}

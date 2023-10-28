<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ImageTrait;

class productVariantRequest extends FormRequest
{
    use ImageTrait;
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
            'name'=>'required'
        ];
    }
    public function add($id){
        $product_variant = Product_variant::create([
            'name'=>$this->name,
            'product_id'=>$id,
        ]);
        return $product_variant;
    }
    public function saveImage($image, $variant){
        $resize = $this->resize($image);
        $original = $this->original($image);
        $product_variant = Product_variant_image::create([
            'image'=>'/'.$resize->dirname.'/'.$resize->basename,
            'image_original'=>$original['full'],
            'product_variant_id'=>$variant->id
        ]);
    }

}

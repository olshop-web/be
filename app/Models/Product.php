<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Product extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = [
        'name',
        'image',
        'image_original',
        'price',
        'discon',
        'description',
        'status',
        'product_category_id',
        'user_id',
        'popular',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category(){
        return $this->belongsTo(Product_category::class, 'product_category_id');
    }
    public function variant(){
        return $this->hasMany(Product_variant::class, 'product_id');
    }
}

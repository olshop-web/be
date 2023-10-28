<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Product_variant_image extends Model
{
    use HasFactory, HasUlids;
    protected $fillable = [
        'image',
        'image_original',
        'product_variant_id',
    ];
}

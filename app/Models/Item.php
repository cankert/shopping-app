<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['done', 'quantity', 'product_id'];
    protected $with = ['product'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

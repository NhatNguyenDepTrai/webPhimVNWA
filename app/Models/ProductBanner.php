<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBanner extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'ord', 'id_product'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}

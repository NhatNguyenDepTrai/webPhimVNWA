<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProType extends Model
{
    use HasFactory;
    protected $fillable = ['id_type', 'id_product'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pro_types', 'id_type', 'id_product');
    }
}

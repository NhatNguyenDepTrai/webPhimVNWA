<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id_category', 'id_year', 'id_nation', 'status', 'highlight', 'rating_qnt', 'url_avatar', 'url_bg', 'date', 'full_name', 'name', 'slug', 'desc', 'meta_image', 'meta_title', 'meta_desc'];
    protected $appends = ['newEpisode'];
    public function getNewEpisodeAttribute()
    {
        $latestEpisode = DB::table('episodes')
            ->where('id_product', $this->id)
            ->latest()
            ->first();

        // Kiểm tra nếu có episode mới nhất thì trả về true
        // Nếu không, trả về false
        return $latestEpisode ? $latestEpisode->name : 'COMING SOON';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
    public function nation()
    {
        return $this->belongsTo(Nation::class, 'id_nation');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'id_year');
    }
    public function types()
    {
        return $this->belongsToMany(Type::class, 'pro_types', 'id_product', 'id_type');
    }
    public function episodes()
    {
        return $this->hasMany(Episode::class, 'id_product');
    }
    public function product_banner()
    {
        return $this->hasOne(ProductBanner::class, 'id_product');
    }
}

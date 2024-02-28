<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = ['id_product', 'name', 'slug'];
    public function servers()
    {
        return $this->hasMany(Server::class, 'id_episode');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSlug extends Model
{
    use HasFactory;
    protected $fillable = ['tb', 'id_tb', 'name', 'slug'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['url_avatar_full', 'url_avatar_icon', 'url_favicon', 'url_video', 'name', 'short_name', 'slogan', 'sub_slogan', 'website', 'phone', 'hotline', 'mail', 'support_mail', 'zalo', 'facebook', 'youtube', 'instagram', 'tiktok', 'linkedin', 'telegram', 'province', 'district', 'ward', 'address', 'url_avatar_about', 'shortAbout', 'about', 'meta_title', 'meta_image', 'meta_desc'];
}

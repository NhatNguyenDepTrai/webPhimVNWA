<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'url_avatar_full' => 'http://vnwa.vinawebapp.demo//uploads/images/Company/vnwaLogoFull.png',
            'url_avatar_icon' => 'http://vnwa.vinawebapp.demo//uploads/images/Company/vnwaLogoIcon.png',
            'url_favicon' => 'http://vnwa.vinawebapp.demo//uploads/images/Company/vnwaLogoIcon.png',
            'url_video' => 'http://vinawebapp.demo/images/vnwaLogoIcon.png',
            'meta_title' => 'Thiết Kế Website Cao Cấp - Vinawebapp.com',
            'meta_image' => 'http://vnwa.vinawebapp.demo//uploads/images/Company/vnwaLogoIcon.png',
            'meta_desc' => 'Vinawebapp.com là công ty thiết kế webiste chuyên nghiệp hàng đầu Việt Nam.',
            'time_start' => '8h',
            'time_end' => '17h30',
            'website' => 'vinawebapp.com',
            'name' => 'Công ty TNHH MTV Vinawebapp.com',
            'short_name' => 'Vinawebapp.com',
            'phone' => '0787679729',
            'hotline' => '0787679729',
            'mail' => 'vinawebapp.com@vinawebapp.com',
            'support_mail' => 'vinawebapp.com@vinawebapp.com',
            'slogan' => 'Một Công Ty Thiết Kế Website Đi Trước Thời Đại Nhiều Năm Ánh Sáng',
            'sub_slogan' => 'Cuối cùng bạn đã đến. Sẵn sàng cho một trang web mới đẹp và hiệu quả? Chúng tôi,nhóm thiết kế web chuyên nghiệp của bạn,  đang chờ bạn yêu cầu.',
            'facebook' => 'https://www.facebook.com/',
            'instagram' => 'https://www.facebook.com/',
            'zalo' => 'https://www.facebook.com/',
            'youtube' => 'https://www.facebook.com/',
            'tiktok' => 'https://www.facebook.com/',
            'linkedin' => 'https://www.facebook.com/',
            'telegram' => 'https://www.facebook.com/',
            'about' => '<p>dsagasdg</p>',
            'province' => '32',
            'district' => '360',
            'ward' => '6377',
            'address' => '717 Tôn Đản',
        ]);
    }
}

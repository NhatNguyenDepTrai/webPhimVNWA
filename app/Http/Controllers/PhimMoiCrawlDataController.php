<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Year;
use App\Models\Nation;
use App\Models\Type;
use App\Models\Product;
use App\Models\ProType;
use App\Models\Episode;
use App\Models\Server;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
class PhimMoiCrawlDataController extends Controller
{
    function downloadFileAndGetFilename($url)
    {
        // Tạo tên tệp ngẫu nhiên
        $filename = basename($url);

        // Tải xuống tệp từ URL và lưu vào thư mục tạm thời
        $tempFilePath = tempnam(sys_get_temp_dir(), 'downloaded_file');
        file_put_contents($tempFilePath, file_get_contents($url));

        // Di chuyển tệp từ thư mục tạm thời vào thư mục public/uploads/files
        $destinationPath = public_path('uploads/files/' . $filename);
        copy($tempFilePath, $destinationPath);

        // Đặt quyền truy cập cho tệp đã di chuyển
        chmod($destinationPath, 0644);

        // Trả về URL của tệp
        return 'files/' . $filename;
    }

    // Sử dụng hàm để tải xuống tệp từ URL và lấy tên của nó

    function createSlug($string)
    {
        $search = ['#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(ì|í|ị|ỉ|ĩ)#', '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(ỳ|ý|ỵ|ỷ|ỹ)#', '#(đ)#', '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(Ì|Í|Ị|Ỉ|Ĩ)#', '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(Đ)#', '/[^a-zA-Z0-9\-\_]/'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'y', 'd', 'A', 'E', 'I', 'O', 'U', 'Y', 'D', '-'];
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    public function getIframePhimMoiEpisode($url)
    {
        try {
            $output = exec('node NodeCrawl/app.js "' . $url . '"');
            return $output;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    function crawlTest()
    {
        $response = Http::get('http://nodeapp.webphim.demo/crawl?p=https://phimmoiiii.net/xem-phim/lupin-phan-3-lupin-season-3-tap-3');
        $data = $response->json();
        // $link = $data['link'];
        // $source = $data['source'];
        dd($data);
    }

    function crawlPhimBo()
    {
        $url = 'https://phimmoiiii.net/phim-bo';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $crawler->filter('#archive-content  article.item ')->each(function (Crawler $node) {
            $productName = $node->filter(' .data h3 a')->text();
            $slug = $this->createSlug($productName);

            $productFullName = $node->filter(' .data span')->text();
            $image_avatar = $node->filter('.poster img')->attr('src');
            $url_avatar = $this->downloadFileAndGetFilename($image_avatar);

            $linkDetail = $node->filter('.poster  a')->link()->getUri();

            $clientDetailProduct = new Client();
            $crawlerDetailProduct = $clientDetailProduct->request('GET', $linkDetail);
            if (!$crawlerDetailProduct) {
                return true;
            }
            $id_nation = 30;

            $desc = $crawlerDetailProduct->filter('#info div.wp-content')->text();
            $dateString = $crawlerDetailProduct->filter('.sheader .data  .date')->text();
            $date = Carbon::createFromFormat('M. d, Y', $dateString);
            $day = $date->day;
            $month = $date->month;
            $yearName = $date->year;
            $productDate = "Ngày: $day, Tháng: $month";
            $yearName = str_replace('Năm phát hành: ', '', $yearName);
            $year = Year::where('name', 'like', $yearName . '%')->first();
            if ($year) {
                $id_year = $year->id;
            } else {
                return true;
            }
            $productCheck = Product::where('slug', $slug)->first();
            if ($productCheck) {
                $lastId = $productCheck->id;
            } else {
                $dataProduct = [];
                $dataProduct['id_category'] = 1;
                $dataProduct['id_year'] = $id_year;
                $dataProduct['id_nation'] = $id_nation;
                $dataProduct['url_avatar'] = $url_avatar;
                $dataProduct['full_name'] = $productFullName;
                $dataProduct['date'] = $productDate;
                $dataProduct['name'] = $productName;
                $dataProduct['slug'] = $slug;
                $dataProduct['desc'] = $desc;
                $dataProduct['meta_image'] = $url_avatar;
                $dataProduct['meta_title'] = $productName . ' - ' . $productFullName . ' | Kẻ Trộm Phim';
                $dataProduct['meta_desc'] = $desc;
                $lastId = Product::create($dataProduct)->id;

                $crawlerDetailProduct->filter('.sgeneros a')->each(function (Crawler $type) use ($lastId) {
                    $nameType = $type->text();
                    $nameType = str_replace('Phim ', '', $nameType);
                    $slugType = $this->createSlug($nameType);
                    $type = Type::firstOrCreate(['name' => $nameType], ['slug' => $slugType]);
                    ProType::create([
                        'id_type' => $type->id,
                        'id_product' => $lastId,
                    ]);
                });
            }
            $crawlerDetailProduct->filter('ul.episodios li a:not(.nonex)')->each(function (Crawler $episode) use ($lastId) {
                $episodeLink = $episode->filter('a:not(.nonex)')->link()->getUri();
                $episodeName = $episode->filter('a:not(.nonex)')->text();
                $slugEpisode = $this->createSlug($episodeName);
                $checkEpisode = Episode::where('slug', 'like', $slugEpisode . '%')
                    ->where('id_product', $lastId)
                    ->first();
                if ($checkEpisode) {
                    return true;
                }
                $episode = Episode::create(['id_product' => $lastId, 'name' => $episodeName, 'slug' => $slugEpisode]);

                $server = shell_exec('node NodeCrawl/app.js "' . $episodeLink . '"');
                $server = explode('_', $server);
                $type = $server[0];
                $src = $server[1];
                echo $src;
                if ($type != 0 && $src != 0) {
                    Server::create(['id_episode' => $episode->id, 'embed_url' => $src, 'type' => $type]);
                } else {
                    return true;
                }
            });
        });
    }

    function index()
    {
        for ($i = 1; $i < 10; $i++) {
            if ($i <= 1) {
            } else {
                $url = 'https://phimmoiiii.net/phim-le/page/' . $i;
            }
        }
        $url = 'https://phimmoiiii.net/phim-le';
        $client = new Client();

        $crawler = $client->request('GET', $url);

        $crawler->filter('#archive-content  article.item ')->each(function (Crawler $node) {
            $productName = $node->filter(' .data h3 a')->text();
            $slug = $this->createSlug($productName);
            $productCheck = Product::where('slug', $slug)->first();
            if ($productCheck) {
                return true;
            }
            $productFullName = $node->filter(' .data span')->text();
            $image_avatar = $node->filter('.poster img')->attr('src');
            $url_avatar = $this->downloadFileAndGetFilename($image_avatar);

            $linkDetail = $node->filter('.poster  a')->link()->getUri();

            $clientDetailProduct = new Client();
            $crawlerDetailProduct = $clientDetailProduct->request('GET', $linkDetail);
            if (!$crawlerDetailProduct) {
                return true;
            }
            $nameNation = $crawlerDetailProduct->filter('.sheader .data .extra .country')->text();
            $slugNation = $this->createSLug($nameNation);

            $nation = Nation::firstOrCreate(['name' => $nameNation], ['slug' => $slugNation]);
            $id_nation = $nation->id;

            $desc = $crawlerDetailProduct->filter('#info div.wp-content')->text();
            $dateString = $crawlerDetailProduct->filter('.sheader .data  .date')->text();
            $date = Carbon::createFromFormat('M. d, Y', $dateString);
            $day = $date->day;
            $month = $date->month;
            $yearName = $date->year;
            $productDate = "Ngày: $day, Tháng: $month";
            $yearName = str_replace('Năm phát hành: ', '', $yearName);
            $year = Year::where('name', 'like', $yearName . '%')->first();
            if ($year) {
                $id_year = $year->id;
            } else {
                return true;
            }

            $dataProduct = [];
            $dataProduct['id_category'] = 2;
            $dataProduct['id_year'] = $id_year;
            $dataProduct['id_nation'] = $id_nation;
            $dataProduct['url_avatar'] = $url_avatar;
            $dataProduct['full_name'] = $productFullName;
            $dataProduct['date'] = $productDate;
            $dataProduct['name'] = $productName;
            $dataProduct['slug'] = $slug;
            $dataProduct['desc'] = $desc;
            $dataProduct['meta_image'] = $url_avatar;
            $dataProduct['meta_title'] = $productName . ' - ' . $productFullName . ' | Kẻ Trộm Phim';
            $dataProduct['meta_desc'] = $desc;
            $lastId = Product::create($dataProduct)->id;

            $crawlerDetailProduct->filter('.sgeneros a')->each(function (Crawler $type) use ($lastId) {
                $nameType = $type->text();
                $nameType = str_replace('Phim ', '', $nameType);
                $slugType = $this->createSlug($nameType);
                $type = Type::firstOrCreate(['name' => $nameType], ['slug' => $slugType]);
                ProType::create([
                    'id_type' => $type->id,
                    'id_product' => $lastId,
                ]);
            });
            $episodeName = 'Full HD';
            $episodeSlug = 'full-hd';

            $episode = Episode::create(['id_product' => $lastId, 'name' => $episodeName, 'slug' => $episodeSlug]);

            $server = exec('node NodeCrawl/app.js "' . $linkDetail . '"');
            Server::create(['id_episode' => $episode->id, 'embed_url' => $server, 'type' => 'iframe']);
        });
    }
}

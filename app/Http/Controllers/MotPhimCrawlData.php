<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Year;
use App\Models\Nation;
use App\Models\Product;
use App\Models\Type;
use App\Models\ProType;
use App\Models\Episode;
use App\Models\Server;
use Illuminate\Support\Facades\Http;
class MotPhimCrawlData extends Controller
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
        return 'uploads/files/' . $filename;
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
    function index()
    {
        for ($i = 1; $i <= 1; $i++) {
            $url = 'https://bluphim.com/the-loai/phim-le-' . $i;

            $client = new Client();

            $crawler = $client->request('GET', $url);
            echo 'Page -> ' . $i . ' </br> ';
            $crawler->filter('div.list-films ul li.item  ')->each(function (Crawler $node) {
                $productName = $node->filter('.name')->text();
                $slug = $this->createSlug($productName);

                $avatar_crawl = $node->filter('a img.img-film')->attr('src');
                $parts_image = explode('?', $avatar_crawl);

                $url_avatar = $this->downloadFileAndGetFilename('https://bluphim.com/' . $parts_image[0]);
                $linkDetailProduct = $node->filter('a')->link()->getUri();
                $clientDetailProduct = new Client();
                $crawlerDetailProduct = $clientDetailProduct->request('GET', $linkDetailProduct);
                if (!$crawlerDetailProduct) {
                    return true;
                }
                $productFullName = $crawlerDetailProduct->filter('#page-info .real-name')->text();

                $date = '...';
                $yearName = $crawlerDetailProduct->filter('.dinfo .col dd')->eq(4)->text();
                $year = Year::where('name', 'like', $yearName . '%')->first();
                if ($year) {
                    $id_year = $year->id;
                } else {
                    return true;
                }

                $nationName = $crawlerDetailProduct->filter('.dinfo .col dd')->eq(5)->text();
                $nationSlug = $this->createSlug($nationName);
                if ($nationSlug == 'tong-hop') {
                    $id_nation = 6;
                } else {
                    $nation = Nation::where('slug', 'like', $nationSlug . '%')->first();
                    if ($nation) {
                        $id_nation = $nation->id;
                    } else {
                        return true;
                    }
                }
                $desc = $crawlerDetailProduct->filter('#info-film .tab p')->text();

                $productCheck = Product::where('slug', $slug)->first();
                if ($productCheck) {
                    $lastId = $productCheck->id;
                } else {
                    $dataProduct = [];
                    $dataProduct['id_category'] = 2;
                    $dataProduct['id_year'] = $id_year;
                    $dataProduct['id_nation'] = $id_nation;
                    $dataProduct['url_avatar'] = $url_avatar;
                    $dataProduct['full_name'] = $productFullName;
                    $dataProduct['date'] = $date;
                    $dataProduct['name'] = $productName;
                    $dataProduct['slug'] = $slug;
                    $dataProduct['desc'] = $desc;
                    $dataProduct['meta_image'] = $url_avatar;
                    $dataProduct['meta_title'] = $productName . ' - ' . $productFullName . ' | Kẻ Trộm Phim';
                    $dataProduct['meta_desc'] = $desc;
                    $lastId = Product::create($dataProduct)->id;

                    $crawlerDetailProduct->filter('.theloaidd a')->each(function (Crawler $type) use ($lastId) {
                        $itemType = $type->text();
                        $itemType = str_replace(',', '', $itemType);
                        $itemTypeSlug = $this->createSlug($itemType);
                        $checkType = Type::where('slug', 'like', $itemTypeSlug . '%')->first();
                        if ($checkType) {
                            ProType::create([
                                'id_type' => $checkType->id,
                                'id_product' => $lastId,
                            ]);
                        }
                    });
                }

                $linktWatch = $crawlerDetailProduct->filter('#page-info .blockbody .info ul.two-button li a.btn-danger')->link()->getUri();
                $clientWatch = new Client();
                $crawlertWatch = $clientWatch->request('GET', $linktWatch);
                if (!$crawlertWatch) {
                    return true;
                }

                $listEpisode = [];
                $crawlertWatch->filter('.control-box  .episodes .list-episode a')->each(function (Crawler $episode) use ($lastId) {
                    $episodeName = $episode->text();
                    $slugEpisode = $this->createSlug($episodeName);
                    $episodeLink = $episode->link()->getUri();

                    $checkEpisode = Episode::where('slug', 'like', $slugEpisode . '%')
                        ->where('id_product', $lastId)
                        ->first();
                    if ($checkEpisode) {
                        return true;
                    }
                    $episodeId = Episode::create(['id_product' => $lastId, 'name' => $episodeName, 'slug' => $slugEpisode])->id;
                    $clientDetailEpisode = new Client();
                    $crawlerDetailEpisode = $clientDetailEpisode->request('GET', $episodeLink);
                    if (!$crawlerDetailEpisode) {
                        return true;
                    }
                    $server = $crawlerDetailEpisode->filter('iframe#iframeStream')->attr('src');
                    // Server::create(['id_episode' => $episodeId, 'embed_url' => $serverIframe, 'type' => 'iframe']);
                    dd($$server);
                });
            });
            echo ' </br>  </br>  </br>  </br>  </br>  </br> ';
        }

        // $crawler->filter('#archive-content  article.item ')->each(function (Crawler $node) {
        //     $productName = $node->filter(' .data h3 a')->text();
        //     $slug = $this->createSlug($productName);
        //     $productFullName = $node->filter(' .data span')->text();
        //     $image_avatar = $node->filter('.poster img')->attr('src');
        //     // $url_avatar = $this->downloadFileAndGetFilename($image_avatar);

        //     $linkDetail = $node->filter('.poster  a')->link()->getUri();

        //     $clientDetailProduct = new Client();
        //     $crawlerDetailProduct = $clientDetailProduct->request('GET', $linkDetail);
        //     if (!$crawlerDetailProduct) {
        //         return true;
        //     }

        //     $desc = $crawlerDetailProduct->filter('#info div.wp-content')->text();
        //     $dateString = $crawlerDetailProduct->filter('.sheader .data  .date')->text();
        //     $date = Carbon::createFromFormat('M. d, Y', $dateString);
        //     $day = $date->day;
        //     $month = $date->month;
        //     $yearName = $date->year;
        //     $productDate = "Ngày: $day, Tháng: $month";
        //     $yearName = str_replace('Năm phát hành: ', '', $yearName);
        //     $year = Year::where('name', 'like', $yearName . '%')->first();
        //     if ($year) {
        //         $id_year = $year->id;
        //     } else {
        //         return true;
        //     }
        //     $episodeName = 'Full HD';
        //     $episodeSlug = 'full-hd';
        //     $server = $crawlerDetailProduct->filter('#playcontainer');
        //     var_dump($crawlerDetailProduct);
        //     return false;
        //     // echo '</br> UrlAvatar: ' . $url_avatar;
        //     echo '</br> Name: ' . $productName . ' - ' . $productFullName . ' - ' . $id_year;
        //     echo '</br> slug: ' . $slug;
        //     echo '</br> date: ' . $date;
        //     echo '</br> desc: ' . $desc;

        //     echo '</hr></br></br></br></br></br></br></br></br></br></br></br></br></br>';
        // });
    }
}

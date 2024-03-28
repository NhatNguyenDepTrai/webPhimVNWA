<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Year;
use App\Models\Product;
use App\Models\ProType;
use App\Models\Episode;
use App\Models\Server;
use Illuminate\Support\Facades\Storage;
class CrawlWibu47Japan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }
    public function downloadFileAndGetFilename($url)
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
    public function createSlug($string)
    {
        $search = ['#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#', '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#', '#(ì|í|ị|ỉ|ĩ)#', '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#', '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#', '#(ỳ|ý|ỵ|ỷ|ỹ)#', '#(đ)#', '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#', '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#', '#(Ì|Í|Ị|Ỉ|Ĩ)#', '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#', '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#', '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#', '#(Đ)#', '/[^a-zA-Z0-9\-\_]/'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'y', 'd', 'A', 'E', 'I', 'O', 'U', 'Y', 'D', '-'];
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $url = 'https://wibu47.com/the-loai/anime';

        $client = new Client();

        $crawler = $client->request('GET', $url);
        // dd($crawler);

        $crawler->filter('ul.MovieList  li.TPostMv')->each(function (Crawler $node) {
            $productName = $node->filter('article a h2.Title')->text();
            $slug = $this->createSlug($productName);
            $image_avatar = $node->filter('.Image img')->attr('src');

            $url_avatar = $this->downloadFileAndGetFilename($image_avatar);

            $linkDetail = $node->filter('article a')->link()->getUri();

            $clientDetailProduct = new Client();
            $crawlerDetailProduct = $clientDetailProduct->request('GET', $linkDetail);
            if (!$crawlerDetailProduct) {
                return true;
            }
            $desc = $crawlerDetailProduct->filter('.Description')->text();
            $yearName = $crawlerDetailProduct->filter('.InfoList li.AAIco-adjust')->eq(4)->text();
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
                $dataProduct['id_nation'] = 7;
                $dataProduct['url_avatar'] = $url_avatar;
                $dataProduct['full_name'] = $productName;
                $dataProduct['date'] = '27 Tháng 3';
                $dataProduct['name'] = $productName;
                $dataProduct['slug'] = $slug;
                $dataProduct['desc'] = $desc;
                $dataProduct['meta_image'] = $url_avatar;
                $dataProduct['meta_title'] = $productName . ' (' . $yearName . ') | Kẻ Trộm Phim';
                $dataProduct['meta_desc'] = $desc;
                $lastId = Product::create($dataProduct)->id;
                ProType::create([
                    'id_type' => 22,
                    'id_product' => $lastId,
                ]);
            }

            $linktWatch = $crawlerDetailProduct->filter('a.watch_button_more')->link()->getUri();
            $clientWatch = new Client();
            $crawlertWatch = $clientWatch->request('GET', $linktWatch);
            if (!$crawlertWatch) {
                return true;
            }

            $listEpisode = [];
            $crawlertWatch->filter('ul.list-episode  li.episode')->each(function (Crawler $episode) use ($lastId) {
                $episodeName = $episode->filter('a')->attr('title');
                $slugEpisode = $this->createSlug($episodeName);
                $episodeLink = $episode->filter('a')->link()->getUri();
                $checkEpisode = Episode::where('name', 'like', $episodeName . '%')
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
                $server = $crawlerDetailEpisode->filterXPath('//script[contains(.,"VPRO")]')->text();
                if ($server) {
                    $startPos = strpos($server, 'VPRO = "') + strlen('VPRO = "');
                }
                $endPos = strpos($server, '"', $startPos);
                $serverIframe = substr($server, $startPos, $endPos - $startPos);
                if ($serverIframe) {
                    Server::create(['id_episode' => $episodeId, 'embed_url' => $serverIframe, 'type' => 'iframe']);
                } else {
                    $inputValue = $crawlerDetailEpisode->filter('input[name="src_an0"]')->attr('value');

                    // Giải mã giá trị JSON trong thuộc tính value
                    $inputValue = json_decode($inputValue, true);
                    if (!$inputValue) {
                        return true;
                    }
                    // Lấy giá trị của thuộc tính 'file'
                    $fileUrl = $inputValue['file'];
                    if (!$fileUrl) {
                        return true;
                    }

                    Server::create(['id_episode' => $episodeId, 'embed_url' => $fileUrl, 'type' => 'video']);
                }
            });
        });
    }
}

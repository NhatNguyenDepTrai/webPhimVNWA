<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeCrawlPhimMoiPhimBoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:phimMoi-phimBo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bot = new \App\Scraper\PhimBo_PhimMoi_CrawlData();
        $bot->scrape();
    }
}

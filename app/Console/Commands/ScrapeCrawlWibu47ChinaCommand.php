<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeCrawlWibu47ChinaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:wibu47-nationChina';

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
        $bot = new \App\Scraper\TypeChina_Wibu47_CrawlData();
        $bot->scrape();
    }
}

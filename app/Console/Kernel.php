<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SoftDeleteExpiredRecords;
use App\Jobs\CrawlWibu47China;
use App\Jobs\CrawlWibu47Japan;
use App\Jobs\PhimMoi_PhimLe_CrawlDataJob;
use App\Jobs\PhimMoi_PhimBo_CrawlDataJob;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new PhimMoi_PhimLe_CrawlDataJob())->everyTenMinutes();
        $schedule->job(new PhimMoi_PhimBo_CrawlDataJob())->everyTenMinutes();
        $schedule->job(new CrawlWibu47China())->everyTenMinutes();
        $schedule->job(new CrawlWibu47Japan())->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

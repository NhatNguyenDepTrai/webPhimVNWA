<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CategoryProject;

class SoftDeleteExpiredRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            foreach (CategoryProject::onlyTrashed()->get() as $key => $value) {
                $now = Carbon::now();
                $delete_at = Carbon::parse($value->deleted_at);

                if ($delete_at->diffInDays($now) > 30) {
                    CategoryProject::where('id', $value->id)->forceDelete();
                }
            }
        } catch (\Exception $e) {
            // Log error if there's an exception
            \Log::error('SoftDeleteExpiredRecords job failed: ' . $e->getMessage());
        }
    }
}

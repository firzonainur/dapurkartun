<?php

namespace App\Console\Commands;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PublishScheduledNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publikasikan artikel berita yang telah mencapai jadwal waktu rilis (Asia/Jakarta)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now('Asia/Jakarta');

        $count = News::where('status', 'scheduled')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', $now)
            ->update([
                'status' => 'published',
            ]);

        $this->info("Berhasil memperbarui status {$count} artikel terjadwal menjadi terbit.");

        return Command::SUCCESS;
    }
}

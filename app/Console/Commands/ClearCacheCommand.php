<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Cache\AllClearController;

class ClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache logs of the applications are truncated';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        AllClearController::clear();
        // $url = route('clear');
        // Http::timeout(20)->get($url)->getBody();
        // $this->info('Successfully truncated all logs and cache You can use clear Manually using this URL:' . $url);
    }
}

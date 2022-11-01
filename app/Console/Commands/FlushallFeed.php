<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class FlushallFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:flushall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Redis::keys('aaa');
        $ts = Feed::all();
        foreach ($ts as $t){
            $t->delete();
        }
       return 0;
    }
}

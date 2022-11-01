<?php

namespace App\Console\Commands;

use App\Models\Feed;
use App\Models\Transaction;
use App\Models\Upload;
use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Flushdb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flushdb {input?}';

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
        if($this->argument('input') === 'deleteall'){
            $name = $this->argument('input') === 'deleteall';
            switch ($name){
                case 'upload':
                    $us = Upload::all();
                    foreach ($us as $u){
                        $u->delete();
                    }
                break;
            }
        }
       return 0;
    }
}

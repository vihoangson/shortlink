<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;

class DeleteMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:deleteall';

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
        $ms = Message::all();
        foreach ($ms as $m){
            $m->delete();
        }
        return 0;
    }
}

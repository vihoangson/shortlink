<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\Alert;
use App\Services\AlertService;
use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RestoreFileDB extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore {input?}';

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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        if($this->argument('input') === 'deleteall'){
            $files = File::files('database');
            foreach ($files as $file){
                if(preg_match('/bk_before_restore\.([0-9]+)$/',$file)){
                    File::delete($file);
                }
            }
            return 0;
        }

        if(!$this->argument('input')){
            $files = Storage::disk('s3')->allFiles(config('app.folder_backup','backup_annie'));
            usort($files,function($a,$b){
                preg_match('/.([0-9]+)$/',$a,$match1);
                preg_match('/.([0-9]+)$/',$b,$match2);
                if($match1[1]<$match2[1]){
                    return true;
                }
                return false;
            });
            foreach ($files as $file){
                dump($file);
            }
        }else{
            $input = $this->argument('input');
            $content = Storage::disk('s3')->get($input);
            @File::move(database_path('database.sqlite'),database_path('database.sqlite.bk_before_restore.'.time()));
            File::put(database_path('database.sqlite'),$content);
            File::chmod(database_path('database.sqlite'),0777);
        }
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\Alert;
use App\Services\AlertService;
use App\Services\TransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BackupFileDB extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:db';

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
        if (!File::isDirectory(database_path('backups'))) {
            File::makeDirectory(database_path('backups'));
        }
        $target = database_path('backups/database.sqlite.bk.' . time());
        $file   = File::copy(database_path('database.sqlite'), $target);
        AlertService::chatwork(' Backup file DB: ' . $target);
        $file = File::get($target);
        $path = config('app.folder_backup', 'backup_annie') . '/' . basename($target);
        Storage::disk('s3')
               ->put($path, $file);
        AlertService::chatwork('backup thành công: ' . $path);

        return 0;
    }
}

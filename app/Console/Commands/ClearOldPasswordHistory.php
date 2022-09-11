<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ClearOldPasswordHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password-history:clear {--keep=3}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removing old passwords from PasswordHistory table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::chunk(100, function ($users) {
            $users->each->deletePasswordHistory($this->option('keep'));
        });
    }
}

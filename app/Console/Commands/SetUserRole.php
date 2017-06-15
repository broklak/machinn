<?php

namespace App\Console\Commands;

use App\UserRole;
use Illuminate\Console\Command;

class SetUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hotel:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set User Role Permission';

    /**
     * @var
     */
    private $role;

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
     * @return mixed
     */
    public function handle()
    {
      $role = UserRole::generateRole();
      echo "Done \n";
    }
}

<?php

namespace App\Console\Commands;

use App\Menu;
use Illuminate\Console\Command;

class WarmUpCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warmup:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm Up All Cache From Database';

    /**
     * @var
     */
    private $menu;

    /**
     * Create a new command instance.
     *
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        parent::__construct();
        $this->menu = $menu;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $menu = $this->menu->generateMenu();
        echo 'Done /n';
    }
}

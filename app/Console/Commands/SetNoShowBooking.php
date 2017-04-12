<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BookingHeader;

class SetNoShowBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hotel:noshow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set booking to no show where check in date is more than today';

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
        $data = BookingHeader::setNoShowBooking();
        echo $data."\n";
    }
}

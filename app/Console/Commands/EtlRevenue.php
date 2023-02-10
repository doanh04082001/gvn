<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderStatistic;
use App\Models\ProductStatistic;

class EtlRevenue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:revenue
        {--all : ETL for whole orders from very first beginning to now} 
        {--F|from_date= : orders were created}
        {--T|to_date= : orders were created}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Etl revenue statistics';

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
        ProductStatistic::etl($this->options());
        OrderStatistic::etl($this->options());
    }
}

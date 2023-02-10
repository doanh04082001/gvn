<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAddressJsonFileJob;
use Illuminate\Console\Command;

class GenerateAddressFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-address';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate address json file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GenerateAddressJsonFileJob::dispatch();
    }
}

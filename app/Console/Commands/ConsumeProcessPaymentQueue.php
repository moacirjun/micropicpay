<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsumeProcessPaymentQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-payment:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume process payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo "Consuming..." . PHP_EOL;
    }
}

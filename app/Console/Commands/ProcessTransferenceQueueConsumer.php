<?php


namespace App\Console\Commands;

use App\Services\Transference\Messages\ProcessTransferenceRequest\Consumer;
use Illuminate\Console\Command;

class ProcessTransferenceQueueConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-transference:consume';

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
        $this->info('Consuming Process Payment Messages...');
        (new Consumer)->consume();
    }
}

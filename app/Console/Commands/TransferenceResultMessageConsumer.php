<?php


namespace App\Console\Commands;

use App\Services\Transference\Message\Process\Consumer as TransferenceMessageProcessConsumer;
use Illuminate\Console\Command;

class TransferenceResultMessageConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transference-result-messages:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume Transference Result Messages';

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
        $this->info("Consuming Transference Result Messages...");
        (new TransferenceMessageProcessConsumer)->consume();
    }
}

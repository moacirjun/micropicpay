<?php


namespace App\Console\Commands;

use App\Services\Transference\Messages\NotifyTransferenceResult\Consumer as TransferenceMessageProcessConsumer;
use Illuminate\Console\Command;

class NotifyTransferenceResultQueueConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-transference-result:consume';

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

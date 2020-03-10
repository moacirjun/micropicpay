<?php


namespace App\Console\Commands;

use Anik\Amqp\ConsumableMessage;
use App\Contracts\Services\Transference\Process\Message\RabbitMQPublisherInterface;
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

        $closure = function (ConsumableMessage $message) {
            echo date('[d/m/Y H:s:i]') . ' Processing... MESSAGE: ' . $message->getStream() . PHP_EOL;
            $message->getDeliveryInfo()->acknowledge();
        };

        app('amqp')->consume($closure, '', $this->getConfig());
    }

    private function getConfig()
    {
        return [
            'exchange' => [
                'declare' => true,
                'type' => 'fanout',
                'name' => RabbitMQPublisherInterface::EXCHANGE_NAME,
            ],
            'queue' => [
                'name' => RabbitMQPublisherInterface::QUEUE_NAME,
                'declare' => true,
                'exclusive' => false,
            ],
            'qos' => [
                'enabled' => true,
                'qos_prefetch_count' => 5,
            ],
        ];
    }
}

<?php

namespace App\Services\Transference\Messages\NotifyTransferenceResult;

use Anik\Amqp\ConsumableMessage as BaseConsumableMessage;
use App\Contracts\Services\User\Payment\ServiceInterface as TransferenceProcessorService;

class ConsumableMessage extends BaseConsumableMessage
{
    /**
     * @var TransferenceProcessorService
     */
    private $transferenceProcessorService;

    public function __construct(string $stream = '', array $properties = [])
    {
        parent::__construct($stream, $properties);
        $this->transferenceProcessorService = app(TransferenceProcessorService::class);
    }

    public function handle()
    {
        $this->printProcessingStream();
        $this->getDeliveryInfo()->acknowledge();
    }

    private function printProcessingStream()
    {
        echo date('[d/m/Y H:i:s]') . ' Processing MSG: ' . $this->getStream() . PHP_EOL;
    }
}

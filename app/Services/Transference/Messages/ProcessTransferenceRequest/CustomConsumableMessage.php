<?php

namespace App\Services\Transference\Messages\ProcessTransferenceRequest;

use Anik\Amqp\ConsumableMessage;
use App\Contracts\Services\User\Payment\ServiceInterface as TransferenceProcessorService;
use App\Domain\Payment;
use SebastianBergmann\CodeCoverage\Report\PHP;

class CustomConsumableMessage extends ConsumableMessage
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
        try {
            $this->printProcessingStream();

            $payment = unserialize($this->getStream());

            if ($payment instanceof Payment) {
                $this->transferenceProcessorService->execute($payment);
            }
        } catch (\Exception $exception) {
            echo sprintf('ERROR MSG: %s. CODE: [%s]', $exception->getMessage(), $exception->getCode()) . PHP_EOL;
        }

        $this->getDeliveryInfo()->acknowledge();
    }

    private function printProcessingStream()
    {
        echo date('[d/m/Y H:i:s]') . ' Processing MSG: ' . $this->getStream() . PHP_EOL;
    }
}

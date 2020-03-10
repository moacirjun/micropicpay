<?php

namespace App\Services\Transference\Message\Process;

use Anik\Amqp\ConsumableMessage;
use App\Contracts\Services\Transference\Process\Message\RabbitMQPublisherInterface;
use App\RabbitMQ\AbstractConsumer;
use App\Services\Transference\Message\Process\ConsumableMessage as TransferenceProcessConsumableMessage;

class Consumer extends AbstractConsumer
{
    protected function getRoutingKey(): string
    {
        return '';
    }

    protected function getConfig()
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

    /**
     * @inheritDoc
     */
    protected function getMessage(): ConsumableMessage
    {
        return new TransferenceProcessConsumableMessage();
    }
}

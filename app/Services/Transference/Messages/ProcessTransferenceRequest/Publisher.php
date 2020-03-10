<?php

namespace App\Services\Transference\Messages\ProcessTransferenceRequest;

use App\Contracts\Services\Payment\RabbitMQPublisherInterface;
use App\RabbitMQ\AbstractPublisher;

class Publisher extends AbstractPublisher
{
    public function getRoutingKey(): string
    {
        return RabbitMQPublisherInterface::EXCHANGE_ROUTE_KEY;
    }

    public function getConfig(): array
    {
        return [
            'exchange' => [
                'name' => RabbitMQPublisherInterface::EXCHANGE_NAME,
                'declare' => true,
                'type' => 'direct',
            ],
            'message' => [
                'content_type' => 'text/plain',
            ],
            'queue' => [
                'name' => 'test',
                'declare' => true,
            ]
        ];
    }
}

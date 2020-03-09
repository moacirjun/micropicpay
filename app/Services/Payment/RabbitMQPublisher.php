<?php

namespace App\Services\Payment;

use App\Contracts\Services\Payment\RabbitMQPublisherInterface;
use App\RabbitMQ\AbstractPublisher;

class RabbitMQPublisher extends AbstractPublisher
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
                'content_type' => 'application/json'
            ],
            'queue' => [
                'name' => 'test',
                'declare' => true,
            ]
        ];
    }

    public function publish($message)
    {
        $json = json_encode($message);
        parent::publish($json);
    }
}

<?php

namespace App\Services\Transference\Message\Process;

use App\Contracts\Services\Transference\Process\Message\RabbitMQPublisherInterface;
use App\RabbitMQ\AbstractPublisher;

class Publisher extends AbstractPublisher implements RabbitMQPublisherInterface
{
    public function getRoutingKey(): string
    {
        return '';
    }

    public function getConfig(): array
    {
        return [
            'exchange' => [
                'name' => RabbitMQPublisherInterface::EXCHANGE_NAME,
                'declare' => true,
                'type' => 'fanout',
            ],
            'message' => [
                'content_type' => 'application/json'
            ],
        ];
    }

    public function publish($message)
    {
        $json = json_encode($message);
        parent::publish($json);
    }
}

<?php

namespace App\Services\Payment;

use Anik\Amqp\ConsumableMessage;
use App\RabbitMQ\AbstractConsumer;

class RabbitMQQueueConsumer extends AbstractConsumer
{
    protected function getRoutingKey(): string
    {
        return 'process_payment.message';
    }

    protected function getConfig()
    {
        return [
            'exchange'   => [
                'declare' => true,
                'type'    => 'direct',
                'name'    => 'process_payment.exchange',
            ],
            'queue' => [
                'name'         => 'process_payment.exchange.queue',
                'declare'      => true,
                'exclusive'    => false,
            ],
            'qos' => [
                'enabled'            => true,
                'qos_prefetch_count' => 5,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getMessage(): ConsumableMessage
    {
        return new RabbitMQQueueConsumerMessage();
    }
}

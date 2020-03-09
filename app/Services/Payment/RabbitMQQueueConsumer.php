<?php

namespace App\Services\Payment;

use Anik\Amqp\ConsumableMessage;

class RabbitMQQueueConsumer
{
    public static function consume()
    {
        app('amqp')->consume(function (ConsumableMessage $message) {
            echo '---- Processing MSG: ' . $message->getStream() . PHP_EOL;

            $message->getDeliveryInfo()->acknowledge();
        }, 'process_payment.message', [
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
        ]);
    }
}

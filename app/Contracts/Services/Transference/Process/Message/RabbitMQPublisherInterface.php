<?php

namespace App\Contracts\Services\Transference\Process\Message;

use App\Contracts\RabbitMQ\AbstractPublisherInterface;

interface RabbitMQPublisherInterface extends AbstractPublisherInterface
{
    const EXCHANGE_NAME = 'transference_result.exchange';
    const EXCHANGE_ROUTE_KEY = 'transference_result.message';
    const QUEUE_NAME = 'transference_result.exchange.queue';
}

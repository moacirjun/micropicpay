<?php

namespace App\RabbitMQ;

use Anik\Amqp\AmqpManager;
use App\Contracts\RabbitMQ\AbstractPublisherInterface;

abstract class AbstractPublisher implements AbstractPublisherInterface
{
    /**
     * @var AmqpManager
     */
    private $amqpManager;

    public function __construct()
    {
        $this->amqpManager = app('amqp');
    }

    public function getRoutingKey() : string
    {
        return '';
    }

    public function getConfig() : array
    {
        return [];
    }

    public function publish($message)
    {
        $this->amqpManager->publish($message, $this->getRoutingKey(), $this->getConfig());
    }
}

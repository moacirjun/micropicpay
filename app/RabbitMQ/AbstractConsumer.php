<?php

namespace App\RabbitMQ;

use Anik\Amqp\ConsumableMessage;

abstract class AbstractConsumer
{
    public function consume()
    {
        app('amqp')->consume($this->getMessage(), $this->getRoutingKey(), $this->getConfig());
    }

    /**
     * @return ConsumableMessage
     */
    protected abstract function getMessage(): ConsumableMessage;

    /**
     * @return string
     */
    protected function getRoutingKey() : string
    {
        return '';
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        return [];
    }
}

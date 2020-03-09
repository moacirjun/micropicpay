<?php


namespace App\Contracts\RabbitMQ;


interface AbstractPublisherInterface
{
    /**
     * @param $message
     * @return mixed
     */
    public function publish($message);
}

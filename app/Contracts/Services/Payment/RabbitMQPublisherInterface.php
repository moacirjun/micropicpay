<?php


namespace App\Contracts\Services\Payment;


interface RabbitMQPublisherInterface
{
    const EXCHANGE_NAME = 'process_payment.exchange';
    const EXCHANGE_ROUTE_KEY = 'process_payment.message';
    const QUEUE_NAME = 'process_payment.exchange.queue';
}

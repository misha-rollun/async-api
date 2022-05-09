<?php

declare(strict_types=1);

namespace AsyncAPI\Handlers;

use PhpAmqpLib\Message\AMQPMessage;

class Handler implements HandlerContract
{
    /**
     * @param AMQPMessage $message
     * @return bool
     */
    public function handle($message): bool
    {
        try {
            echo "Receiving message..." . PHP_EOL;
            print_r($message->getBody());
            echo PHP_EOL;
            return true;
        } catch (\Throwable $t) {
            echo $t->getMessage();
            return false;
        }
    }
}


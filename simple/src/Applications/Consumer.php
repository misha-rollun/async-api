<?php
/**
 * Consumer application is the single final class that you should obtain from concrete factory
 * This application will have methods for each channel/operation and you should only
 * Pass custom handlers to those methods for any business logic needed on message received
 * Consumer = Worker = Subscriber
 * User: emiliano
 * Date: 7/1/21
 * Time: 12:24
 */

namespace AsyncAPI\Applications;

use AsyncAPI\Handlers\HandlerContract;
use AsyncAPI\Handlers\AMQPRPCServerHandler;

final class Consumer extends ApplicationContract
{
}

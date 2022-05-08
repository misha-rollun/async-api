<?php
/**
 * Producer application is the single final class that you should obtain from concrete factory
 * This application will have methods for each channel/operation and you should only
 * pass messages and handlers that will implement any business logic needed (eg: rpc calls)
 * Producer = Publisher
 *
 * User: emiliano
 * Date: 30/12/20
 * Time: 20:22
 */

namespace AsyncAPI\Applications;

use AsyncAPI\Messages\MessageContract;
use AsyncAPI\Handlers\AMQPRPCClientHandler;

final class Producer extends ApplicationContract
{
}

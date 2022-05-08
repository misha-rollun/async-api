<?php
/**
 * Interface that describes the AbstractFactory, refer to pattern design for further clarification
 *
 * User: emiliano
 * Date: 30/12/20
 * Time: 11:35
 */

namespace AsyncAPI\Common;

use AsyncAPI\Handlers\HandlerContract;
use AsyncAPI\Infrastructure\BrokerClientContract;
use AsyncAPI\Messages\MessageContract;
use AsyncAPI\Applications\ApplicationContract;

interface FactoryContract
{
    /**
     * @param array $config
     * @param null $brokerConnection
     * @return BrokerClientContract
     */
    public function createBrokerClient(
        array $config = []
    ): BrokerClientContract;

    /**
     * @param string $applicationType
     * @param array $config
     * @return ApplicationContract
     */
    public function createApplication(
        string $applicationType,
        array $config = []
    ): ApplicationContract;

    /**
     * @param string $handlerType
     * @param array $config
     * @return HandlerContract
     */
    public function createHandler(
        string $handlerType,
        array $config = []
    ): HandlerContract;

    /**
     * @param $messageType
     * @param array $properties
     * @param array $brokerMessageProperties
     * @return MessageContract
     */
    public function createMessage(
        $messageType,
        array $properties = [],
        array $brokerMessageProperties = []
    ): MessageContract;
}

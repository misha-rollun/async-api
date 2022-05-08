<?php
/**
 * AMQPFactory is a concretion of our abstractfactory.
 * It's responsibility is to abstract the instantiation process for all AMQP-related classes
 *
 * User: emiliano
 * Date: 30/12/20
 * Time: 11:39
 */

namespace AsyncAPI\Common;

use AsyncAPI\Handlers\HandlerContract;
use AsyncAPI\Infrastructure\BrokerClientContract;
use AsyncAPI\Infrastructure\AMQPBrokerClient;
use AsyncAPI\Messages\MessageContract;
use AsyncAPI\Applications\ApplicationContract;
use AsyncAPI\Applications\Consumer;
use AsyncAPI\Applications\Producer;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPFactory implements FactoryContract
{
    /** @var AMQPStreamConnection $brokerConnection */
    private $brokerConnection;

    /**
     * AMQPFactory constructor.
     * @param AMQPStreamConnection|null $brokerConnection
     */
    public function __construct(
        AMQPStreamConnection $brokerConnection = null
    ) {
        $this->brokerConnection = $brokerConnection;
    }

    /**
     * /**
     * @param array $config
     * @param null $brokerConnection
     * @return BrokerClientContract
     */
    public function createBrokerClient(
        array $config = []
    ): BrokerClientContract {

        if (empty($this->brokerConnection)) {
            $this->brokerConnection = new AMQPStreamConnection(
                $config[BROKER_HOST_KEY] ?? BROKER_HOST_DEFAULT,
                $config[BROKER_PORT_KEY] ?? BROKER_PORT_DEFAULT,
                $config[BROKER_USER_KEY] ?? BROKER_USER_DEFAULT,
                $config[BROKER_PASSWORD_KEY] ?? BROKER_PASSWORD_DEFAULT,
                $config[BROKER_VIRTUAL_HOST_KEY] ?? BROKER_VIRTUAL_HOST_DEFAULT
            );
        }

        return new AMQPBrokerClient(
            $this->brokerConnection,
            $this
        );
    }

    /**
     * @param string $applicationType
     * @param array $config
     * @return ApplicationContract
     */
    public function createApplication(
        string $applicationType,
        array $config = []
    ): ApplicationContract {
        $application = null;

        $brokerClient = $this->createBrokerClient($config);

        switch ($applicationType) {
            case PRODUCER_KEY:
                $application = new Producer(
                    $brokerClient
                );
                break;
            case CONSUMER_KEY:
                $application = new Consumer(
                    $brokerClient
                );
                break;
        }
        $application->setFactory($this);

        return $application;
    }

    /**
     * @param string $handlerType
     * @param array $config
     * @return HandlerContract
     */
    public function createHandler(
        string $handlerType,
        array $config = []
    ): HandlerContract
    {
        return new $handlerType($config);
    }

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
    ): MessageContract {
        /** @var MessageContract $message */
        $message = new $messageType();
        $setters = $message->setters();
        foreach ($properties as $property => $value) {
            $setter = $setters[$property];
            $message->$setter($value);
        }
        /**
         * @var $correlationId
         * @var string $replyTo
         */
        extract($brokerMessageProperties);
        $message
            ->setPayload(
                new AMQPMessage(
                    json_encode($message),
                    [
                        'correlation_id' => $correlationId ?? null,
                        'reply_to'       => $replyTo ?? null,
                    ]
                )
            );

        return $message;
    }
}

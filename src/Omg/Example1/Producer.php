<?php

namespace Omg\Example1;

use Omg\Core\Config\ConfigInterface;
use Omg\Core\Operation\OperationInterface;

/**
 * Class Producer
 * @package Example1
 */
class Producer implements OperationInterface
{

    /**
     * @var \Kafka_Producer
     */
    protected $kafkaInstance;

    /**
     * @var array
     */
    protected $messages = [
        array('topic' => 'test', 'partition' => 0, 'payload' => ['test message 00']),
        array('topic' => 'test', 'partition' => 1, 'payload' => ['test message 01']),
        array('topic' => 'test1', 'partition' => 0, 'payload' => ['test message 10']),
        array('topic' => 'test1', 'partition' => 1, 'payload' => ['test message 11']),
        array('topic' => 'test2', 'partition' => 0, 'payload' => ['test message 20']),
        array('topic' => 'test2', 'partition' => 1, 'payload' => ['test message 21']),
    ];

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->kafkaInstance = new \Kafka_Producer(
            $config->getHostList(),
            $config->getKafkaPort(),
            \Kafka_Encoder::COMPRESSION_NONE
        );
    }

    /**
     * @return string
     */
    public function execute()
    {
        $bytes = 0;

        foreach ($this->messages as $message) {
            $bytes += $this->kafkaInstance->send($message['payload'], $message['topic'], $message['partition']);
        }

        printf("\nSent %d messages (%d bytes)\n\n", count($this->messages), $bytes);
    }

}
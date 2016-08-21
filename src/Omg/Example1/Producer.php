<?php

namespace Omg\Example1;

use \Kafka\Produce as KafkaProduce;
use \Omg\Core\Config\ConfigInterface;
use Omg\Core\Operation\OperationInterface;

/**
 * Class Producer
 * @package Example1
 */
class Producer implements OperationInterface
{

    /**
     * @var \Kafka\Produce
     */
    protected $kafkaInstance;

    /**
     * @var array
     */
    protected $messages = [
        array('topic' => 'test', 'partition' => 0, 'load' => 'test message 00'),
        array('topic' => 'test', 'partition' => 1, 'load' => 'test message 01'),
        array('topic' => 'test1', 'partition' => 0, 'load' => 'test message 10'),
        array('topic' => 'test1', 'partition' => 1, 'load' => 'test message 11'),
        array('topic' => 'test2', 'partition' => 0, 'load' => 'test message 20'),
        array('topic' => 'test2', 'partition' => 1,'load' => 'test message 21'),
    ];

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->kafkaInstance = KafkaProduce::getInstance($config->getHostList(), $config->getTimeout());
    }

    /**
     * @return string
     */
    public function execute()
    {
        $this->kafkaInstance->setRequireAck(-1);

        foreach ($this->messages as $message) {
            $this->kafkaInstance->setMessages($message['topic'], $message['partition'], $message['load']);
        }

        return $this->kafkaInstance->send();
    }

}
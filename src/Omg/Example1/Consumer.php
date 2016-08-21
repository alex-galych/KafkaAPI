<?php

namespace Omg\Example1;

use \Kafka\Consumer as KafkaConsumer;
use Omg\Core\Config\ConfigInterface;
use Omg\Core\Operation\OperationInterface;

/**
 * Class Consumer
 * @package Example1
 */
class Consumer implements OperationInterface
{

    /**
     * @var \Kafka\Consumer
     */
    protected $kafkaInstance;

    /**
     * @var string
     */
    protected $group = 'test';

    /**
     * @var array
     */
    protected $partitions = [
        ['topic' => 'test', 'partition' => 0],
        ['topic' => 'test1', 'partition' => 1],
        ['topic' => 'test2', 'partition' => 0],
    ];

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->kafkaInstance = KafkaConsumer::getInstance($config->getHostList(), $config->getTimeout());
        $this->kafkaInstance->setGroup($this->group);

        foreach($this->partitions as $config) {
            $this->kafkaInstance->setPartition($config['topic'], $config['partition']);
        }
    }

    /**
     * @return string
     */
    public function execute()
    {
        $result = '';
        $fetchedData = $this->kafkaInstance->fetch();

        foreach ($fetchedData as $topicName => $topic) {
            foreach ($topic as $partId => $partition) {
                var_dump($partition->getHighOffset());
                foreach ($partition as $message) {
                    var_dump((string)$message);
                    $result[] = $message;
                }
            }
        }

        return implode($result);
    }

}
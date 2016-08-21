<?php

namespace Omg\Example1;

use Omg\Core\Config\ConfigInterface;
use Omg\Core\Operation\OperationInterface;

/**
 * Class Consumer
 * @package Example1
 */
class Consumer implements OperationInterface
{

    /**
     * @var \Kafka_SimpleConsumer
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
        ['topic' => 'test', 'partition' => 0, 'offset' => 0],
        ['topic' => 'test1', 'partition' => 1, 'offset' => 0],
        ['topic' => 'test2', 'partition' => 0, 'offset' => 0],
    ];

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->kafkaInstance = new \Kafka_SimpleConsumer(
            $config->getHostList(),
            $config->getKafkaPort(),
            $config->getTimeout(),
            1000000
        );
    }

    /**
     * @return string
     */
    public function execute()
    {
        while(true) {
            try {
                foreach($this->partitions as $messageStorage) {
                    $this->retrieveTopicMessage($messageStorage);
                }
            } catch (\Exception $e) {
                echo sprintf('\nERROR: %s', $e->getMessage());
            }

//            sleep(3);
        }
    }

    /**
     * @param array $messageStorage
     *
     * @return void
     */
    protected function retrieveTopicMessage(array $messageStorage)
    {
        $messageNumber = 0;
        $fetchRequest = new \Kafka_FetchRequest(
            $messageStorage['topic'], $messageStorage['partition'], $messageStorage['offset'], 1000000);

        $retrievedMessages = $this->kafkaInstance->fetch($fetchRequest);
        foreach ($retrievedMessages as $retrievedMessage) {
            echo sprintf(
                'Message #%d, offset: %d, payload: %s',
                $messageNumber++, $messageStorage['offset'], $retrievedMessage->payload()
            );
        }

        unset($fetchRequest);
    }

}
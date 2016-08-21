<?php

namespace Omg\Example1;

use Omg\Core\Config\Config;
use Omg\Core\Example\ExampleFactoryInterface;

/**
 * Class Factory
 * @package Example1
 */
class ExampleFactory implements ExampleFactoryInterface
{

    /**
     * @return Consumer
     */
    public function createConsumer()
    {
        return new Consumer($this->createConfig());
    }

    /**
     * @return Producer
     */
    public function createProducer()
    {
        return new Producer($this->createConfig());
    }

    /**
     * @return \Omg\Core\Config\ConfigInterface
     */
    protected function createConfig()
    {
        return new Config();
    }

}
<?php

namespace Omg\Core\Example;

interface ExampleFactoryInterface
{

    /**
     * @return \Omg\Core\Operation\OperationInterface
     */
    public function createConsumer();

    /**
     * @return \Omg\Core\Operation\OperationInterface
     */
    public function createProducer();

}
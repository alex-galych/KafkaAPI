<?php

require __DIR__ . '/vendor/autoload.php';

class Executor
{
    protected $examples = [
        'Omg\\Example1\\ExampleFactory'
    ];

    public function run()
    {
        foreach ($this->examples as $exampleFactory) {
            /** @var \Omg\Core\Example\ExampleFactoryInterface $example */
            $example = new $exampleFactory();
//            $example = new Omg\Example1\ExampleFactory();

            $example->createProducer()->execute();
            $example->createConsumer()->execute();
        }
    }
}

(new Executor())
    ->run();
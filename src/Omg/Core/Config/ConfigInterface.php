<?php

namespace Omg\Core\Config;

/**
 * Class Config
 * @package Config
 */
interface ConfigInterface
{

    /**
     * @return string
     *
     * @throws ConfigException
     */
    public function getHostList();

    /**
     * @return string
     *
     * @throws ConfigException
     */
    public function getKafkaPort();

    /**
     * @return string
     *
     * @throws ConfigException
     */
    public function getZookeeperPort();

    /**
     * @return string
     *
     * @throws ConfigException
     */
    public function getTimeout();

}
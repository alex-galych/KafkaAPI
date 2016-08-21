<?php

namespace Omg\Core\Config;

/**
 * Class Config
 * @package Config
 */
class Config implements ConfigInterface
{

    const CONFIG_PATH = 'src/Omg/config/test.json';

    const CONFIG_HOST_LIST_NODE = 'hostList';

    const CONFIG_TIMEOUT = 'timeout';

    protected $config;

    /**
     *
     */
    public function __construct()
    {
        $configContent = file_get_contents(static::CONFIG_PATH);
        $this->config = json_decode($configContent, true);
    }

    /**
     * @return string
     *
     * @throws ConfigException
     */
    public function getHostList()
    {
        return $this->getConfigValue(static::CONFIG_HOST_LIST_NODE);
    }

    /**
     * @return string
     *
     * @throws ConfigException
     */
    public function getTimeout()
    {
        return $this->getConfigValue(static::CONFIG_TIMEOUT);
    }

    /**
     * @param string $nodeName
     *
     * @return mixed
     *
     * @throws ConfigException
     */
    protected function getConfigValue($nodeName)
    {
        if (is_array($this->config) && array_key_exists($nodeName, $this->config)) {
            return $this->config[$nodeName];
        }

        throw new ConfigException('Config is not defined');
    }

}
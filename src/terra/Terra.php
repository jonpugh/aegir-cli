<?php

namespace aegir;

/**
 * Class Aegir.
 */
class Aegir
{
    const VERSION = '0.x';

    /**
     * Holds Aegir configuration settings.
     *
     * @var Config
     */
    private $config;

    /**
     * Getter for Configuration.
     *
     * @return Config
     *                Configuration object.
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Setter for Configuration.
     *
     * @param Config $config
     *                       Configuration object.
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}

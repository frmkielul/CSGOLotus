<?php

namespace Steam\Command\EconItems;

use Steam\Command\CommandInterface;

class GetSchemaURL implements CommandInterface
{
    /**
     * @var int
     */
    protected $appId;

    /**
     * @param int $appId
     */
    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    public function getInterface()
    {
        return 'IEconItems_' . $this->appId;
    }

    public function getMethod()
    {
        return 'GetSchemaURL';
    }

    public function getVersion()
    {
        return 'v2';
    }

    public function getRequestMethod()
    {
        return 'GET';
    }

    public function getParams()
    {
        return [];
    }
} 
<?php

namespace Steam\Command\User;

use Steam\Command\CommandInterface;

class GetPlayerBans implements CommandInterface
{
    /**
     * @var array
     */
    protected $steamIds;

    /**
     * @param array $steamIds
     */
    public function __construct(array $steamIds)
    {
        $this->steamIds = $steamIds;
    }

    public function getInterface()
    {
        return 'ISteamUser';
    }

    public function getMethod()
    {
        return 'GetPlayerBans';
    }

    public function getVersion()
    {
        return 'v1';
    }

    public function getRequestMethod()
    {
        return 'GET';
    }

    public function getParams()
    {
        return [
            'steamids' => implode(',', $this->steamIds)
        ];
    }
} 
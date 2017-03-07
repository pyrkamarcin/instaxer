<?php

namespace Monotype\Domain\Model;

use Monotype\Domain\Model;

/**
 * Class Machine
 * @package Monotype\Domain\Model
 */
class Machine extends Model
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $name;


    /**
     * @var
     */
    protected $protocol;


    /**
     * @var
     */
    protected $address;


    /**
     * @var
     */
    protected $port;


    /**
     * @var
     */
    protected $location;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }
}

<?php

namespace Instation;

/**
 * Class Request
 * @package Instation
 */
class Request
{
    /**
     * @var Instation
     */
    public $instation;

    /**
     * Request constructor.
     * @param Instation $instation
     */
    public function __construct(Instation $instation)
    {
        $this->instation = $instation;
    }
}

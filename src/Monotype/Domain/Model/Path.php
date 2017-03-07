<?php

namespace Monotype\Domain\Model;

use Monotype\Domain\Model;

/**
 * Class Path
 * @package Monotype\Domain\Model
 */
class Path extends Model
{
    /**
     * @var
     */
    protected $location;

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }
}

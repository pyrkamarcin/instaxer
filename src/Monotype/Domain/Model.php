<?php

namespace Monotype\Domain;

/**
 * Class Model
 * @package Monotype\Domain\Model
 */
class Model
{
    /**
     * Model constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }
}

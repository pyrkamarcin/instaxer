<?php

namespace Monotype\Domain;

use Monotype\Domain\Dumper\Stock;

/**
 * Class Dumper
 * @package Monotype\Domain
 */
class Dumper
{
    /**
     * @var Stock
     */
    public $stock;

    /**
     * Dumper constructor.
     * @param Stock $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @param $data
     */
    public function stockize($data)
    {
        $this->stock->push($data);
    }
}

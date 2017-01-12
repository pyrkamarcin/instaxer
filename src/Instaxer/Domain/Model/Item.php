<?php

namespace Instaxer\Domain\Model;

use Instaxer\Domain\Model;

/**
 * Class Item
 * @package Instaxer\Domain\Model
 */
class Item extends Model
{
    /**
     * @var
     */
    protected $item;

    /**
     * Item constructor.
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }
}

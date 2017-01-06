<?php

namespace Instaxer\Model;

use Instaxer\Model;

/**
 * Class Item
 * @package Instaxer\Model
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

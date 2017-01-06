<?php

namespace Instaxer\Model;

use Instaxer\Repository;

/**
 * Class ItemRepository
 * @package Instaxer\Model
 */
class ItemRepository extends Repository
{
    /**
     * @var array
     */
    protected $arrayOfTags;

    /**
     * ItemRepository constructor.
     * @param array $arrayOfTags
     */
    public function __construct(array $arrayOfTags)
    {
        $this->arrayOfTags = $arrayOfTags;
    }

    /**
     * @return Item
     */
    public function getRandomItem()
    {
        return new Item($this->arrayOfTags[random_int(0, count($this->arrayOfTags) - 1)]);
    }
}

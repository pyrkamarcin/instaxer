<?php

namespace Instaxer\Model;

/**
 * Class Item
 * @package Instaxer\Model
 */
class Item
{
    /**
     * @var array
     */
    protected $arrayOfTags;

    /**
     * Item constructor.
     * @param array $arrayOfTags
     */
    public function __construct(array $arrayOfTags)
    {
        $this->arrayOfTags = $arrayOfTags;
    }

    /**
     * @return array
     */
    public function getArrayOfTags(): array
    {
        return $this->arrayOfTags;
    }

    /**
     * @param array $arrayOfTags
     */
    public function setArrayOfTags(array $arrayOfTags)
    {
        $this->arrayOfTags = $arrayOfTags;
    }
}

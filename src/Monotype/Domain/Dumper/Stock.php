<?php

namespace Monotype\Domain\Dumper;

use Monotype\Domain\Model\Path;

/**
 * Class Stock
 * @package Monotype\Domain\Dumper
 */
class Stock
{
    /**
     * @var
     */
    public $path;

    /**
     * @var
     */
    private $hash;

    /**
     * Stock constructor.
     * @param Path $path
     */
    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function push($data = null)
    {
        file_put_contents($this->getPath(), $data, FILE_APPEND);
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}

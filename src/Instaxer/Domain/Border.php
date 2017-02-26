<?php

namespace Instaxer\Domain;

/**
 * Class Border
 * @package Instaxer\Domain
 */
class Border
{
    /**
     * @var
     */
    public $listFile;

    /**
     * @var
     */
    public $haystack;

    /**
     * Border constructor.
     * @param $listFile
     */
    public function __construct($listFile)
    {
        $this->listFile = $listFile;
        $this->getListContent();
    }

    /**
     *
     */
    public function getListContent()
    {
        $file = file_get_contents($this->listFile);
        $this->haystack = explode(';', $file);
    }

    /**
     * @param $data
     * @return bool
     */
    public function check($data)
    {
        return in_array($data, $this->haystack, true);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->haystack);
    }
}

<?php

namespace Instaxer;

class Request
{
    /**
     * @var Instaxer
     */
    public $instaxer;

    /**
     * Request constructor.
     * @param Instaxer $instaxer
     */
    public function __construct(Instaxer $instaxer)
    {
        $this->instaxer = $instaxer;
    }
}

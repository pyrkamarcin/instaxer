<?php

namespace Instaxer\Domain;

class Session
{
    public $restoredFromSession;
    public $sessionFile;

    public function __construct($sessionFile)
    {
        $this->sessionFile = $sessionFile;
    }

    public function checkExistsSessionFile()
    {
        return is_file($this->sessionFile);
    }

    public function getSevedSession()
    {
        return file_get_contents($this->sessionFile);
    }

    public function saveSession($savedSession)
    {
        $result = file_put_contents($this->sessionFile, $savedSession);
        if (!$result) {
            unlink($this->sessionFile);
        }
    }
}

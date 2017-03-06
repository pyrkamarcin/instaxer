<?php

namespace Instation;

use Instagram\Instagram;

/**
 * Class Instation
 * @package Instation
 */
class Instation
{
    /**
     * @var int
     */
    public $marker;

    /**
     * @var Instagram
     */
    public $instagram;

    /**
     * Instation constructor.
     * @param string $user
     * @param string $password
     * @throws \Exception
     */
    public function __construct(string $user, string $password)
    {
        $this->instagram = new Instagram();

        $this->instagram->setVerifyPeer(false);

        $restoredFromSession = FALSE;
        $sessionFile = __DIR__ . '/../../session.dat';
        if (is_file($sessionFile)) {
            try {
                $savedSession = file_get_contents($sessionFile);
                if ($savedSession !== FALSE) {
                    $this->instagram->initFromSavedSession($savedSession);
                    $currentUser = $this->instagram->getCurrentUserAccount();
                    if ($currentUser->getUser()->getUsername() == $user) {
                        $restoredFromSession = TRUE;
                    } else {
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage() . "\n";
            }
        }

        if (!$restoredFromSession) {
            $this->instagram->login($user, $password);
            $savedSession = $this->instagram->saveSession();

            $result = file_put_contents($sessionFile, $savedSession);
            if (!$result) {
                unlink($sessionFile);
            }
        }

        $this->marker = 0;
    }
}

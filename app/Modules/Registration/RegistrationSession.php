<?php 

namespace App\Modules\Registration;

class RegistrationSession
{
    private $sessionName = 'registrationSession';
    private $sessionCookieParameters = [
        'lifetime' => 2592000, //30 days
        'httponly' => true,
        'secire' => true,
        'path' => '/'
    ];
    public $rod1IdDbLabel = 'rod1_id_db';
    public $rod2IdDbLabel = 'rod2_id_db';
    public $djecaIdDbLabel = 'djeca_id_db';

    public function overrideSessionCookieParameters($newParameters)
    {
        $this->sessionCookieParameters = $newParameters;
        $this->start();
    }

    public function setRod1Id($rod1IdDb)
    {
        $this->start();
        $_SESSION[$this->rod1IdDbLabel] = $rod1IdDb;
    }

    public function setRod2Id($rod2IdDb)
    {
        $this->start();
        $_SESSION[$this->rod2IdDbLabel] = $rod2IdDb;
    }

    public function setDjecaId($djecaId)
    {
        $this->start();
        $_SESSION[$this->djecaIdDbLabel] = $djecaId;
    }

    public function getRod1Id()
    {
        $this->start();
        return $_SESSION[$this->rod1IdDbLabel];
    }

    public function getRod2Id()
    {
        $this->start();
        return $_SESSION[$this->rod2IdDbLabel];
    }

    public function getDjecaId()
    {
        $this->start();
        return $_SESSION[$this->djecaIdDbLabel];
    }

    public function start()
    {
        session_name($this->sessionName);
        if (session_id() == "") {
            session_set_cookie_params($this->sessionCookieParameters);
            session_start();
        }
    }

    public function hasKey($keyName)
    {
        $this->start();
        return isset($_SESSION[$keyName]);
    }

    public function destroy() {
        session_name($this->sessionName);
        
        if (session_id() != "") {
            session_unset();
            session_destroy();
        }
    }
}
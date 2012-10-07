<?php

namespace Kcb\Bundle\VereinsheimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Kcb\Bundle\VereinsheimBundle\Entity\MitgliedRepository")
 */
class Mitglied implements UserInterface {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column
     */
    protected $vorname = '';

    /**
     * @ORM\Column
     */
    protected $nachname = '';

    /**
     * @ORM\Column
     */
    protected $benutzername = '';

    /**
     * @ORM\Column
     */
    protected $passwort = '';

    /**
     * @ORM\Column
     */
    protected $email = '';

    /**
     * @ORM\Column
     */
    protected $handynummer = '';

    /**
     * @ORM\Column(type="array")
     */
    protected $roles = array('ROLE_MITGLIED');

    public function getSalt() {
        return 'kcb!';
    }

    public function getId() {
        return $this->id;
    }

    public function setVorname($vorname) {
        $this->vorname = $vorname;
    }

    public function getVorname() {
        return $this->vorname;
    }

    public function setNachname($nachname) {
        $this->nachname = $nachname;
    }

    public function getNachname() {
        return $this->nachname;
    }

    public function getName() {
        return $this->vorname . ' ' . $this->nachname;
    }

    public function setBenutzername($benutzername) {
        $this->benutzername = $benutzername;
    }

    public function getBenutzername() {
        return $this->benutzername;
    }

    public function setPasswort($passwort) {
        $this->passwort = $passwort;
    }

    public function getPasswort() {
        return $this->passwort;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setHandynummer($handynummer) {
        $this->handynummer = $handynummer;
    }

    public function getHandynummer() {
        return $this->handynummer;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function addRole($role) {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
    }

    public function getPassword() {
        return $this->getPasswort();
    }

    public function getUsername() {
        return $this->getBenutzername();
    }

    public function eraseCredentials() {
    }

}

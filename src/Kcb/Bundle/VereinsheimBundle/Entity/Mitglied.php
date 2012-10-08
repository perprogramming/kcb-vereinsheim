<?php

namespace Kcb\Bundle\VereinsheimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Kcb\Bundle\VereinsheimBundle\Entity\MitgliedRepository")
 * @UniqueEntity(fields={"email"}, message="Diese E-Mail-Adresse wird bereits von einem anderen Mitglied verwendet!")
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
     * @Assert\NotBlank(message="Bitte gib einen Vornamen ein!")
     */
    protected $vorname;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="Bitte gib einen Nachnamen ein!")
     */
    protected $nachname;

    /**
     * @ORM\Column
     */
    protected $passwort;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="Bitte gib eine E-Mail-Adresse ein!")
     * @Assert\Email(message="Bitte gib eine gültige E-Mail-Adresse ein!")
     */
    protected $email;

    /**
     * @ORM\Column
     * @Assert\NotBlank(message="Bitte gib eine Handynummer ein!")
     */
    protected $handynummer = '';

    /**
     * @ORM\Column(type="array")
     */
    protected $rollen = array('ROLE_MITGLIED');

    /**
     * @ORM\OneToOne(targetEntity="Anwesender", mappedBy="mitglied", cascade={"remove"})
     */
    protected $anwesender;

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

    public function getRollen() {
        return $this->rollen;
    }

    public function setRollen(array $rollen) {
        $this->rollen = $rollen;
    }

    public function addRolle($rolle) {
        if (!in_array($rolle, $this->rollen)) {
            $this->rollen[] = $rolle;
        }
    }

    public function getPassword() {
        return $this->getPasswort();
    }

    public function getUsername() {
        return $this->getEmail();
    }

    public function getRoles() {
        return $this->rollen;
    }

    public function eraseCredentials() {
    }

}

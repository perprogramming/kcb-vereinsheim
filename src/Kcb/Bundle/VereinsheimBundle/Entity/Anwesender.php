<?php

namespace Kcb\Bundle\VereinsheimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kcb\Bundle\VereinsheimBundle\Entity\Anwesender
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Kcb\Bundle\VereinsheimBundle\Entity\AnwesenderRepository")
 */
class Anwesender
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $kontaktmoeglichkeit
     *
     * @ORM\Column(name="kontaktmoeglichkeit", type="text")
     */
    private $kontaktmoeglichkeit;

    /**
     * @var string $passwort
     *
     * @ORM\Column(name="passwort", type="string", length=255)
     */
    private $passwort;

    /**
     * @var string $login
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Anwesender
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set kontaktmoeglichkeit
     *
     * @param string $kontaktmoeglichkeit
     * @return Anwesender
     */
    public function setKontaktmoeglichkeit($kontaktmoeglichkeit)
    {
        $this->kontaktmoeglichkeit = $kontaktmoeglichkeit;
    
        return $this;
    }

    /**
     * Get kontaktmoeglichkeit
     *
     * @return string 
     */
    public function getKontaktmoeglichkeit()
    {
        return $this->kontaktmoeglichkeit;
    }

    /**
     * Set passwort
     *
     * @param string $passwort
     * @return Anwesender
     */
    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
    
        return $this;
    }

    /**
     * Get passwort
     *
     * @return string 
     */
    public function getPasswort()
    {
        return $this->passwort;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Anwesender
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }
}

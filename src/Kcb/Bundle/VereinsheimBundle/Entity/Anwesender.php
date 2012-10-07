<?php

namespace Kcb\Bundle\VereinsheimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kcb\Bundle\VereinsheimBundle\Entity\Mitglied;

/**
 * Kcb\Bundle\VereinsheimBundle\Entity\Anwesender
 *
 * @ORM\Entity(repositoryClass="Kcb\Bundle\VereinsheimBundle\Entity\AnwesenderRepository")
 */
class Anwesender {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $ankunft;

    /**
     * @ORM\OneToOne(targetEntity="Mitglied")
     */
    protected $mitglied;

    public function __construct(Mitglied $mitglied) {
        $this->mitglied = $mitglied;
        $this->ankunft = new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function getAnkunft() {
        return $this->ankunft;
    }

    public function getMitglied() {
        return $this->mitglied;
    }

}

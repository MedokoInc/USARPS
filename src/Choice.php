<?php

namespace Medoko\Usarps101;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="choice")
 */
class Choice
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Choice")
     * @var Choice[] An array collection of Choice objects
     */
    private $beats;

    public function __construct()
    {
        $this->beats = new \Doctrine\Common\Collections\ArrayCollection();
    }

    // getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getBeats()
    {
        return $this->beats;
    }

    public function addBeat(Choice $beat)
    {
        $this->beats[] = $beat;
        // remove the reverse relation
        $beat->removeBeat($this);
    }

    public function removeBeat(Choice $beat)
    {
        $this->beats->removeElement($beat);
    }

    public function __toString()
    {
        return $this->name;
    }
}
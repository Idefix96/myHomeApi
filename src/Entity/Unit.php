<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitRepository")
 */
class Unit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $unit;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Text", cascade={"persist", "remove"})
     */
    private $fullName;

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getUnit() :  ? string
    {
        return $this->unit;
    }

    public function setUnit(string $unit) : self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getFullName():  ? Text
    {
        return $this->fullName;
    }

    public function setFullName( ? Text $fullName) : self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function __toString()
    {
        return $this->unit;
    }
}

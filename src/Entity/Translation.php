<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TranslationRepository")
 */
class Translation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Text", inversedBy="translations")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $translation;

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getText() :  ? Text
    {
        return $this->text;
    }

    public function setText( ? Text $text) : self
    {
        $this->text = $text;

        return $this;
    }

    public function getLanguage() :  ? Language
    {
        return $this->language;
    }

    public function setLanguage( ? Language $language) : self
    {
        $this->language = $language;

        return $this;
    }

    public function getTranslation() :  ? string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation) : self
    {
        $this->translation = $translation;

        return $this;
    }

    public function __toString()
    {
        return $this->translation . ' - ' . $this->language->getLanguage();
    }
}

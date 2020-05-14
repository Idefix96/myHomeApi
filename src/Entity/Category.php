<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Text", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $name;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId():  ? int
    {
        return $this->id;
    }

    public function getParentCategory() :  ? int
    {
        return $this->parentCategory;
    }

    public function setParentCategory( ? int $parentCategory) : self
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts() : Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getName():  ? Text
    {
        return $this->name;
    }

    public function setName(Text $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name->__toString();
    }
}

<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;



/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\CategorieRepository")
 * @ORM\EntityListeners({"adminBundle\Listener\CategorieListener"})
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     *
     */
    private $products;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     *
     * @Assert\NotBlank(message="Veuillez renseigner un titre")
     *
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     *
     */
    private $description;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Veuillez renseigner une position")
     *
     * @Assert\Type(type="integer", message="Veuillez renseigner un nombre.")
     *
     * @ORM\Column(name="position", type="string", length=255)
     *
     */
    private $position;

    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="img_categorie", type="string")
     */
    private $image;

    /**
     * Get id
     *
     * @return int
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Categorie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Categorie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Categorie
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        //die(dump($this->getPosition()));

        if ($this->getPosition() == 0 && $this->getTitle() != "Par défaut") {
            $context->buildViolation('La position "0" est réservé à la catégorie "par défaut"')
                // atPath permet d'attacher l'erreur à une propriété
                //->atPath('position')
                ->addViolation();
        }
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Categorie
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \adminBundle\Entity\Product $product
     *
     * @return Categorie
     */
    public function addProduct(\adminBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \adminBundle\Entity\Product $product
     */
    public function removeProduct(\adminBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }



    /**
     * Set image
     *
     * @param string $image
     *
     * @return Categorie
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}

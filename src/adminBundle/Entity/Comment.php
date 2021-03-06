<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Product
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="text")
     *
     */
    private $author;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     *
     */
    private $note;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateCreate", type="datetime")
     *
     */
    private $dateCreate;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="comment")
     *
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *
     */
    private $product;



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
     * Set title
     *
     * @param string $title
     *
     * @return Comment
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Comment
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return Comment
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set product
     *
     * @param \adminBundle\Entity\Product $product
     *
     * @return Comment
     */
    public function setProduct(\adminBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \adminBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

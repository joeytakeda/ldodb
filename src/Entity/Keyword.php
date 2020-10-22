<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Keyword
 *
 * @ORM\Table(name="keyword", indexes={
 *      @ORM\Index(columns={"keyword"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\KeywordRepository")
 */
class Keyword {

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=255, nullable=false)
     */
    private $keyword;

    /**
     * @var boolean
     *
     * @ORM\Column(name="preferred_keyword", type="boolean", nullable=true, options={"default": 0})
     */
    private $preferredKeyword = false;

    /**
     * @var Collection|Book[]
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="keywords")
     */
    private $books;

    /**
     * Construct Keyword object.
     *
     */
    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * Return string representation of keyword.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->keyword;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set keyword
     *
     * @param string $keyword
     *
     * @return Keyword
     */
    public function setKeyword($keyword) {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword() {
        return $this->keyword;
    }

    /**
     * Set preferredKeyword
     *
     * @param boolean $preferredKeyword
     *
     * @return Keyword
     */
    public function setPreferredKeyword($preferredKeyword) {
        $this->preferredKeyword = (bool) $preferredKeyword;

        return $this;
    }

    /**
     * Get preferredKeyword
     *
     * @return boolean
     */
    public function getPreferredKeyword() {
        return (bool) $this->preferredKeyword;
    }

    /**
     * Add book
     *
     * @param \App\Entity\Book $book
     *
     * @return Keyword
     */
    public function addBook(\App\Entity\Book $book) {
        $this->books[] = $book;

        return $this;
    }

    /**
     * Remove book
     *
     * @param \App\Entity\Book $book
     */
    public function removeBook(\App\Entity\Book $book) {
        $this->books->removeElement($book);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBooks() {
        return $this->books;
    }

}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subject
 *
 * @ORM\Table(name="subject", indexes={
 *      @ORM\Index(columns={"subject_name"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject {

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
     * @ORM\Column(name="subject_name", type="string", length=255, nullable=false)
     */
    private $subjectName;

    /**
     * @var string
     * @Assert\Url
     * @ORM\Column(name="subject_uri", type="string", length=255, nullable=true)
     */
    private $subjectUri;

    /**
     * @var Collection|Book[]
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="subjects")
     */
    private $books;

    /**
     * Construct Subject object.
     *
     */
    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * Return string representation of subjectName.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->subjectName;
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
     * Set subjectName
     *
     * @param string $subjectName
     *
     * @return Subject
     */
    public function setSubjectName($subjectName) {
        $this->subjectName = $subjectName;

        return $this;
    }

    /**
     * Get subjectName
     *
     * @return string
     */
    public function getSubjectName() {
        return $this->subjectName;
    }

    /**
     * Set subjectUri
     *
     * @param string $subjectUri
     *
     * @return Subject
     */
    public function setSubjectUri($subjectUri) {
        $this->subjectUri = $subjectUri;

        return $this;
    }

    /**
     * Get subjectUri
     *
     * @return string
     */
    public function getSubjectUri() {
        return $this->subjectUri;
    }

    /**
     * Add book
     *
     * @param \App\Entity\Book $book
     *
     * @return Subject
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

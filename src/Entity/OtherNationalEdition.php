<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtherNationalEdition
 *
 * @ORM\Table(name="other_national_edition")
 * @ORM\Entity(repositoryClass="App\Repository\OtherNationalEditionRepository")
 */
class OtherNationalEdition {

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var Book
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="otherNationalEditions")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id", nullable=false)
     */
    private $book;

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="otherNationalEditions")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id", nullable=false)
     */
    private $place;

    /**
     * @var integer
     *
     * @ORM\Column(name="publication_date", type="integer", nullable=true)
     */
    private $publicationDate;

    /**
     * Return string representation of object.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->place->__toString() . ', ' . $this->publicationDate;
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
     * Set publicationDate
     *
     * @param integer $publicationDate
     *
     * @return OtherNationalEdition
     */
    public function setPublicationDate($publicationDate) {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return integer
     */
    public function getPublicationDate() {
        return $this->publicationDate;
    }

    /**
     * Set book
     *
     * @param Book $book
     *
     * @return OtherNationalEdition
     */
    public function setBook(Book $book) {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return Book
     */
    public function getBook() {
        return $this->book;
    }

    /**
     * Set place
     *
     * @param Place $place
     *
     * @return OtherNationalEdition
     */
    public function setPlace(Place $place) {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return Place
     */
    public function getPlace() {
        return $this->place;
    }

}

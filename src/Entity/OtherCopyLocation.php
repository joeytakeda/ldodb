<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtherCopyLocation
 *
 * @ORM\Table(name="other_copy_location")
 * @ORM\Entity(repositoryClass="App\Repository\OtherCopyLocationRepository")
 */
class OtherCopyLocation {

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
     * @ORM\ManyToOne(targetEntity="Book", inversedBy="otherCopyLocations")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id", nullable=false)
     */
    private $book;

    /**
     * @var string
     *
     * @ORM\Column(name="other_copy_location", type="string", length=255, nullable=false)
     */
    private $otherCopyLocation;

    /**
     * @var integer
     *
     * @ORM\Column(name="copy_count", type="integer", nullable=false)
     */
    private $copyCount;

    /**
     * Return string representation of object.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->otherCopyLocation . ' (' . $this->copyCount . ')';
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
     * Set otherCopyLocation
     *
     * @param string $otherCopyLocation
     *
     * @return OtherCopyLocation
     */
    public function setOtherCopyLocation($otherCopyLocation) {
        $this->otherCopyLocation = $otherCopyLocation;

        return $this;
    }

    /**
     * Get otherCopyLocation
     *
     * @return string
     */
    public function getOtherCopyLocation() {
        return $this->otherCopyLocation;
    }

    /**
     * Set copyCount
     *
     * @param integer $copyCount
     *
     * @return OtherCopyLocation
     */
    public function setCopyCount($copyCount) {
        $this->copyCount = $copyCount;

        return $this;
    }

    /**
     * Get copyCount
     *
     * @return integer
     */
    public function getCopyCount() {
        return $this->copyCount;
    }

    /**
     * Set book
     *
     * @param Book $book
     *
     * @return OtherCopyLocation
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

}

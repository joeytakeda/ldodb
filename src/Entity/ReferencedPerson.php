<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ReferencedPerson
 *
 * @ORM\Table(name="referenced_person", indexes={
 *      @ORM\Index(columns={"first_name", "last_name"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\ReferencedPersonRepository")
 */
class ReferencedPerson {

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
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="birth_date", type="string", length=255, nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="death_date", type="string", length=255, nullable=true)
     */
    private $deathDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="same_as_people_entity_id", type="integer", nullable=true)
     */
    private $sameAsPeopleEntityId;

    /**
     * @var string
     *
     * @Assert\Url
     * @ORM\Column(name="referenced_person_uri", type="string", length=255, nullable=true)
     */
    private $referencedPersonUri;

    /**
     * @var Collection|Book[]
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="referencedPeople")
     */
    private $books;

    /**
     * Construct ReferencedPerson object.
     *
     */
    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * Return string representation of name.
     *
     * Formatted as lastName, firstName
     *
     * @return string
     */
    public function __toString() : string {
        return $this->lastName . ', ' . $this->firstName;
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return ReferencedPerson
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return ReferencedPerson
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Set birthDate
     *
     * @param string $birthDate
     *
     * @return ReferencedPerson
     */
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return string
     */
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * Set deathDate
     *
     * @param string $deathDate
     *
     * @return ReferencedPerson
     */
    public function setDeathDate($deathDate) {
        $this->deathDate = $deathDate;

        return $this;
    }

    /**
     * Get deathDate
     *
     * @return string
     */
    public function getDeathDate() {
        return $this->deathDate;
    }

    /**
     * Set sameAsPeopleEntityId
     *
     * @param integer $sameAsPeopleEntityId
     *
     * @return ReferencedPerson
     */
    public function setSameAsPeopleEntityId($sameAsPeopleEntityId) {
        $this->sameAsPeopleEntityId = $sameAsPeopleEntityId;

        return $this;
    }

    /**
     * Get sameAsPeopleEntityId
     *
     * @return integer
     */
    public function getSameAsPeopleEntityId() {
        return $this->sameAsPeopleEntityId;
    }

    /**
     * Set referencedPersonUri
     *
     * @param string $referencedPersonUri
     *
     * @return ReferencedPerson
     */
    public function setReferencedPersonUri($referencedPersonUri) {
        $this->referencedPersonUri = $referencedPersonUri;

        return $this;
    }

    /**
     * Get referencedPersonUri
     *
     * @return string
     */
    public function getReferencedPersonUri() {
        return $this->referencedPersonUri;
    }

    /**
     * Add book
     *
     * @param \App\Entity\Book $book
     *
     * @return ReferencedPerson
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

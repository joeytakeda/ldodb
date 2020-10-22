<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Place
 *
 * @ORM\Table(name="place", indexes={
 *      @ORM\Index(columns={"place_name"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place {

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
     * @ORM\Column(name="place_name", type="string", length=255, nullable=false)
     */
    private $placeName;

    /**
     * @var string
     *
     * @Assert\Url
     * @ORM\Column(name="place_uri", type="string", length=255, nullable=true)
     */
    private $placeUri;

    /**
     * @var boolean
     *
     * @ORM\Column(name="in_lake_district", type="boolean", nullable=true, options={"default": false})
     */
    private $inLakeDistrict = false;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=5, nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=5, nullable=true)
     */
    private $longitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="region_id", type="integer", nullable=true)
     */
    private $regionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer", nullable=true)
     */
    private $countryId;

    /**
     * @var Collection|OtherNationalEdition[]
     * @ORM\OneToMany(targetEntity="OtherNationalEdition", mappedBy="place")
     */
    private $otherNationalEditions;

    /**
     * @var Collection|ReferencedPlace
     * @ORM\OneToMany(targetEntity="ReferencedPlace", mappedBy="place")
     */
    private $referencedPlaces;

    /**
     * @var Collection|People[]
     * @ORM\OneToMany(targetEntity="People", mappedBy="birthPlace")
     */
    private $peopleBorn;

    /**
     * @var Collection|People[]
     * @ORM\OneToMany(targetEntity="People", mappedBy="deathPlace")
     */
    private $peopleDied;

    /**
     * @var Collection|Book[]
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="publicationPlaces")
     */
    private $books;

    /**
     * @var Collection|People[]
     * @ORM\ManyToMany(targetEntity="People", mappedBy="residences")
     */
    private $residents;

    /**
     * @var Collection|People[]
     * @ORM\ManyToMany(targetEntity="People", mappedBy="travels")
     */
    private $travellers;

    /**
     * Return string representation of placeName.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->placeName;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->otherNationalEditions = new ArrayCollection();
        $this->referencedPlaces = new ArrayCollection();
        $this->peopleBorn = new ArrayCollection();
        $this->peopleDied = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->residents = new ArrayCollection();
        $this->travellers = new ArrayCollection();
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
     * Set placeName
     *
     * @param string $placeName
     *
     * @return Place
     */
    public function setPlaceName($placeName) {
        $this->placeName = $placeName;

        return $this;
    }

    /**
     * Get placeName
     *
     * @return string
     */
    public function getPlaceName() {
        return $this->placeName;
    }

    /**
     * Set placeUri
     *
     * @param string $placeUri
     *
     * @return Place
     */
    public function setPlaceUri($placeUri) {
        $this->placeUri = $placeUri;

        return $this;
    }

    /**
     * Get placeUri
     *
     * @return string
     */
    public function getPlaceUri() {
        return $this->placeUri;
    }

    /**
     * Set inLakeDistrict
     *
     * @param boolean $inLakeDistrict
     *
     * @return Place
     */
    public function setInLakeDistrict($inLakeDistrict) {
        $this->inLakeDistrict = (bool) $inLakeDistrict;

        return $this;
    }

    /**
     * Get inLakeDistrict
     *
     * @return boolean
     */
    public function getInLakeDistrict() {
        return (bool) $this->inLakeDistrict;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Place
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Place
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Set regionId
     *
     * @param integer $regionId
     *
     * @return Place
     */
    public function setRegionId($regionId) {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * Get regionId
     *
     * @return integer
     */
    public function getRegionId() {
        return $this->regionId;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return Place
     */
    public function setCountryId($countryId) {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer
     */
    public function getCountryId() {
        return $this->countryId;
    }

    /**
     * Add otherNationalEdition
     *
     * @param OtherNationalEdition $otherNationalEdition
     *
     * @return Place
     */
    public function addOtherNationalEdition(OtherNationalEdition $otherNationalEdition) {
        $this->otherNationalEditions[] = $otherNationalEdition;

        return $this;
    }

    /**
     * Remove otherNationalEdition
     *
     * @param OtherNationalEdition $otherNationalEdition
     */
    public function removeOtherNationalEdition(OtherNationalEdition $otherNationalEdition) {
        $this->otherNationalEditions->removeElement($otherNationalEdition);
    }

    /**
     * Get otherNationalEditions
     *
     * @return Collection
     */
    public function getOtherNationalEditions() {
        return $this->otherNationalEditions;
    }

    /**
     * Add referencedPlace
     *
     * @param ReferencedPlace $referencedPlace
     *
     * @return Place
     */
    public function addReferencedPlace(ReferencedPlace $referencedPlace) {
        $this->referencedPlaces[] = $referencedPlace;

        return $this;
    }

    /**
     * Remove referencedPlace
     *
     * @param ReferencedPlace $referencedPlace
     */
    public function removeReferencedPlace(ReferencedPlace $referencedPlace) {
        $this->referencedPlaces->removeElement($referencedPlace);
    }

    /**
     * Get referencedPlaces
     *
     * @return Collection
     */
    public function getReferencedPlaces() {
        return $this->referencedPlaces;
    }

    /**
     * Add peopleBorn
     *
     * @param People $peopleBorn
     *
     * @return Place
     */
    public function addPeopleBorn(People $peopleBorn) {
        $this->peopleBorn[] = $peopleBorn;

        return $this;
    }

    /**
     * Remove peopleBorn
     *
     * @param People $peopleBorn
     */
    public function removePeopleBorn(People $peopleBorn) {
        $this->peopleBorn->removeElement($peopleBorn);
    }

    /**
     * Get peopleBorn
     *
     * @return Collection
     */
    public function getPeopleBorn() {
        return $this->peopleBorn;
    }

    /**
     * Add peopleDied
     *
     * @param People $peopleDied
     *
     * @return Place
     */
    public function addPeopleDied(People $peopleDied) {
        $this->peopleDied[] = $peopleDied;

        return $this;
    }

    /**
     * Remove peopleDied
     *
     * @param People $peopleDied
     */
    public function removePeopleDied(People $peopleDied) {
        $this->peopleDied->removeElement($peopleDied);
    }

    /**
     * Get peopleDied
     *
     * @return Collection
     */
    public function getPeopleDied() {
        return $this->peopleDied;
    }

    /**
     * Add book
     *
     * @param \App\Entity\Book $book
     *
     * @return Place
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

    /**
     * Add resident
     *
     * @param \App\Entity\People $resident
     *
     * @return Place
     */
    public function addResident(\App\Entity\People $resident) {
        $this->residents[] = $resident;

        return $this;
    }

    /**
     * Remove resident
     *
     * @param \App\Entity\People $resident
     */
    public function removeResident(\App\Entity\People $resident) {
        $this->residents->removeElement($resident);
    }

    /**
     * Get residents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResidents() {
        return $this->residents;
    }

    /**
     * Add traveller
     *
     * @param \App\Entity\People $traveller
     *
     * @return Place
     */
    public function addTraveller(\App\Entity\People $traveller) {
        $this->travellers[] = $traveller;

        return $this;
    }

    /**
     * Remove traveller
     *
     * @param \App\Entity\People $traveller
     */
    public function removeTraveller(\App\Entity\People $traveller) {
        $this->travellers->removeElement($traveller);
    }

    /**
     * Get travellers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravellers() {
        return $this->travellers;
    }

}

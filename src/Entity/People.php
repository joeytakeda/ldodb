<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * People
 *
 * @ORM\Table(name="people", indexes={
 *      @ORM\Index(columns={"first_name", "last_name"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\PeopleRepository")
 */
class People extends Entity {

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
     * @ORM\Column(name="other_last_name", type="string", length=255, nullable=true)
     */
    private $otherLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="other_first_name", type="string", length=255, nullable=true)
     */
    private $otherFirstName;

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
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="biographical_notes", type="text", nullable=true)
     */
    private $biographicalNotes;

    /**
     * @var string
     *
     * @ORM\Column(name="biographical_annotation", type="text", nullable=true)
     */
    private $biographicalAnnotation;

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="peopleBorn")
     * @ORM\JoinColumn(name="birth_place_id", referencedColumnName="id", nullable=true)
     */
    private $birthPlace;

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="peopleDied")
     * @ORM\JoinColumn(name="death_place_id", referencedColumnName="id", nullable=true)
     */
    private $deathPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=255, nullable=true)
     */
    private $nationality;

    /**
     * @var string
     *
     * @Assert\Url
     * @ORM\Column(name="people_uri", type="string", length=255, nullable=true)
     */
    private $peopleUri;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resident_in_LD", type="boolean", nullable=true, options={"default": false})
     */
    private $residentInLd = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resident_in_London", type="boolean", nullable=true, options={"default": false})
     */
    private $residentInLondon = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resident_outside_UK", type="boolean", nullable=true, options={"default": false})
     */
    private $residentOutsideUk = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="travel_outside_UK", type="boolean", nullable=true, options={"default": false})
     */
    private $travelOutsideUk = false;

    /**
     * @var Collection|Place[]
     * @ORM\ManyToMany(targetEntity="Place", inversedBy="travellers")
     * @ORM\JoinTable(name="places_of_travel",
     *  joinColumns={@ORM\JoinColumn(name="entity_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="place_id", referencedColumnName="id")}
     * )
     */
    private $travels;

    /**
     * @var Collection|Place[]
     * @ORM\ManyToMany(targetEntity="Place", inversedBy="residents")
     * @ORM\JoinTable(name="residence_place",
     *  joinColumns={@ORM\JoinColumn(name="entity_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="place_id", referencedColumnName="id")}
     * )
     */
    private $residences;

    /**
     * @var Collection|Role[]
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="people")
     * @ORM\JoinTable(name="people_role",
     *  joinColumns={@ORM\JoinColumn(name="entity_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * Return string representation of name.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->lastName . ', ' . $this->firstName;
    }

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->travels = new ArrayCollection();
        $this->residences = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->contributions = new ArrayCollection();
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return People
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
     * @return People
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
     * Set otherLastName
     *
     * @param string $otherLastName
     *
     * @return People
     */
    public function setOtherLastName($otherLastName) {
        $this->otherLastName = $otherLastName;

        return $this;
    }

    /**
     * Get otherLastName
     *
     * @return string
     */
    public function getOtherLastName() {
        return $this->otherLastName;
    }

    /**
     * Set otherFirstName
     *
     * @param string $otherFirstName
     *
     * @return People
     */
    public function setOtherFirstName($otherFirstName) {
        $this->otherFirstName = $otherFirstName;

        return $this;
    }

    /**
     * Get otherFirstName
     *
     * @return string
     */
    public function getOtherFirstName() {
        return $this->otherFirstName;
    }

    /**
     * Set birthDate
     *
     * @param string $birthDate
     *
     * @return People
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
     * @return People
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
     * Set gender
     *
     * @param string $gender
     *
     * @return People
     */
    public function setGender($gender) {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set biographicalNotes
     *
     * @param string $biographicalNotes
     *
     * @return People
     */
    public function setBiographicalNotes($biographicalNotes) {
        $this->biographicalNotes = $biographicalNotes;

        return $this;
    }

    /**
     * Get biographicalNotes
     *
     * @return string
     */
    public function getBiographicalNotes() {
        return $this->biographicalNotes;
    }

    /**
     * Set biographicalAnnotation
     *
     * @param string $biographicalAnnotation
     *
     * @return People
     */
    public function setBiographicalAnnotation($biographicalAnnotation) {
        $this->biographicalAnnotation = $biographicalAnnotation;

        return $this;
    }

    /**
     * Get biographicalAnnotation
     *
     * @return string
     */
    public function getBiographicalAnnotation() {
        return $this->biographicalAnnotation;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return People
     */
    public function setNationality($nationality) {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality() {
        return $this->nationality;
    }

    /**
     * Set peopleUri
     *
     * @param string $peopleUri
     *
     * @return People
     */
    public function setPeopleUri($peopleUri) {
        $this->peopleUri = $peopleUri;

        return $this;
    }

    /**
     * Get peopleUri
     *
     * @return string
     */
    public function getPeopleUri() {
        return $this->peopleUri;
    }

    /**
     * Set residentInLd
     *
     * @param boolean $residentInLd
     *
     * @return People
     */
    public function setResidentInLd($residentInLd) {
        $this->residentInLd = (bool) $residentInLd;

        return $this;
    }

    /**
     * Get residentInLd
     *
     * @return boolean
     */
    public function getResidentInLd() {
        return (bool) $this->residentInLd;
    }

    /**
     * Set residentInLondon
     *
     * @param boolean $residentInLondon
     *
     * @return People
     */
    public function setResidentInLondon($residentInLondon) {
        $this->residentInLondon = (bool) $residentInLondon;

        return $this;
    }

    /**
     * Get residentInLondon
     *
     * @return boolean
     */
    public function getResidentInLondon() {
        return (bool) $this->residentInLondon;
    }

    /**
     * Set residentOutsideUk
     *
     * @param boolean $residentOutsideUk
     *
     * @return People
     */
    public function setResidentOutsideUk($residentOutsideUk) {
        $this->residentOutsideUk = (bool) $residentOutsideUk;

        return $this;
    }

    /**
     * Get residentOutsideUk
     *
     * @return boolean
     */
    public function getResidentOutsideUk() {
        return (bool) $this->residentOutsideUk;
    }

    /**
     * Set travelOutsideUk
     *
     * @param boolean $travelOutsideUk
     *
     * @return People
     */
    public function setTravelOutsideUk($travelOutsideUk) {
        $this->travelOutsideUk = (bool) $travelOutsideUk;

        return $this;
    }

    /**
     * Get travelOutsideUk
     *
     * @return boolean
     */
    public function getTravelOutsideUk() {
        return (bool) $this->travelOutsideUk;
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
     * Set birthPlace
     *
     * @param Place $birthPlace
     *
     * @return People
     */
    public function setBirthPlace(Place $birthPlace = null) {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    /**
     * Get birthPlace
     *
     * @return Place
     */
    public function getBirthPlace() {
        return $this->birthPlace;
    }

    /**
     * Set deathPlace
     *
     * @param Place $deathPlace
     *
     * @return People
     */
    public function setDeathPlace(Place $deathPlace = null) {
        $this->deathPlace = $deathPlace;

        return $this;
    }

    /**
     * Get deathPlace
     *
     * @return Place
     */
    public function getDeathPlace() {
        return $this->deathPlace;
    }

    /**
     * Add travel
     *
     * @param Place $travel
     *
     * @return People
     */
    public function addTravel(Place $travel) {
        $this->travels[] = $travel;

        return $this;
    }

    /**
     * Remove travel
     *
     * @param Place $travel
     */
    public function removeTravel(Place $travel) {
        $this->travels->removeElement($travel);
    }

    /**
     * Get travels
     *
     * @return Collection
     */
    public function getTravels() {
        return $this->travels;
    }

    /**
     * Add residence
     *
     * @param Place $residence
     *
     * @return People
     */
    public function addResidence(Place $residence) {
        $this->residences[] = $residence;

        return $this;
    }

    /**
     * Remove residence
     *
     * @param Place $residence
     */
    public function removeResidence(Place $residence) {
        $this->residences->removeElement($residence);
    }

    /**
     * Get residences
     *
     * @return Collection
     */
    public function getResidences() {
        return $this->residences;
    }

    /**
     * Add role
     *
     * @param Role $role
     *
     * @return People
     */
    public function addRole(Role $role) {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param Role $role
     */
    public function removeRole(Role $role) {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return Collection
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Add contribution
     *
     * @param Contribution $contribution
     *
     * @return People
     */
    public function addContribution(Contribution $contribution) {
        $this->contributions[] = $contribution;

        return $this;
    }

    /**
     * Remove contribution
     *
     * @param Contribution $contribution
     */
    public function removeContribution(Contribution $contribution) {
        $this->contributions->removeElement($contribution);
    }

    /**
     * Get contributions
     *
     * @return Collection
     */
    public function getContributions() {
        return $this->contributions;
    }

    /**
     * {@inheritdoc}
     *
     * @return constant
     */
    public function getType() {
        return Entity::PER_TYPE;
    }

}

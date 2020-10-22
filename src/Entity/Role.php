<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role", indexes={
 *      @ORM\Index(columns={"role_name"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role {

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
     * @ORM\Column(name="role_name", type="string", length=255, nullable=false)
     */
    private $roleName;

    /**
     * @var Collection|People[]
     * @ORM\ManyToMany(targetEntity="People", mappedBy="roles")
     */
    private $people;

    /**
     * Construct Role object.
     *
     */
    public function __construct() {
        $this->people = new ArrayCollection();
    }

    /**
     * Return string representation of roleName.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->roleName;
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
     * Set roleName
     *
     * @param string $roleName
     *
     * @return Role
     */
    public function setRoleName($roleName) {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName
     *
     * @return string
     */
    public function getRoleName() {
        return $this->roleName;
    }

    /**
     * Add person
     *
     * @param People $person
     *
     * @return Role
     */
    public function addPerson(People $person) {
        $this->people[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param People $person
     */
    public function removePerson(People $person) {
        $this->people->removeElement($person);
    }

    /**
     * Get people
     *
     * @return Collection
     */
    public function getPeople() {
        return $this->people;
    }

}

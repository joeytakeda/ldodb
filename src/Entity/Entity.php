<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="entity")
 * @ORM\Entity(repositoryClass="App\Repository\EntityRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="entity_type", type="string", length=3)
 * @ORM\DiscriminatorMap({
 *      "PER" = "People",
 *      "ORG" = "Organization"
 * })
 */
abstract class Entity {

    const PER_TYPE = 'PER';
    const ORG_TYPE = 'ORG';

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var Collection|Contribution[]
     * @ORM\OneToMany(targetEntity="Contribution", mappedBy="entity")
     */
    protected $contributions;

    /**
     * Return string representation of object.
     */
    abstract public function __toString() : string;

    /**
     * Return one of the class constants representing the type.
     */
    abstract public function getType();

    public function asString() {
        return $this->__toString();
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->contributions = new ArrayCollection();
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
     * Add contribution
     *
     * @param Contribution $contribution
     *
     * @return Entity
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

}

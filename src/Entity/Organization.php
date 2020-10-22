<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Organization
 *
 * @ORM\Table(name="organization", indexes={
 *      @ORM\Index(columns={"organization_name"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization extends Entity {

    /**
     * @var string
     *
     * @ORM\Column(name="organization_name", type="string", length=255, nullable=false)
     */
    private $organizationName;

    /**
     * @var string
     *
     * @Assert\Url
     * @ORM\Column(name="organization_uri", type="string", length=255, nullable=true)
     */
    private $organizationUri;

    /**
     * @var string
     *
     * @ORM\Column(name="organization_notes", type="text", nullable=true)
     */
    private $organizationNotes;

    /**
     * Return string representation of organizationName.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->organizationName;
    }

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->contributions = new ArrayCollection();
    }

    /**
     * Set organizationName
     *
     * @param string $organizationName
     *
     * @return Organization
     */
    public function setOrganizationName($organizationName) {
        $this->organizationName = $organizationName;

        return $this;
    }

    /**
     * Get organizationName
     *
     * @return string
     */
    public function getOrganizationName() {
        return $this->organizationName;
    }

    /**
     * Set organizationUri
     *
     * @param string $organizationUri
     *
     * @return Organization
     */
    public function setOrganizationUri($organizationUri) {
        $this->organizationUri = $organizationUri;

        return $this;
    }

    /**
     * Get organizationUri
     *
     * @return string
     */
    public function getOrganizationUri() {
        return $this->organizationUri;
    }

    /**
     * Set organizationNotes
     *
     * @param string $organizationNotes
     *
     * @return Organization
     */
    public function setOrganizationNotes($organizationNotes) {
        $this->organizationNotes = $organizationNotes;

        return $this;
    }

    /**
     * Get organizationNotes
     *
     * @return string
     */
    public function getOrganizationNotes() {
        return $this->organizationNotes;
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
     * @return Organization
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
        return Entity::ORG_TYPE;
    }

}

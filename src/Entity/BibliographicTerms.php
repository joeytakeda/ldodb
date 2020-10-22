<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BibliographicTerms
 *
 * @ORM\Table(name="bibliographic_terms")
 * @ORM\Entity(repositoryClass="App\Repository\BibliographicTermsRepository")
 */
class BibliographicTerms {

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
     * @ORM\Column(name="bibliographic_term", type="string", length=255, nullable=false)
     */
    private $bibliographicTerm;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_for_format", type="boolean", nullable=true)
     */
    private $useForFormat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_for_photographs", type="boolean", nullable=true)
     */
    private $useForPhotographs;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_for_illustrations", type="boolean", nullable=true)
     */
    private $useForIllustrations;

    /**
     * Return a string representation of bibliographicTerm.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->bibliographicTerm;
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
     * Set bibliographicTerm
     *
     * @param string $bibliographicTerm
     *
     * @return BibliographicTerms
     */
    public function setBibliographicTerm($bibliographicTerm) {
        $this->bibliographicTerm = $bibliographicTerm;

        return $this;
    }

    /**
     * Get bibliographicTerm
     *
     * @return string
     */
    public function getBibliographicTerm() {
        return $this->bibliographicTerm;
    }

    /**
     * Set useForFormat
     *
     * @param boolean $useForFormat
     *
     * @return BibliographicTerms
     */
    public function setUseForFormat($useForFormat) {
        $this->useForFormat = $useForFormat;

        return $this;
    }

    /**
     * Get useForFormat
     *
     * @return boolean
     */
    public function getUseForFormat() {
        return $this->useForFormat;
    }

    /**
     * Set useForPhotographs
     *
     * @param boolean $useForPhotographs
     *
     * @return BibliographicTerms
     */
    public function setUseForPhotographs($useForPhotographs) {
        $this->useForPhotographs = $useForPhotographs;

        return $this;
    }

    /**
     * Get useForPhotographs
     *
     * @return boolean
     */
    public function getUseForPhotographs() {
        return $this->useForPhotographs;
    }

    /**
     * Set useForIllustrations
     *
     * @param boolean $useForIllustrations
     *
     * @return BibliographicTerms
     */
    public function setUseForIllustrations($useForIllustrations) {
        $this->useForIllustrations = $useForIllustrations;

        return $this;
    }

    /**
     * Get useForIllustrations
     *
     * @return boolean
     */
    public function getUseForIllustrations() {
        return $this->useForIllustrations;
    }

}

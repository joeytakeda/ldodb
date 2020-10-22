<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Book
 *
 * @ORM\Table(name="book", indexes={
 *      @ORM\Index(columns={"title"}, flags={"fulltext"}),
 * })
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book {

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
     * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="call_number", type="string", length=255, nullable=true)
     */
    private $callNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="short_title", type="text", nullable=true)
     */
    private $shortTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="series_title", type="text", nullable=true)
     */
    private $seriesTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="title_page_quotation", type="text", nullable=true)
     */
    private $titlePageQuotation;

    /**
     * @var string
     *
     * @ORM\Column(name="dedication", type="text", nullable=true)
     */
    private $dedication;

    /**
     * @var string
     *
     * @ORM\Column(name="imprint", type="text", nullable=true)
     */
    private $imprint;

    /**
     * @var string
     *
     * @ORM\Column(name="edition", type="string", length=20, nullable=true)
     */
    private $edition;

    /**
     * @var string
     *
     * @ORM\Column(name="publication_date", type="string", length=20, nullable=true)
     */
    private $publicationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="volumes", type="integer", nullable=true, options={"default": 1})
     */
    private $volumes = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="pages", type="integer", nullable=true)
     */
    private $pages;

    /**
     * @var integer
     *
     * @ORM\Column(name="copies", type="integer", nullable=true, options={"default": 1})
     */
    private $copies = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="SFU_cat_orig_bib", type="text", nullable=true)
     */
    private $sfuCatOrigBib;

    /**
     * @var string
     * @Assert\Url()
     *
     * @ORM\Column(name="sfu_digital_copy", type="string", length=255, nullable=true)
     */
    private $sfuDigitalCopy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="original_bib", type="boolean", nullable=true, options={"default": 0})
     */
    private $originalBib = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="bicknell_number", type="string", length=10, nullable=true)
     */
    private $bicknellNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="healey_number", type="string", length=10, nullable=true)
     */
    private $healeyNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="reed_number", type="string", length=10, nullable=true)
     */
    private $reedNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public_domain", type="boolean", nullable=true, options={"default": 0})
     */
    private $publicDomain = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="british_edition", type="string", length=255, nullable=true)
     */
    private $britishEdition;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="print_run", type="integer", nullable=true)
     */
    private $printRun;

    /**
     * @var string
     *
     * @Assert\Url
     * @ORM\Column(name="book_uri", type="string", length=255, nullable=true)
     */
    private $bookUri;

    /**
     * @var string
     *
     * @Assert\Url
     * @ORM\Column(name="digital_object_url", type="text", nullable=true)
     */
    private $digitalObjectUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="bibliographic_notes", type="text", nullable=true)
     */
    private $bibliographicNotes;

    /**
     * @var string
     *
     * @ORM\Column(name="critical_annotation", type="text", nullable=true)
     */
    private $criticalAnnotation;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255, nullable=true)
     */
    private $format;

    /**
     * @var integer
     *
     * @ORM\Column(name="plate_count", type="integer", nullable=true, options={"default": 0})
     */
    private $plateCount = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="map_count", type="integer", nullable=true, options={"default": 0})
     */
    private $mapCount = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="illustrations", type="string", length=255, nullable=true)
     */
    private $illustrations;

    /**
     * @var string
     *
     * @ORM\Column(name="photographs", type="string", length=255, nullable=true)
     */
    private $photographs;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tables", type="boolean", nullable=true)
     */
    private $tables;

    /**
     * @var string
     *
     * @ORM\Column(name="binding_colour", type="text", nullable=true)
     */
    private $bindingColour;

    /**
     * @var Collection|OtherNationalEdition[]
     * @ORM\OneToMany(targetEntity="OtherNationalEdition", mappedBy="book")
     */
    private $otherNationalEditions;

    /**
     * @var Collection|ReferencedPlace[]
     * @ORM\OneToMany(targetEntity="ReferencedPlace", mappedBy="book")
     */
    private $referencedPlaces;

    /**
     * @var Collection|OtherCopyLocation[]
     * @ORM\OneToMany(targetEntity="OtherCopyLocation", mappedBy="book")
     */
    private $otherCopyLocations;

    /**
     * @var Collection|Contribution
     * @ORM\OneToMany(targetEntity="Contribution", mappedBy="book", cascade={"persist","remove"})
     */
    private $contributions;

    /**
     * @var Collection|Genre[]
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="books")
     * @ORM\JoinTable(name="book_genre",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */
    private $genres;

    /**
     * @var Collection|ReferencedPerson[]
     * @ORM\ManyToMany(targetEntity="ReferencedPerson", inversedBy="books")
     * @ORM\JoinTable(name="reference",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="people_id", referencedColumnName="id")}
     * )
     */
    private $referencedPeople;

    /**
     * @var Collection|PlateType[]
     * @ORM\ManyToMany(targetEntity="PlateType", inversedBy="books")
     * @ORM\JoinTable(name="book_plate_type",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="plate_type_id", referencedColumnName="id")}
     * )
     */
    private $plateTypes;

    /**
     * @var Collection|MapType[]
     * @ORM\ManyToMany(targetEntity="MapType", inversedBy="books")
     * @ORM\JoinTable(name="book_map_type",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="map_type_id", referencedColumnName="id")}
     * )
     */
    private $mapTypes;

    /**
     * @var Collection|Subject[]
     * @ORM\ManyToMany(targetEntity="Subject", inversedBy="books")
     * @ORM\JoinTable(name="book_subject",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="subject_id", referencedColumnName="id")}
     * )
     */
    private $subjects;

    /**
     * @var Collection|MapSize[]
     * @ORM\ManyToMany(targetEntity="MapSize", inversedBy="books")
     * @ORM\JoinTable(name="book_map_size",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="map_size_id", referencedColumnName="id")}
     * )
     */
    private $mapSizes;

    /**
     * @var Collection|SubjectHeading[]
     * @ORM\ManyToMany(targetEntity="SubjectHeading", inversedBy="books")
     * @ORM\JoinTable(name="subject_heading_book",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="subject_heading_id", referencedColumnName="id")}
     * )
     */
    private $subjectHeadings;

    /**
     * @var Collection|BindingFeature[]
     * @ORM\ManyToMany(targetEntity="BindingFeature", inversedBy="books")
     * @ORM\JoinTable(name="book_binding_feature",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="binding_feature_id", referencedColumnName="id")}
     * )
     */
    private $bindingFeatures;

    /**
     * @var Collection|Keyword[]
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="books")
     * @ORM\JoinTable(name="book_keyword",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="keyword_id", referencedColumnName="id")}
     * )
     */
    private $keywords;

    /**
     * @var Collection|DigitalCopyHolder[]
     * @ORM\ManyToMany(targetEntity="DigitalCopyHolder", inversedBy="books")
     * @ORM\JoinTable(name="digital_copies_other_institutions",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="organization_id", referencedColumnName="id")}
     * )
     */
    private $digitalCopyHolders;

    /**
     * @var Collection|Place[]
     * @ORM\ManyToMany(targetEntity="Place", inversedBy="books")
     * @ORM\JoinTable(name="publication_place",
     *  joinColumns={@ORM\JoinColumn(name="book_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="place_id", referencedColumnName="id")}
     * )
     */
    private $publicationPlaces;

    /**
     * Return string representation of title.
     *
     * @return string
     */
    public function __toString() : string {
        return $this->title;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->otherNationalEditions = new ArrayCollection();
        $this->referencedPlaces = new ArrayCollection();
        $this->otherCopyLocations = new ArrayCollection();
        $this->contributions = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->referencedPeople = new ArrayCollection();
        $this->plateTypes = new ArrayCollection();
        $this->mapTypes = new ArrayCollection();
        $this->subjects = new ArrayCollection();
        $this->mapSizes = new ArrayCollection();
        $this->subjectHeadings = new ArrayCollection();
        $this->bindingFeatures = new ArrayCollection();
        $this->keywords = new ArrayCollection();
        $this->digitalCopyHolders = new ArrayCollection();
        $this->publicationPlaces = new ArrayCollection();
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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Book
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Set callNumber
     *
     * @param string $callNumber
     *
     * @return Book
     */
    public function setCallNumber($callNumber) {
        $this->callNumber = $callNumber;

        return $this;
    }

    /**
     * Get callNumber
     *
     * @return string
     */
    public function getCallNumber() {
        return $this->callNumber;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Book
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set shortTitle
     *
     * @param string $shortTitle
     *
     * @return Book
     */
    public function setShortTitle($shortTitle) {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * Get shortTitle
     *
     * @return string
     */
    public function getShortTitle() {
        return $this->shortTitle;
    }

    /**
     * Set seriesTitle
     *
     * @param string $seriesTitle
     *
     * @return Book
     */
    public function setSeriesTitle($seriesTitle) {
        $this->seriesTitle = $seriesTitle;

        return $this;
    }

    /**
     * Get seriesTitle
     *
     * @return string
     */
    public function getSeriesTitle() {
        return $this->seriesTitle;
    }

    /**
     * Set titlePageQuotation
     *
     * @param string $titlePageQuotation
     *
     * @return Book
     */
    public function setTitlePageQuotation($titlePageQuotation) {
        $this->titlePageQuotation = $titlePageQuotation;

        return $this;
    }

    /**
     * Get titlePageQuotation
     *
     * @return string
     */
    public function getTitlePageQuotation() {
        return $this->titlePageQuotation;
    }

    /**
     * Set dedication
     *
     * @param string $dedication
     *
     * @return Book
     */
    public function setDedication($dedication) {
        $this->dedication = $dedication;

        return $this;
    }

    /**
     * Get dedication
     *
     * @return string
     */
    public function getDedication() {
        return $this->dedication;
    }

    /**
     * Set imprint
     *
     * @param string $imprint
     *
     * @return Book
     */
    public function setImprint($imprint) {
        $this->imprint = $imprint;

        return $this;
    }

    /**
     * Get imprint
     *
     * @return string
     */
    public function getImprint() {
        return $this->imprint;
    }

    /**
     * Set edition
     *
     * @param string $edition
     *
     * @return Book
     */
    public function setEdition($edition) {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition
     *
     * @return string
     */
    public function getEdition() {
        return $this->edition;
    }

    /**
     * Set publicationDate
     *
     * @param string $publicationDate
     *
     * @return Book
     */
    public function setPublicationDate($publicationDate) {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return string
     */
    public function getPublicationDate() {
        return $this->publicationDate;
    }

    /**
     * Set volumes
     *
     * @param integer $volumes
     *
     * @return Book
     */
    public function setVolumes($volumes) {
        $this->volumes = $volumes;

        return $this;
    }

    /**
     * Get volumes
     *
     * @return integer
     */
    public function getVolumes() {
        return $this->volumes;
    }

    /**
     * Set pages
     *
     * @param integer $pages
     *
     * @return Book
     */
    public function setPages($pages) {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages
     *
     * @return integer
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * Set copies
     *
     * @param integer $copies
     *
     * @return Book
     */
    public function setCopies($copies) {
        $this->copies = $copies;

        return $this;
    }

    /**
     * Get copies
     *
     * @return integer
     */
    public function getCopies() {
        return $this->copies;
    }

    /**
     * Set sfuCatOrigBib
     *
     * @param string $sfuCatOrigBib
     *
     * @return Book
     */
    public function setSfuCatOrigBib($sfuCatOrigBib) {
        $this->sfuCatOrigBib = $sfuCatOrigBib;

        return $this;
    }

    /**
     * Get sfuCatOrigBib
     *
     * @return string
     */
    public function getSfuCatOrigBib() {
        return $this->sfuCatOrigBib;
    }

    /**
     * Set originalBib
     *
     * @param boolean $originalBib
     *
     * @return Book
     */
    public function setOriginalBib($originalBib) {
        $this->originalBib = (bool) $originalBib;

        return $this;
    }

    /**
     * Get originalBib
     *
     * @return boolean
     */
    public function getOriginalBib() {
        return (bool) $this->originalBib;
    }

    /**
     * Set bicknellNumber
     *
     * @param string $bicknellNumber
     *
     * @return Book
     */
    public function setBicknellNumber($bicknellNumber) {
        $this->bicknellNumber = $bicknellNumber;

        return $this;
    }

    /**
     * Get bicknellNumber
     *
     * @return string
     */
    public function getBicknellNumber() {
        return $this->bicknellNumber;
    }

    /**
     * Set healeyNumber
     *
     * @param string $healeyNumber
     *
     * @return Book
     */
    public function setHealeyNumber($healeyNumber) {
        $this->healeyNumber = $healeyNumber;

        return $this;
    }

    /**
     * Get healeyNumber
     *
     * @return string
     */
    public function getHealeyNumber() {
        return $this->healeyNumber;
    }

    /**
     * Set reedNumber
     *
     * @param string $reedNumber
     *
     * @return Book
     */
    public function setReedNumber($reedNumber) {
        $this->reedNumber = $reedNumber;

        return $this;
    }

    /**
     * Get reedNumber
     *
     * @return string
     */
    public function getReedNumber() {
        return $this->reedNumber;
    }

    /**
     * Set publicDomain
     *
     * @param boolean $publicDomain
     *
     * @return Book
     */
    public function setPublicDomain($publicDomain) {
        $this->publicDomain = (bool) $publicDomain;

        return $this;
    }

    /**
     * Get publicDomain
     *
     * @return boolean
     */
    public function getPublicDomain() {
        return (bool) $this->publicDomain;
    }

    /**
     * Set britishEdition
     *
     * @param string $britishEdition
     *
     * @return Book
     */
    public function setBritishEdition($britishEdition) {
        $this->britishEdition = $britishEdition;

        return $this;
    }

    /**
     * Get britishEdition
     *
     * @return string
     */
    public function getBritishEdition() {
        return $this->britishEdition;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Book
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set printRun
     *
     * @param integer $printRun
     *
     * @return Book
     */
    public function setPrintRun($printRun) {
        $this->printRun = $printRun;

        return $this;
    }

    /**
     * Get printRun
     *
     * @return integer
     */
    public function getPrintRun() {
        return $this->printRun;
    }

    /**
     * Set bookUri
     *
     * @param string $bookUri
     *
     * @return Book
     */
    public function setBookUri($bookUri) {
        $this->bookUri = $bookUri;

        return $this;
    }

    /**
     * Get bookUri
     *
     * @return string
     */
    public function getBookUri() {
        return $this->bookUri;
    }

    /**
     * Set digitalObjectUrl
     *
     * @param string $digitalObjectUrl
     *
     * @return Book
     */
    public function setDigitalObjectUrl($digitalObjectUrl) {
        $this->digitalObjectUrl = $digitalObjectUrl;

        return $this;
    }

    /**
     * Get digitalObjectUrl
     *
     * @return string
     */
    public function getDigitalObjectUrl() {
        return $this->digitalObjectUrl;
    }

    /**
     * Set bibliographicNotes
     *
     * @param string $bibliographicNotes
     *
     * @return Book
     */
    public function setBibliographicNotes($bibliographicNotes) {
        $this->bibliographicNotes = $bibliographicNotes;

        return $this;
    }

    /**
     * Get bibliographicNotes
     *
     * @return string
     */
    public function getBibliographicNotes() {
        return $this->bibliographicNotes;
    }

    /**
     * Set criticalAnnotation
     *
     * @param string $criticalAnnotation
     *
     * @return Book
     */
    public function setCriticalAnnotation($criticalAnnotation) {
        $this->criticalAnnotation = $criticalAnnotation;

        return $this;
    }

    /**
     * Get criticalAnnotation
     *
     * @return string
     */
    public function getCriticalAnnotation() {
        return $this->criticalAnnotation;
    }

    /**
     * Set format
     *
     * @param string $format
     *
     * @return Book
     */
    public function setFormat($format) {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat() {
        return $this->format;
    }

    /**
     * Set plateCount
     *
     * @param integer $plateCount
     *
     * @return Book
     */
    public function setPlateCount($plateCount) {
        $this->plateCount = $plateCount;

        return $this;
    }

    /**
     * Get plateCount
     *
     * @return integer
     */
    public function getPlateCount() {
        return $this->plateCount;
    }

    /**
     * Set mapCount
     *
     * @param integer $mapCount
     *
     * @return Book
     */
    public function setMapCount($mapCount) {
        $this->mapCount = $mapCount;

        return $this;
    }

    /**
     * Get mapCount
     *
     * @return integer
     */
    public function getMapCount() {
        return $this->mapCount;
    }

    /**
     * Set illustrations
     *
     * @param string $illustrations
     *
     * @return Book
     */
    public function setIllustrations($illustrations) {
        $this->illustrations = $illustrations;

        return $this;
    }

    /**
     * Get illustrations
     *
     * @return string
     */
    public function getIllustrations() {
        return $this->illustrations;
    }

    /**
     * Set photographs
     *
     * @param string $photographs
     *
     * @return Book
     */
    public function setPhotographs($photographs) {
        $this->photographs = $photographs;

        return $this;
    }

    /**
     * Get photographs
     *
     * @return string
     */
    public function getPhotographs() {
        return $this->photographs;
    }

    /**
     * Set tables
     *
     * @param boolean $tables
     *
     * @return Book
     */
    public function setTables($tables) {
        $this->tables = $tables;

        return $this;
    }

    /**
     * Get tables
     *
     * @return boolean
     */
    public function getTables() {
        return $this->tables;
    }

    /**
     * Set bindingColour
     *
     * @param string $bindingColour
     *
     * @return Book
     */
    public function setBindingColour($bindingColour) {
        $this->bindingColour = $bindingColour;

        return $this;
    }

    /**
     * Get bindingColour
     *
     * @return string
     */
    public function getBindingColour() {
        return $this->bindingColour;
    }

    /**
     * Add otherNationalEdition
     *
     * @param OtherNationalEdition $otherNationalEdition
     *
     * @return Book
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
     * @return Book
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
     * Add otherCopyLocation
     *
     * @param OtherCopyLocation $otherCopyLocation
     *
     * @return Book
     */
    public function addOtherCopyLocation(OtherCopyLocation $otherCopyLocation) {
        $this->otherCopyLocations[] = $otherCopyLocation;

        return $this;
    }

    /**
     * Remove otherCopyLocation
     *
     * @param OtherCopyLocation $otherCopyLocation
     */
    public function removeOtherCopyLocation(OtherCopyLocation $otherCopyLocation) {
        $this->otherCopyLocations->removeElement($otherCopyLocation);
    }

    /**
     * Get otherCopyLocations
     *
     * @return Collection
     */
    public function getOtherCopyLocations() {
        return $this->otherCopyLocations;
    }

    /**
     * Add contribution
     *
     * @param Contribution $contribution
     *
     * @return Book
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
     * Get contributions, optionally flitered by task
     *
     * @param string $task
     *
     * @return Collection
     */
    public function getContributions($task = null) {
        if ($task === null) {
            return $this->contributions;
        }
        return $this->contributions->filter(function(Contribution $contribution) use ($task) {
                    return $contribution->getTask()->getTaskName() === $task;
                });
    }

    /**
     * Add genre
     *
     * @param Genre $genre
     *
     * @return Book
     */
    public function addGenre(Genre $genre) {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param Genre $genre
     */
    public function removeGenre(Genre $genre) {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return Collection
     */
    public function getGenres() {
        return $this->genres;
    }

    /**
     * Add referencedPerson
     *
     * @param ReferencedPerson $referencedPerson
     *
     * @return Book
     */
    public function addReferencedPerson(ReferencedPerson $referencedPerson) {
        $this->referencedPeople[] = $referencedPerson;

        return $this;
    }

    /**
     * Remove referencedPerson
     *
     * @param ReferencedPerson $referencedPerson
     */
    public function removeReferencedPerson(ReferencedPerson $referencedPerson) {
        $this->referencedPeople->removeElement($referencedPerson);
    }

    /**
     * Get referencedPeople
     *
     * @return Collection
     */
    public function getReferencedPeople() {
        return $this->referencedPeople;
    }

    /**
     * Add plateType
     *
     * @param PlateType $plateType
     *
     * @return Book
     */
    public function addPlateType(PlateType $plateType) {
        $this->plateTypes[] = $plateType;

        return $this;
    }

    /**
     * Remove plateType
     *
     * @param PlateType $plateType
     */
    public function removePlateType(PlateType $plateType) {
        $this->plateTypes->removeElement($plateType);
    }

    /**
     * Get plateTypes
     *
     * @return Collection
     */
    public function getPlateTypes() {
        return $this->plateTypes;
    }

    /**
     * Add mapType
     *
     * @param MapType $mapType
     *
     * @return Book
     */
    public function addMapType(MapType $mapType) {
        $this->mapTypes[] = $mapType;

        return $this;
    }

    /**
     * Remove mapType
     *
     * @param MapType $mapType
     */
    public function removeMapType(MapType $mapType) {
        $this->mapTypes->removeElement($mapType);
    }

    /**
     * Get mapTypes
     *
     * @return Collection
     */
    public function getMapTypes() {
        return $this->mapTypes;
    }

    /**
     * Add subject
     *
     * @param Subject $subject
     *
     * @return Book
     */
    public function addSubject(Subject $subject) {
        $this->subjects[] = $subject;

        return $this;
    }

    /**
     * Remove subject
     *
     * @param Subject $subject
     */
    public function removeSubject(Subject $subject) {
        $this->subjects->removeElement($subject);
    }

    /**
     * Get subjects
     *
     * @return Collection
     */
    public function getSubjects() {
        return $this->subjects;
    }

    /**
     * Add mapSize
     *
     * @param MapSize $mapSize
     *
     * @return Book
     */
    public function addMapSize(MapSize $mapSize) {
        $this->mapSizes[] = $mapSize;

        return $this;
    }

    /**
     * Remove mapSize
     *
     * @param MapSize $mapSize
     */
    public function removeMapSize(MapSize $mapSize) {
        $this->mapSizes->removeElement($mapSize);
    }

    /**
     * Get mapSizes
     *
     * @return Collection
     */
    public function getMapSizes() {
        return $this->mapSizes;
    }

    /**
     * Add subjectHeading
     *
     * @param SubjectHeading $subjectHeading
     *
     * @return Book
     */
    public function addSubjectHeading(SubjectHeading $subjectHeading) {
        $this->subjectHeadings[] = $subjectHeading;

        return $this;
    }

    /**
     * Remove subjectHeading
     *
     * @param SubjectHeading $subjectHeading
     */
    public function removeSubjectHeading(SubjectHeading $subjectHeading) {
        $this->subjectHeadings->removeElement($subjectHeading);
    }

    /**
     * Get subjectHeadings
     *
     * @return Collection
     */
    public function getSubjectHeadings() {
        return $this->subjectHeadings;
    }

    /**
     * Add bindingFeature
     *
     * @param BindingFeature $bindingFeature
     *
     * @return Book
     */
    public function addBindingFeature(BindingFeature $bindingFeature) {
        $this->bindingFeatures[] = $bindingFeature;

        return $this;
    }

    /**
     * Remove bindingFeature
     *
     * @param BindingFeature $bindingFeature
     */
    public function removeBindingFeature(BindingFeature $bindingFeature) {
        $this->bindingFeatures->removeElement($bindingFeature);
    }

    /**
     * Get bindingFeatures
     *
     * @return Collection
     */
    public function getBindingFeatures() {
        return $this->bindingFeatures;
    }

    /**
     * Add keyword
     *
     * @param Keyword $keyword
     *
     * @return Book
     */
    public function addKeyword(Keyword $keyword) {
        $this->keywords[] = $keyword;

        return $this;
    }

    /**
     * Remove keyword
     *
     * @param Keyword $keyword
     */
    public function removeKeyword(Keyword $keyword) {
        $this->keywords->removeElement($keyword);
    }

    /**
     * Get keywords
     *
     * @return Collection
     */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * Add digitalCopyHolder
     *
     * @param DigitalCopyHolder $digitalCopyHolder
     *
     * @return Book
     */
    public function addDigitalCopyHolder(DigitalCopyHolder $digitalCopyHolder) {
        $this->digitalCopyHolders[] = $digitalCopyHolder;

        return $this;
    }

    /**
     * Remove digitalCopyHolder
     *
     * @param DigitalCopyHolder $digitalCopyHolder
     */
    public function removeDigitalCopyHolder(DigitalCopyHolder $digitalCopyHolder) {
        $this->digitalCopyHolders->removeElement($digitalCopyHolder);
    }

    /**
     * Get digitalCopyHolders
     *
     * @return Collection
     */
    public function getDigitalCopyHolders() {
        return $this->digitalCopyHolders;
    }

    /**
     * Add publicationPlace
     *
     * @param Place $publicationPlace
     *
     * @return Book
     */
    public function addPublicationPlace(Place $publicationPlace) {
        $this->publicationPlaces[] = $publicationPlace;

        return $this;
    }

    /**
     * Remove publicationPlace
     *
     * @param Place $publicationPlace
     */
    public function removePublicationPlace(Place $publicationPlace) {
        $this->publicationPlaces->removeElement($publicationPlace);
    }

    /**
     * Get publicationPlaces
     *
     * @return Collection
     */
    public function getPublicationPlaces() {
        return $this->publicationPlaces;
    }

    /**
     * Set sfuDigitalCopy
     *
     * @param string $sfuDigitalCopy
     *
     * @return Book
     */
    public function setSfuDigitalCopy($sfuDigitalCopy) {
        $this->sfuDigitalCopy = $sfuDigitalCopy;

        return $this;
    }

    /**
     * Get sfuDigitalCopy
     *
     * @return string
     */
    public function getSfuDigitalCopy() {
        return $this->sfuDigitalCopy;
    }

}

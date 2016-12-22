<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ZendSearch\Lucene\Lucene;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;

/**
 * Demand
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DemandRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Demand {

    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var lieu Lieu ou se trouve le produit.
     *
     * @ORM\Column(type="string")
     */
    private $lieu;

    /**
     * @var createAt la date de creation de l 'offre.
     *
     *
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @var quantite
     *
     *
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @var dateLimit date limite de l'offre
     *
     * @ORM\Column(type="datetime")
     */
    private $dateLimit;

    /**
     * @var dateLimit date limite de l'offre
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $dateLimitUpdate;

    /**
     * @var prixUnit prix unitaire
     *
     *
     * @ORM\Column(type="integer")
     */
    private $prixUnit;

    /**
     * @var description detail complementaire
     *
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var public boolean. offre published
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $published = false;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $canceledAt;

    /**
     * @ORM\Column(type="text", nullable = true)
     *
     * @var \DateTime
     */
    private $canceledReason;

    /**
     * @var public boolean. offre published
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $available = true;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $deleteAt;

    /**
     * @var accepted boolean. order accepte
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $deleted = false;

    /**
     * @var permanent boolean. Approvisionnement permanent
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $permanent = false;

    /**
     * @var canceled boolean. order canceled
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $canceled = false;

    /**
     * @ORM\ManyToOne(targetEntity="Measure")
     */
    private $measure;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="demands")
     */
    private $product;

    /**
     * @var User\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="demands")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\District")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     * @Assert\Type("AppBundle\Entity\District")
     * @Assert\NotNull()
     */
    protected $district;

    /**
     * @ORM\OneToMany(targetEntity="Supply", mappedBy="demand", cascade={"persist"})
     */
    private $supplies;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     *
     * @var string
     */
    private $imageName;

    /**
     * Date de modifcation de l'offre
     *
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null) {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile() {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName() {
        return $this->imageName;
    }

    public function __construct() {
        $this->supplies = new ArrayCollection();
    }

    /**
     * Set dateLimit
     * Chaque offre a 30 jours de visibilité
     * @ORM\PrePersist
     */
    public function setDateLimit() {
        $this->dateLimit = new \DateTime();
        $this->dateLimit->add(new \DateInterval('P30D'));
    }

    /**
     * Get dateLimit
     *
     * @return \DateTime
     */
    public function getDateLimit() {
        return $this->dateLimit;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set district
     *
     * @param \AppBundle\Entity\District $district
     *
     * @return Demand
     */
    public function setDistrict(\AppBundle\Entity\District $district = null) {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \AppBundle\Entity\District
     */
    public function getDistrict() {
        return $this->district;
    }

//    static public function getLuceneIndex() {
//        if (file_exists($index = self::getLuceneIndexFile())) {
//            return Lucene::open($index);
//        }
//
//        return Lucene::create($index);
//    }
//
//    static public function getLuceneIndexFile() {
//        return __DIR__ . '/../../../web/data/demand.index';
//    }
//
//    /**
//     * Set createdAt
//     * *
//     * @ORM\PostPersist
//     * @ORM\PostUpdate
//     */
//    public function updateLuceneIndex() {
//        $index = self::getLuceneIndex();
//
//        // remove existing entries
//        foreach ($index->find('pk:' . $this->getId()) as $hit) {
//            $index->delete($hit->id);
//        }
//
//        // don't index unavailable and non-published sale
//        if (!$this->getAvailable() || !$this->getPublished()) {
//            return;
//        }
//
//        $doc = new Document();
//
//        // store demand primary key to identify it in the search results
//        $doc->addField(Field::Keyword('pk', $this->getId()));
//
//        // index demand fields
//        $doc->addField(Field::UnStored('product', $this->getProduct(), 'utf-8'));
//        $doc->addField(Field::UnStored('lieu', $this->getLieu(), 'utf-8'));
//        $doc->addField(Field::UnStored('district', $this->getDistrict(), 'utf-8'));
//        // add demand to the index
//        $index->addDocument($doc);
//        $index->commit();
//    }
//
//    /**
//     * Set createdAt
//     * *
//     * @ORM\PostRemove
//     */
//    public function deleteLuceneIndex() {
//        $index = self::getLuceneIndex();
//
//        foreach ($index->find('pk:' . $this->getId()) as $hit) {
//            $index->delete($hit->id);
//        }
//    }

    /**
     * Get id
     *
     * @return guid
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Demand
     */
    public function setLieu($lieu) {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu() {
        return $this->lieu;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Demand
     */
    public function setQuantite($quantite) {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite() {
        return $this->quantite;
    }

    /**
     * Set prixUnit
     *
     * @param integer $prixUnit
     *
     * @return Demand
     */
    public function setPrixUnit($prixUnit) {
        $this->prixUnit = $prixUnit;

        return $this;
    }

    /**
     * Get prixUnit
     *
     * @return integer
     */
    public function getPrixUnit() {
        return $this->prixUnit;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Demand
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Demand
     */
    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Demand
     */
    public function setProduct(\AppBundle\Entity\Product $product) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User\User $user
     *
     * @return Demand
     */
    public function setUser(\AppBundle\Entity\User\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Add supply
     *
     * @param \AppBundle\Entity\Demand $supply
     *
     * @return Demand
     */
    public function addSupply(\AppBundle\Entity\Demand $supply) {
        $this->supplies[] = $supply;

        return $this;
    }

    /**
     * Remove supply
     *
     * @param \AppBundle\Entity\Demand $supply
     */
    public function removeSupply(\AppBundle\Entity\Demand $supply) {
        $this->supplies->removeElement($supply);
    }

    /**
     * Get supplies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupplies() {
        return $this->supplies;
    }

    /**
     * Set createdAt
     * *
     * @ORM\PrePersist
     */
    public function setCreateat() {
        $this->createAt = new \DateTime();
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt() {
        return $this->createAt;
    }

    /**
     * Set dateLimitUpdate
     *
     * @param \DateTime $dateLimitUpdate
     *
     * @return Demand
     * @ORM\PreUpdate
     */
    public function setDateLimitUpdate() {
        $this->dateLimitUpdate = new \DateTime();
        $this->dateLimitUpdate->add(new \DateInterval('P30D'));

        return $this;
    }

    /**
     * Get dateLimitUpdate
     *
     * @return \DateTime
     */
    public function getDateLimitUpdate() {
        return $this->dateLimitUpdate;
    }

    /**
     * Set canceledAt
     *
     * @param \DateTime $canceledAt
     *
     * @return Demand
     */
    public function setCanceledAt($canceledAt) {
        $this->canceledAt = $canceledAt;

        return $this;
    }

    /**
     * Get canceledAt
     *
     * @return \DateTime
     */
    public function getCanceledAt() {
        return $this->canceledAt;
    }

    /**
     * Set canceledReason
     *
     * @param string $canceledReason
     *
     * @return Demand
     */
    public function setCanceledReason($canceledReason) {
        $this->canceledReason = $canceledReason;

        return $this;
    }

    /**
     * Get canceledReason
     *
     * @return string
     */
    public function getCanceledReason() {
        return $this->canceledReason;
    }

    /**
     * Set available
     *
     * @param boolean $available
     *
     * @return Demand
     */
    public function setAvailable($available) {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return boolean
     */
    public function getAvailable() {
        return $this->available;
    }

    /**
     * Set deleteAt
     *
     * @param \DateTime $deleteAt
     *
     * @return Demand
     */
    public function setDeleteAt($deleteAt) {
        $this->deleteAt = $deleteAt;

        return $this;
    }

    /**
     * Get deleteAt
     *
     * @return \DateTime
     */
    public function getDeleteAt() {
        return $this->deleteAt;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Demand
     */
    public function setDelete($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDelete() {
        return $this->deleted;
    }

    /**
     * Set permanent
     *
     * @param boolean $permanent
     *
     * @return Demand
     */
    public function setPermanent($permanent) {
        $this->permanent = $permanent;

        return $this;
    }

    /**
     * Get permanent
     *
     * @return boolean
     */
    public function getPermanent() {
        return $this->permanent;
    }

    /**
     * Set canceled
     *
     * @param boolean $canceled
     *
     * @return Demand
     */
    public function setCanceled($canceled) {
        $this->canceled = $canceled;

        return $this;
    }

    /**
     * Get canceled
     *
     * @return boolean
     */
    public function getCanceled() {
        return $this->canceled;
    }

    /**
     * Set measure
     *
     * @param \AppBundle\Entity\Measure $measure
     *
     * @return Demand
     */
    public function setMeasure(\AppBundle\Entity\Measure $measure = null) {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get measure
     *
     * @return \AppBundle\Entity\Measure
     */
    public function getMeasure() {
        return $this->measure;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Demand
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted() {
        return $this->deleted;
    }

    public function __toString() {

    }

}

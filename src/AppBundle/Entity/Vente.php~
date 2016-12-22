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
 * Vente
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VenteRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Vente {

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
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $published = false;

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
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"}, inversedBy="ventes")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Measure")
     */
    private $measure;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="vente")
     */
    private $orders;

    /**
     * @var User\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="ventes")
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
        $this->orders = new ArrayCollection();
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
     * Set createdAt
     * *
     * @ORM\PrePersist
     */
    public function setCreateat() {
        $this->createAt = new \DateTime();
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
     * @return Vente
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
//        return __DIR__ . '/../../../web/data/vente.index';
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
//        // store vente primary key to identify it in the search results
//        $doc->addField(Field::Keyword('pk', $this->getId()));
//
//        // index vente fields
//        $doc->addField(Field::UnStored('product', $this->getProduct(), 'utf-8'));
//        $doc->addField(Field::UnStored('lieu', $this->getLieu(), 'utf-8'));
//        $doc->addField(Field::UnStored('district', $this->getDistrict(), 'utf-8'));
//        // add vente to the index
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Vente
     */
    public function addOrder(\AppBundle\Entity\Order $order) {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order) {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders() {
        return $this->orders;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User\User $user
     *
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * @return Vente
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
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Vente
     */
    public function setProduct(\AppBundle\Entity\Product $product = null) {
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
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Vente
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

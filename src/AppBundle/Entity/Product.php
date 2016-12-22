<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * @see http://schema.org/Product Documentation on Schema.org
 *
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProductRepository")
 * @ORM\Table("Product")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Product {

    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string The name of the item.
     * @ORM\Column(name="name")
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Measure", inversedBy="products", cascade={"persist"})
     * @ORM\JoinTable(name="products_measures")
     */
    private $measures;

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
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $updatedAt;
    
    /**
     * @var ventes[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vente", mappedBy="product", cascade={"persist"})
     */
    private $ventes;
    
    /**
     * @var demands[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Demand", mappedBy="product", cascade={"persist"})
     */
    private $demands;

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
        $this->measures = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return guid
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function __toString() {
        return '' . $this->getName();
    }

    /**
     * Add measure
     *
     * @param \AppBundle\Entity\Measure $measure
     *
     * @return Product
     */
    public function addMeasure(\AppBundle\Entity\Measure $measure) {
        $this->measures[] = $measure;

        return $this;
    }

    /**
     * Remove measure
     *
     * @param \AppBundle\Entity\Measure $measure
     */
    public function removeMeasure(\AppBundle\Entity\Measure $measure) {
        $this->measures->removeElement($measure);
    }

    /**
     * Get measures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeasures() {
        return $this->measures;
    }
    /**
     * Add vente
     *
     * @param \AppBundle\Entity\Vente $vente
     *
     * @return Product
     */
    public function addVente(\AppBundle\Entity\Vente $vente)
    {
        $this->ventes[] = $vente;

        return $this;
    }

    /**
     * Remove vente
     *
     * @param \AppBundle\Entity\Vente $vente
     */
    public function removeVente(\AppBundle\Entity\Vente $vente)
    {
        $this->ventes->removeElement($vente);
    }

    /**
     * Get ventes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentes()
    {
        return $this->ventes;
    }

    /**
     * Add demand
     *
     * @param \AppBundle\Entity\Demand $demand
     *
     * @return Product
     */
    public function addDemand(\AppBundle\Entity\Demand $demand)
    {
        $this->demands[] = $demand;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Remove demand
     *
     * @param \AppBundle\Entity\Demand $demand
     */
    public function removeDemand(\AppBundle\Entity\Demand $demand)
    {
        $this->demands->removeElement($demand);
    }

    /**
     * Get demands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemands()
    {
        return $this->demands;
    }
     /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}

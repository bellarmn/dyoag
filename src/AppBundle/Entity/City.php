<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

/**
 * AppBundle\Entity\City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CityRepository")
 */
class City
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Province", inversedBy="cities")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
    protected $province;
    
     /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\District", mappedBy="city")
     */
    protected $districts;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return City
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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

    /**
     * Set province
     *
     * @param  \AppBundle\Entity\Province $province
     * @return City
     */
    public function setProvince(\AppBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \AppBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    public function __toString()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->districts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add district
     *
     * @param \AppBundle\Entity\District $district
     *
     * @return City
     */
    public function addDistrict(\AppBundle\Entity\District $district)
    {
        $this->districts[] = $district;

        return $this;
    }

    /**
     * Remove district
     *
     * @param \AppBundle\Entity\District $district
     */
    public function removeDistrict(\AppBundle\Entity\District $district)
    {
        $this->districts->removeElement($district);
    }

    /**
     * Get districts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistricts()
    {
        return $this->districts;
    }
    
}

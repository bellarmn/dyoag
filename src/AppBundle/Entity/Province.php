<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

/**
 * AppBundle\Entity\Province
 *
 * @ORM\Table(name="province")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProvinceRepository")
 */
class Province
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\City", mappedBy="province")
     */
    protected $cities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @param  string   $name
     * @return Province
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
     * @param  string   $slug
     * @return Province
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
     * Add cities
     *
     * @param  \AppBundle\Entity\City $cities
     * @return Province
     */
    public function addCity(\AppBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \AppBundle\Entity\City $cities
     */
    public function removeCity(\AppBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }
}

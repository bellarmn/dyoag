<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Jacques Adjahoungbo <jtocson@gmail.com>
 */

/**
 * AppBundle\Entity\District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DistrictRepository")
 */
class District {

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City", inversedBy="districts")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return District
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
     * Set city
     *
     * @param  \AppBundle\Entity\City $city
     * @return District
     */
    public function setCity(\AppBundle\Entity\City $city = null) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity() {
        return $this->city;
    }

    public function __toString() {
        return $this->name;
    }

    public function getProvinceCitydata() {
        return $this->getCity()->getProvince()->getName() . '  (' . $this->getCity()->getName() . ')';
    }

}

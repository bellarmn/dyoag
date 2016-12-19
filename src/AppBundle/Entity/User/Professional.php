<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Professional
 * @ORM\Entity()
 */
class Professional extends User {

    /**
     * @var integer numero ifu
     *
     * @ORM\Column(name="professional_ifu", type="bigint", length=13, nullable=false)
     * @Assert\Length(min="13")
     * @Assert\Length(max="13")
     */
    private $ifu;
    
    /**
     * @var string $rcc
     *
     * @ORM\Column(name="professional_rcc", type="string" , nullable=false)
     */
    private $rcc;
    
    /**
     * @var string  Adresse phyique de votre entreprise(Rue, Numero,etc...)
     *
     * @ORM\Column(name="professional_adresse", type="string", length=45, nullable=false)
     * @Assert\Length(min="5")
     */
    private $adresse;

    /**
     * @var string Nom de votre entreprise ( = celui de votre registre de commerce)
     *
     * @ORM\Column(name="professional_company", type="string", length=45, nullable=false)
     * @Assert\Length(min="5")
     */
    private $nomEntreprise;

    /**
     * Set nomEntreprise
     *
     * @param string $nomEntreprise
     *
     * @return Professional
     */
    public function setNomEntreprise($nomEntreprise) {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    /**
     * Get nomEntreprise
     *
     * @return string
     */
    public function getNomEntreprise() {
        return $this->nomEntreprise;
    }

    /**
     * Set ifu
     *
     * @param integer $ifu
     *
     * @return Professional
     */
    public function setIfu($ifu) {
        $this->ifu = $ifu;

        return $this;
    }

    /**
     * Get ifu
     *
     * @return integer
     */
    public function getIfu() {
        return $this->ifu;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Professional
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * Get rcc
     *
     * @return string
     */
    public function getRcc() {
        return $this->rcc;
    }
    /**
     * Set rcc
     *
     * @param string $rcc
     *
     * @return Professional
     */
    public function setRcc($rcc) {
        $this->rcc = $rcc;

        return $this;
    }
}

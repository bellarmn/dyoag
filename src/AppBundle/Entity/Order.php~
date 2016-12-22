<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Order
 *
 * @ORM\Table("orders")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Order {

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var createAt la date de order.
     *
     *
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $deliveredAt;

    /**
     * @ORM\Column(type="text", nullable = true)
     *
     * @var \text
     */
    private $deliverConclusion;

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
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $acceptedAt;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $deleteAt;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     *
     * @var \DateTime
     */
    private $approuvedAt;

    /**
     * @var quantite
     *
     *
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @var rating
     *
     *
     * @ORM\Column(type="integer", nullable = true)
     */
    private $rating;

    /**
     * @var accepted boolean. order accepte
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $deleted = false;

    /**
     * @var accepted boolean. order accepte
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $accepted = false;

    /**
     * @var delivered boolean. order livre
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $delivered = false;

    /**
     * @var approuved boolean. order approuve
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $approuved = false;

    /**
     * @var canceled boolean. order canceled
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $canceled = false;

    /**
     * @ORM\ManyToOne(targetEntity="Vente", inversedBy="orders")
     */
    private $vente;

    /**
     * @var User\User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User\User", inversedBy="orders")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set createAt
     *
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
     * Set deliveredAt
     *
     * @param \DateTime $deliveredAt
     *
     * @return Order
     */
    public function setDeliveredAt($deliveredAt) {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

    /**
     * Get deliveredAt
     *
     * @return \DateTime
     */
    public function getDeliveredAt() {
        return $this->deliveredAt;
    }

    /**
     * Set deliverConclusion
     *
     * @param string $deliverConclusion
     *
     * @return Order
     */
    public function setDeliverConclusion($deliverConclusion) {
        $this->deliverConclusion = $deliverConclusion;

        return $this;
    }

    /**
     * Get deliverConclusion
     *
     * @return string
     */
    public function getDeliverConclusion() {
        return $this->deliverConclusion;
    }

    /**
     * Set canceledAt
     *
     * @param \DateTime $canceledAt
     *
     * @return Order
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
     * @return Order
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
     * Set acceptedAt
     *
     * @param \DateTime $acceptedAt
     *
     * @return Order
     */
    public function setAcceptedAt($acceptedAt) {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    /**
     * Get acceptedAt
     *
     * @return \DateTime
     */
    public function getAcceptedAt() {
        return $this->acceptedAt;
    }

    /**
     * Set deleteAt
     *
     * @param \DateTime $deleteAt
     *
     * @return Order
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
     * Set approuvedAt
     *
     * @param \DateTime $approuvedAt
     *
     * @return Order
     */
    public function setApprouvedAt($approuvedAt) {
        $this->approuvedAt = $approuvedAt;

        return $this;
    }

    /**
     * Get approuvedAt
     *
     * @return \DateTime
     */
    public function getApprouvedAt() {
        return $this->approuvedAt;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Order
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
     * Set rating
     *
     * @param integer $rating
     *
     * @return Order
     */
    public function setRating($rating) {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating() {
        return $this->rating;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Order
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
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Order
     */
    public function setAccepted($accepted) {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return boolean
     */
    public function getAccepted() {
        return $this->accepted;
    }

    /**
     * Set delivered
     *
     * @param boolean $delivered
     *
     * @return Order
     */
    public function setDelivered($delivered) {
        $this->delivered = $delivered;

        return $this;
    }

    /**
     * Get delivered
     *
     * @return boolean
     */
    public function getDelivered() {
        return $this->delivered;
    }

    /**
     * Set approuved
     *
     * @param boolean $approuved
     *
     * @return Order
     */
    public function setApprouved($approuved) {
        $this->approuved = $approuved;

        return $this;
    }

    /**
     * Get approuved
     *
     * @return boolean
     */
    public function getApprouved() {
        return $this->approuved;
    }

    /**
     * Set canceled
     *
     * @param boolean $canceled
     *
     * @return Order
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
     * Set vente
     *
     * @param \AppBundle\Entity\Vente $vente
     *
     * @return Order
     */
    public function setVente(\AppBundle\Entity\Vente $vente = null) {
        $this->vente = $vente;

        return $this;
    }

    /**
     * Get vente
     *
     * @return \AppBundle\Entity\Vente
     */
    public function getVente() {
        return $this->vente;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User\User $user
     *
     * @return Order
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
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Order
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

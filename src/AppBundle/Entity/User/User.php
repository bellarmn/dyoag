<?php

namespace AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\MessageBundle\Model\ParticipantInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Mgilet\NotificationBundle\Model\UserNotificationInterface;

/**
 * A person (alive, dead, undead, or fictional).
 *
 * @see http://schema.org/Person Documentation on Schema.org
 *
 *
 * @ORM\Entity
 * @ORM\Table("User")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", length=15, type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "user"="AppBundle\Entity\User\User",
 *     "admin"="AppBundle\Entity\User\Admin",
 *     "customer"="AppBundle\Entity\User\Particular",
 *     "farmer"="AppBundle\Entity\User\Professional"
 *     }
 * )
 */
class User extends BaseUser implements ParticipantInterface, UserNotificationInterface {

    // link to notifications
    /**
     * @var Notification
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notification", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    protected $notifications;

    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string The username of the author.
     *
     * @Groups({"user_read", "user_write"})
     *
     * @Assert\Length(min="6")
     */
    protected $username;

    /**
     * @var string The email of the user.
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $email;

    /**
     * @var string Plain password. Used for model validation. Must not be persisted.
     *
     * @Groups({"user_write"})
     */
    protected $plainPassword;

    /**
     * @var boolean Shows that the user is enabled
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $enabled;

    /**
     * @var array Array, role(s) of the user
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="user_firstName", type="string", length=45, nullable=false)
     * @Assert\Length(min="3")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_lastName", type="string", length=45, nullable=false)
     * @Assert\Length(min="3")
     */
    private $lastName;

    /**
     * @ORM\Column(type="phone_number")
     *
     * @AssertPhoneNumber(defaultRegion="BJ")
     */
    private $phone;

    /**
     * @var \DateTime Date of birth.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date
     */
    private $birthDate;

    /**
     * @var string Gender of the person.
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(nullable=false)
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     */
    private $profil;

    /**
     * @var string Vous etes $user_category
     *
     * @ORM\ManyToOne(targetEntity="UserCategory", inversedBy="users")
     */
    private $user_category;

    /**
     * @ORM\ManyToMany(targetEntity="Field", inversedBy="users", cascade={"persist"})
     * @ORM\JoinTable(name="users_fields")
     */
    private $fields;

    /**
     * @var string The avatar.
     *
     * @ORM\Column(nullable=true)
     * @Assert\Type(type="string")
     */
    private $avatar;

    /**
     * @var ventes[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vente", mappedBy="user", cascade={"persist"})
     */
    private $ventes;

    /**
     * @var orders[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Order", mappedBy="user", cascade={"persist"})
     */
    private $orders;

    /**
     * @var supplies[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Supply", mappedBy="user", cascade={"persist"})
     */
    private $supplies;

    /**
     * @var demands[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Demand", mappedBy="user", cascade={"persist"})
     */
    private $demands;
        
    /**
     * @var notificationVente boolean. 
     * @ORM\Column(type="boolean", options={"default" : false}, nullable=true)
     */
    private $notificationVente = true;
        
    /**
     * @var notificationDemand boolean. 
     * @ORM\Column(type="boolean", options={"default" : false}, nullable=true)
     */
    private $notificationDemand = true;
        
    /**
     * @var notificationSupply boolean. 
     * @ORM\Column(type="boolean", options={"default" : false}, nullable=true)
     */
    private $notificationSupply = true;
        
    /**
     * @var notificationOrder boolean. 
     * @ORM\Column(type="boolean", options={"default" : false}, nullable=true)
     */
    private $notificationOrder = true;

    public function __construct() {
        parent::__construct();
        $this->orders = new ArrayCollection();
        $this->ventes = new ArrayCollection();
        $this->supplies = new ArrayCollection();
        $this->demands = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
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
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender) {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * Add ventes
     *
     * @param \AppBundle\Entity\Vente $ventes
     * @return User
     */
    public function addVente(\AppBundle\Entity\Vente $ventes) {
        $this->ventes[] = $ventes;

        return $this;
    }

    /**
     * Remove ventes
     *
     * @param \AppBundle\Entity\Vente $ventes
     */
    public function removeVente(\AppBundle\Entity\Vente $ventes) {
        $this->ventes->removeElement($ventes);
    }

    /**
     * Get ventes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentes() {
        return $this->ventes;
    }

    /**
     * Add orders
     *
     * @param \AppBundle\Entity\Order $orders
     * @return User
     */
    public function addOrder(\AppBundle\Entity\Order $orders) {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \AppBundle\Entity\Order $orders
     */
    public function removeOrder(\AppBundle\Entity\Order $orders) {
        $this->orders->removeElement($orders);
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
     * Set profil
     *
     * @param string $profil
     *
     * @return User
     */
    public function setProfil($profil) {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return string
     */
    public function getProfil() {
        return $this->profil;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Add supply
     *
     * @param \AppBundle\Entity\Supply $supply
     *
     * @return User
     */
    public function addSupply(\AppBundle\Entity\Supply $supply) {
        $this->supplies[] = $supply;

        return $this;
    }

    /**
     * Remove supply
     *
     * @param \AppBundle\Entity\Supply $supply
     */
    public function removeSupply(\AppBundle\Entity\Supply $supply) {
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
     * Add demand
     *
     * @param \AppBundle\Entity\Demand $demand
     *
     * @return User
     */
    public function addDemand(\AppBundle\Entity\Demand $demand) {
        $this->demands[] = $demand;

        return $this;
    }

    /**
     * Remove demand
     *
     * @param \AppBundle\Entity\Demand $demand
     */
    public function removeDemand(\AppBundle\Entity\Demand $demand) {
        $this->demands->removeElement($demand);
    }

    /**
     * Get demands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemands() {
        return $this->demands;
    }

    /**
     * Set userCategory
     *
     * @param \AppBundle\Entity\User\UserCategory $userCategory
     *
     * @return User
     */
    public function setUserCategory(\AppBundle\Entity\User\UserCategory $userCategory = null) {
        $this->user_category = $userCategory;

        return $this;
    }

    /**
     * Get userCategory
     *
     * @return \AppBundle\Entity\User\UserCategory
     */
    public function getUserCategory() {
        return $this->user_category;
    }

    /**
     * Add field
     *
     * @param \AppBundle\Entity\User\Field $field
     *
     * @return User
     */
    public function addField(\AppBundle\Entity\User\Field $field) {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field
     *
     * @param \AppBundle\Entity\User\Field $field
     */
    public function removeField(\AppBundle\Entity\User\Field $field) {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields() {
        return $this->fields;
    }


    /**
     * Set notificationVente
     *
     * @param boolean $notificationVente
     *
     * @return User
     */
    public function setNotificationVente($notificationVente)
    {
        $this->notificationVente = $notificationVente;

        return $this;
    }

    /**
     * Get notificationVente
     *
     * @return boolean
     */
    public function getNotificationVente()
    {
        return $this->notificationVente;
    }

    /**
     * Set notificationDemand
     *
     * @param boolean $notificationDemand
     *
     * @return User
     */
    public function setNotificationDemand($notificationDemand)
    {
        $this->notificationDemand = $notificationDemand;

        return $this;
    }

    /**
     * Get notificationDemand
     *
     * @return boolean
     */
    public function getNotificationDemand()
    {
        return $this->notificationDemand;
    }

    /**
     * Set notificationSupply
     *
     * @param boolean $notificationSupply
     *
     * @return User
     */
    public function setNotificationSupply($notificationSupply)
    {
        $this->notificationSupply = $notificationSupply;

        return $this;
    }

    /**
     * Get notificationSupply
     *
     * @return boolean
     */
    public function getNotificationSupply()
    {
        return $this->notificationSupply;
    }

    /**
     * Set notificationOrder
     *
     * @param boolean $notificationOrder
     *
     * @return User
     */
    public function setNotificationOrder($notificationOrder)
    {
        $this->notificationOrder = $notificationOrder;

        return $this;
    }

    /**
     * Get notificationOrder
     *
     * @return boolean
     */
    public function getNotificationOrder()
    {
        return $this->notificationOrder;
    }
    
    // method implementation for UserNotificationInterface

    /**
     * {@inheritdoc}
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * {@inheritdoc}
     */
    public function addNotification($notification)
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeNotification($notification)
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        $this->getId();
    }

}

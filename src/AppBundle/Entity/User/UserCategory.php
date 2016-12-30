<?php

namespace AppBundle\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserCategory
 * @ORM\Entity()
 */
class UserCategory {

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string The name of the category.
     *
     * @ORM\Column(nullable=false)
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="user_category", cascade={"persist"})
     */
    private $users;

    public function __construct() {
        $this->users = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return UserCategory
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
     * Add user
     *
     * @param \AppBundle\Entity\User\User $user
     *
     * @return UserCategory
     */
    public function addUser(\AppBundle\Entity\User\User $user) {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User\User $user
     */
    public function removeUser(\AppBundle\Entity\User\User $user) {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers() {
        return $this->users;
    }

    public function __toString() {
        return $this->name;
    }

}

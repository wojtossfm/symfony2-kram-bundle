<?php

namespace WojciechM\KramBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WojciechM\KramBundle\Repository\UserRepository")
 */
class User implements UserInterface, AdvancedUserInterface, \Serializable,
		EquatableInterface {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $salt;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="first_name", type="string", length=255)
	 * @Assert\NotBlank()
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=255)
	 * @Assert\NotBlank()
	 */
	private $lastName;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_admin", type="boolean")
	 */
	private $isAdmin;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date_created", type="datetime")
	 */
	private $dateCreated;

	/**
	 * @ORM\ManyToMany(targetEntity="Week", mappedBy="collectors")
	 **/
	private $collectionWeeks;

	/**
	 * @ORM\ManyToMany(targetEntity="Week", mappedBy="shoppers")
	 **/
	private $shoppingWeeks;

	/**
	 * @ORM\OneToMany(targetEntity="Payment", mappedBy="user")
	 **/
	private $payments;

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set firstName
	 *
	 * @param string $firstName
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
	 * Set isActive
	 *
	 * @param boolean $isActive
	 * @return User
	 */
	public function setIsActive($isActive) {
		$this->isActive = $isActive;

		return $this;
	}

	/**
	 * Get isActive
	 *
	 * @return boolean 
	 */
	public function getIsActive() {
		return $this->isActive;
	}

	/**
	 * Set isAdmin
	 *
	 * @param boolean $isAdmin
	 * @return User
	 */
	public function setIsAdmin($isAdmin) {
		$this->isAdmin = $isAdmin;

		return $this;
	}

	/**
	 * Get isAdmin
	 *
	 * @return boolean 
	 */
	public function getIsAdmin() {
		return $this->isAdmin;
	}

	/**
	 * Set dateCreated
	 *
	 * @param \DateTime $dateCreated
	 * @return User
	 */
	public function setDateCreated($dateCreated) {
		$this->dateCreated = $dateCreated;

		return $this;
	}

	/**
	 * Get dateCreated
	 *
	 * @return \DateTime 
	 */
	public function getDateCreated() {
		return $this->dateCreated;
	}

	/**
	 * Add collectionWeeks
	 *
	 * @param \WojciechM\KramBundle\Entity\Week $collectionWeeks
	 * @return User
	 */
	public function addCollectionWeek(
			\WojciechM\KramBundle\Entity\Week $collectionWeeks) {
		$this->collectionWeeks[] = $collectionWeeks;

		return $this;
	}

	/**
	 * Remove collectionWeeks
	 *
	 * @param \WojciechM\KramBundle\Entity\Week $collectionWeeks
	 */
	public function removeCollectionWeek(
			\WojciechM\KramBundle\Entity\Week $collectionWeeks) {
		$this->collectionWeeks->removeElement($collectionWeeks);
	}

	/**
	 * Get collectionWeeks
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCollectionWeeks() {
		return $this->collectionWeeks;
	}

	/**
	 * Add shoppingWeeks
	 *
	 * @param \WojciechM\KramBundle\Entity\Week $shoppingWeeks
	 * @return User
	 */
	public function addShoppingWeek(
			\WojciechM\KramBundle\Entity\Week $shoppingWeeks) {
		$this->shoppingWeeks[] = $shoppingWeeks;

		return $this;
	}

	/**
	 * Remove shoppingWeeks
	 *
	 * @param \WojciechM\KramBundle\Entity\Week $shoppingWeeks
	 */
	public function removeShoppingWeek(
			\WojciechM\KramBundle\Entity\Week $shoppingWeeks) {
		$this->shoppingWeeks->removeElement($shoppingWeeks);
	}

	/**
	 * Get shoppingWeeks
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getShoppingWeeks() {
		return $this->shoppingWeeks;
	}

	/**
	 * Add payments
	 *
	 * @param \WojciechM\KramBundle\Entity\Payment $payments
	 * @return User
	 */
	public function addPayment(\WojciechM\KramBundle\Entity\Payment $payments) {
		$this->payments[] = $payments;

		return $this;
	}

	/**
	 * Remove payments
	 *
	 * @param \WojciechM\KramBundle\Entity\Payment $payments
	 */
	public function removePayment(
			\WojciechM\KramBundle\Entity\Payment $payments) {
		$this->payments->removeElement($payments);
	}

	/**
	 * Get payments
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getPayments() {
		return $this->payments;
	}

	public function __toString() {
		return $this->lastName . " " . $this->firstName;
	}

	public function __construct() {
		$this->salt = md5(uniqid());
		$this->dateCreated = new \DateTime();
		$this->collectionWeeks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->shoppingWeeks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->payments = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function isAccountNonExpired() {
		return $this->getIsActive();
	}
	public function isAccountNonLocked() {
		return $this->getIsActive();

	}
	public function isCredentialsNonExpired() {
		return $this->getIsActive();

	}
	public function isEnabled() {
		return $this->getIsActive();
	}

	public function getRoles() {
		$roles = array();
		$roles[] = "ROLE_USER";
		if ($this->getIsAdmin()) {
			$roles[] = "ROLE_ADMIN";
		}
		return $roles;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getSalt() {
		return $this->salt;
	}

	public function getUsername() {
		return $this->username;
	}

	public function eraseCredentials() {
		$this->password = "";
		$this->username = "";
		$this->salt = "";
	}

	/**
	 * @see \Serializable::serialize()
	 */
	public function serialize() {
		return serialize(
				array($this->id, $this->username, $this->password, $this->salt,
						$this->isActive, $this->isAdmin,));
	}

	/**
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized) {
		list($this->id, $this->username, $this->password, $this->salt, $this
				->isActive, $this->isAdmin, ) = unserialize($serialized);
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 * @return User
	 */
	public function setUsername($username) {
		$this->username = $username;

		return $this;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 * @return User
	 */
	public function setPassword($password) {
		$this->password = $password;

		return $this;
	}

	/**
	 * Set salt
	 *
	 * @param string $salt
	 * @return User
	 */
	public function setSalt($salt) {
		$this->salt = $salt;

		return $this;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return User
	 */
	public function setEmail($email) {
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string 
	 */
	public function getEmail() {
		return $this->email;
	}
	
	public function isEqualTo(UserInterface $user) {
		return $this->id === $user->getId();
	}

}

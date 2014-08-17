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
	 * @Assert\Length(min=2, max=60)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(
     *     min = 8,
     *     minMessage = "Password should by at least {{ limit }} chars long"
     * )
     * @Assert\Regex(pattern="/\d+/", message="Password must contain a digit")
     * @Assert\Regex(pattern="/[A-Z]+/u", message="Password must contain an uppercase character")
     * @Assert\Regex(pattern="/[a-z]+/u", message="Password must contain a lowercase character")
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $salt;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="first_name", type="string", length=255)
	 * @Assert\Length(min=2, max=255)
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="last_name", type="string", length=255)
	 * @Assert\Length(min=2, max=255)
	 */
	private $lastName;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $active;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_admin", type="boolean")
	 */
	private $admin;

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
	 * @ORM\OneToMany(targetEntity="Debt", mappedBy="user")
	 **/
	private $debts;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="balance", type="decimal")
	 */
	private $balance;

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
	 * Set active
	 *
	 * @param boolean $active
	 * @return User
	 */
	public function setActive($active) {
		$this->active = $active;

		return $this;
	}

	/**
	 * Get active
	 *
	 * @return boolean 
	 */
	public function getActive() {
		return $this->active;
	}

	/**
	 * Set admin
	 *
	 * @param boolean $admin
	 * @return User
	 */
	public function setAdmin($admin) {
		$this->admin = $admin;

		return $this;
	}

	/**
	 * Get admin
	 *
	 * @return boolean 
	 */
	public function getAdmin() {
		return $this->admin;
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
	
	/**
	 * Add debts
	 *
	 * @param \WojciechM\KramBundle\Entity\Debt $debts
	 * @return User
	 */
	public function addDebt(\WojciechM\KramBundle\Entity\Debt $debts)
	{
		$this->debts[] = $debts;
	
		return $this;
	}
	
	/**
	 * Remove debts
	 *
	 * @param \WojciechM\KramBundle\Entity\Debt $debts
	 */
	public function removeDebt(\WojciechM\KramBundle\Entity\Debt $debts)
	{
		$this->debts->removeElement($debts);
	}
	
	/**
	 * Get debts
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getDebts()
	{
		return $this->debts;
	}
	
	/**
	 * Get balance
	 *
	 * @return float
	 */
	public function getBalance() {
		//TODO: Rewrite this to either use an aggregate field or rely on SQL
		$this->balance = 0;
		foreach($this->getDebts() as $change) {
			$this->balance -= $change->getAmount();
		}
		foreach($this->getPayments() as $change) {
			$this->balance += $change->getAmount();
		}
		return $this->balance;
	}
	
	/**
	 * Set balance
	 *
	 * @param string $balance
	 * @return User
	 */
	public function setBalance($balance)
	{
		$this->balance = $balance;
	
		return $this;
	}

	public function isAccountNonExpired() {
		return $this->getActive();
	}
	public function isAccountNonLocked() {
		return $this->getActive();

	}
	public function isCredentialsNonExpired() {
		return $this->getActive();

	}
	public function isEnabled() {
		return $this->getActive();
	}

	public function getRoles() {
		$roles = array();
		$roles[] = "ROLE_USER";
		if ($this->getAdmin()) {
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
						$this->active, $this->admin,));
	}

	/**
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized) {
		list($this->id, $this->username, $this->password, $this->salt, $this
				->active, $this->admin, ) = unserialize($serialized);
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

	public function __toString() {
		return $this->lastName . " " . $this->firstName;
	}

	public function __construct() {
		$this->salt = md5(uniqid());
		$this->dateCreated = new \DateTime();
		$this->collectionWeeks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->shoppingWeeks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->payments = new \Doctrine\Common\Collections\ArrayCollection();
		$this->debts = new \Doctrine\Common\Collections\ArrayCollection();
		$this->balance = 0;
	}


}

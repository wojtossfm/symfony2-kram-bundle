<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isAdmin
     *
     * @param boolean $isAdmin
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add collectionWeeks
     *
     * @param \WojciechM\KramBundle\Entity\Week $collectionWeeks
     * @return User
     */
    public function addCollectionWeek(\WojciechM\KramBundle\Entity\Week $collectionWeeks)
    {
        $this->collectionWeeks[] = $collectionWeeks;

        return $this;
    }

    /**
     * Remove collectionWeeks
     *
     * @param \WojciechM\KramBundle\Entity\Week $collectionWeeks
     */
    public function removeCollectionWeek(\WojciechM\KramBundle\Entity\Week $collectionWeeks)
    {
        $this->collectionWeeks->removeElement($collectionWeeks);
    }

    /**
     * Get collectionWeeks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCollectionWeeks()
    {
        return $this->collectionWeeks;
    }

    /**
     * Add shoppingWeeks
     *
     * @param \WojciechM\KramBundle\Entity\Week $shoppingWeeks
     * @return User
     */
    public function addShoppingWeek(\WojciechM\KramBundle\Entity\Week $shoppingWeeks)
    {
        $this->shoppingWeeks[] = $shoppingWeeks;

        return $this;
    }

    /**
     * Remove shoppingWeeks
     *
     * @param \WojciechM\KramBundle\Entity\Week $shoppingWeeks
     */
    public function removeShoppingWeek(\WojciechM\KramBundle\Entity\Week $shoppingWeeks)
    {
        $this->shoppingWeeks->removeElement($shoppingWeeks);
    }

    /**
     * Get shoppingWeeks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShoppingWeeks()
    {
        return $this->shoppingWeeks;
    }

    /**
     * Add payments
     *
     * @param \WojciechM\KramBundle\Entity\Payment $payments
     * @return User
     */
    public function addPayment(\WojciechM\KramBundle\Entity\Payment $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments
     *
     * @param \WojciechM\KramBundle\Entity\Payment $payments
     */
    public function removePayment(\WojciechM\KramBundle\Entity\Payment $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPayments()
    {
        return $this->payments;
    }
    
    public function __toString() {
    	return $this->lastName . " " . $this->firstName;
    }

	public function __construct() {
		$this->dateCreated = new \DateTime();
		$this->collectionWeeks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->shoppingWeeks = new \Doctrine\Common\Collections\ArrayCollection();
		$this->payments = new \Doctrine\Common\Collections\ArrayCollection();
	}
}

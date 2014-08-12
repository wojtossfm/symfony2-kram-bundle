<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Payment
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Payment
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="payments")
     **/
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentType", inversedBy="payments")
     **/
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal")
     * @Assert\NotBlank()
     * @Assert\Range(min=0)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetimetz")
     */
    private $dateCreated;
    
    /**
     * @ORM\ManyToOne(targetEntity="Week", inversedBy="payments")
     **/
    private $week;

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
     * Set amount
     *
     * @param string $amount
     * @return Payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Payment
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
     * Set user
     *
     * @param \WojciechM\KramBundle\Entity\User $user
     * @return Payment
     */
    public function setUser(\WojciechM\KramBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WojciechM\KramBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param \WojciechM\KramBundle\Entity\PaymentType $type
     * @return Payment
     */
    public function setType(\WojciechM\KramBundle\Entity\PaymentType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \WojciechM\KramBundle\Entity\PaymentType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set week
     *
     * @param \WojciechM\KramBundle\Entity\Week $week
     * @return Payment
     */
    public function setWeek(\WojciechM\KramBundle\Entity\Week $week = null)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week
     *
     * @return \WojciechM\KramBundle\Entity\Week 
     */
    public function getWeek()
    {
        return $this->week;
    }
    
    public function __construct() {
    	$this->dateCreated = new \DateTime();
    }
}

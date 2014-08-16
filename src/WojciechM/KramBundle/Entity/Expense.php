<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expense
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Expense
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal")
     * @Assert\NotBlank()
     * @Assert\Range(min=0)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Week", inversedBy="expenses")
     **/
    private $week;

    /**
     * @var string
     * @ORM\Column(name="comment", type="string", nullable=True)
     * @Assert\Length(max=255)
     */
    private $comment;

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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Expense
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
     * Set amount
     *
     * @param string $amount
     * @return Expense
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
     * Set week
     *
     * @param \WojciechM\KramBundle\Entity\Week $week
     * @return Expense
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

    /**
     * Set comment
     *
     * @param string $comment
     * @return Expense
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
       

    public function __construct() {
    	$this->dateCreated = new \DateTime();
    }
    
    public function __toString() {
    	return "".$this->getAmount();
    }
    
}

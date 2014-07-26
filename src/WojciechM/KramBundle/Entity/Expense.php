<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="value", type="decimal")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Week", inversedBy="expenses")
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
     * Set value
     *
     * @param string $value
     * @return Expense
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
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
}

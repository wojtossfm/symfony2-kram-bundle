<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Week
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WojciechM\KramBundle\Repository\WeekRepository")
 */
class Week
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
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="fee", type="decimal")
     */
    private $fee;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="collectionWeeks")
     * @ORM\JoinTable(name="users_collectors")
     **/
    private $collectors;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="shoppingWeeks")
     * @ORM\JoinTable(name="users_shoppers")
     **/
    private $shoppers;
    
    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="week")
     **/
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity="Expense", mappedBy="week")
     **/
    private $expenses;


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
     * Set start
     *
     * @param \DateTime $start
     * @return Week
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Week
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set fee
     *
     * @param string $fee
     * @return Week
     */
    public function setFee($fee)
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * Get fee
     *
     * @return string 
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Set collectors
     *
     * @param array $collectors
     * @return Week
     */
    public function setCollectors($collectors)
    {
        $this->collectors = $collectors;

        return $this;
    }

    /**
     * Get collectors
     *
     * @return array 
     */
    public function getCollectors()
    {
        return $this->collectors;
    }

    /**
     * Set shoppers
     *
     * @param array $shoppers
     * @return Week
     */
    public function setShoppers($shoppers)
    {
        $this->shoppers = $shoppers;

        return $this;
    }

    /**
     * Get shoppers
     *
     * @return array 
     */
    public function getShoppers()
    {
        return $this->shoppers;
    }

    /**
     * Add collectors
     *
     * @param \WojciechM\KramBundle\Entity\User $collectors
     * @return Week
     */
    public function addCollector(\WojciechM\KramBundle\Entity\User $collectors)
    {
        $this->collectors[] = $collectors;

        return $this;
    }

    /**
     * Remove collectors
     *
     * @param \WojciechM\KramBundle\Entity\User $collectors
     */
    public function removeCollector(\WojciechM\KramBundle\Entity\User $collectors)
    {
        $this->collectors->removeElement($collectors);
    }

    /**
     * Add shoppers
     *
     * @param \WojciechM\KramBundle\Entity\User $shoppers
     * @return Week
     */
    public function addShopper(\WojciechM\KramBundle\Entity\User $shoppers)
    {
        $this->shoppers[] = $shoppers;

        return $this;
    }

    /**
     * Remove shoppers
     *
     * @param \WojciechM\KramBundle\Entity\User $shoppers
     */
    public function removeShopper(\WojciechM\KramBundle\Entity\User $shoppers)
    {
        $this->shoppers->removeElement($shoppers);
    }

    /**
     * Add payments
     *
     * @param \WojciechM\KramBundle\Entity\Payment $payments
     * @return Week
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

    /**
     * Add expenses
     *
     * @param \WojciechM\KramBundle\Entity\Expense $expenses
     * @return Week
     */
    public function addExpense(\WojciechM\KramBundle\Entity\Expense $expenses)
    {
        $this->expenses[] = $expenses;

        return $this;
    }

    /**
     * Remove expenses
     *
     * @param \WojciechM\KramBundle\Entity\Expense $expenses
     */
    public function removeExpense(\WojciechM\KramBundle\Entity\Expense $expenses)
    {
        $this->expenses->removeElement($expenses);
    }

    /**
     * Get expenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExpenses()
    {
        return $this->expenses;
    }
    
    public function __construct() {
    	$this->shoppers = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->collectors = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->payments = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->expenses = new \Doctrine\Common\Collections\ArrayCollection();
    }
}

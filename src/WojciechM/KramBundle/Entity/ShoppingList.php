<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ShoppingList
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ShoppingList
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
     * @ORM\OneToMany(targetEntity="ShoppingListEntry", mappedBy="list")
     **/
    private $entries;


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
     * @return ShoppingList
     */
    public function setDateCreated($dateCreated)    {
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
     * Set entries
     *
     * @param array $entries
     * @return ShoppingList
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Get entries
     *
     * @return array 
     */
    public function getEntries()
    {
        return $this->entries;
    }


    /**
     * Add entries
     *
     * @param \WojciechM\KramBundle\Entity\ShoppingListEntries $entries
     * @return ShoppingList
     */
    public function addEntry(\WojciechM\KramBundle\Entity\ShoppingListEntries $entries)
    {
        $this->entries[] = $entries;

        return $this;
    }

    /**
     * Remove entries
     *
     * @param \WojciechM\KramBundle\Entity\ShoppingListEntries $entries
     */
    public function removeEntry(\WojciechM\KramBundle\Entity\ShoppingListEntries $entries)
    {
        $this->entries->removeElement($entries);
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
    }
}

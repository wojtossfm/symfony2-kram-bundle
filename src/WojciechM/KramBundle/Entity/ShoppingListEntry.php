<?php

namespace WojciechM\KramBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ShoppingListEntry
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ShoppingListEntry
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="ShoppingList", inversedBy="entries")
     **/
    private $list;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     **/
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="users_shopping_votes")
     **/
    private $voters;

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
     * Set name
     *
     * @param string $name
     * @return ShoppingListEntry
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set list
     *
     * @param \WojciechM\KramBundle\Entity\ShoppingList $list
     * @return ShoppingListEntry
     */
    public function setList(\WojciechM\KramBundle\Entity\ShoppingList $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \WojciechM\KramBundle\Entity\ShoppingList 
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set user
     *
     * @param \WojciechM\KramBundle\Entity\User $user
     * @return ShoppingListEntry
     */
    public function setUser(\WojciechM\KramBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $this->addVoter($user);
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
     * Add voters
     *
     * @param \WojciechM\KramBundle\Entity\User $voters
     * @return ShoppingListEntry
     */
    public function addVoter(\WojciechM\KramBundle\Entity\User $voter)
    {
        if (!$this->voters->contains($voter)) {
            $this->voters[] = $voter;
        }
        return $this;
    }
    
    public function canVote(\WojciechM\KramBundle\Entity\User $voter)
    {
        return !$this->voters->contains($voter);
    }

    /**
     * Remove voters
     *
     * @param \WojciechM\KramBundle\Entity\User $voters
     */
    public function removeVoter(\WojciechM\KramBundle\Entity\User $voters)
    {
        $this->voters->removeElement($voters);
    }

    /**
     * Get voters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVoters()
    {
        return $this->voters;
    }
    
    public function __toString() {
        return $this->name;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->voters = new \Doctrine\Common\Collections\ArrayCollection();
    }
}

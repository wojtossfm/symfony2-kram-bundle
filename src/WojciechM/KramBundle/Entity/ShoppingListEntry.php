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
}

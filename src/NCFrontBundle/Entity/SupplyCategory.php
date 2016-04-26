<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplyCategory
 *
 * @ORM\Table(name="supply_category")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\SupplyCategoryRepository")
 */
class SupplyCategory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Supply", mappedBy="supplyCategory")
     */
    private $supplies;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return SupplyCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return SupplyCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSupplies()
    {
        return $this->supplies;
    }

    /**
     * @param ArrayCollection $supplies
     *
     * @return SupplyCategory
     */
    public function setSupplies($supplies)
    {
        $this->supplies = $supplies;

        return $this;
    }
}

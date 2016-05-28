<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Style
 *
 * @ORM\Table(name="style")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\StyleRepository")
 */
class Style
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
     * @ORM\Column(name="description", type="string", length=1500)
     */
    private $description;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Rank", mappedBy="style")
     */
    private $ranks;

    public function __construct()
    {
        $this->ranks = new ArrayCollection();
    }

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
     * @return Style
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
     * @return Style
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRanks()
    {
        return $this->ranks;
    }

    /**
     * @param ArrayCollection $ranks
     *
     * @return Style
     */
    public function setRanks($ranks)
    {
        $this->ranks = $ranks;

        return $this;
    }

    /**
     * @param Rank $rank
     *
     * @return $this
     */
    public function addRank(Rank $rank)
    {
        if(!$this->ranks->contains($rank)) {
            $this->ranks->add($rank);
        }

        return $this;
    }
}

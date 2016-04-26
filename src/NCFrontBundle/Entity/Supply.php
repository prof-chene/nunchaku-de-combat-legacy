<?php

namespace NCFrontBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Supply
 *
 * @ORM\Table(name="supply")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\SupplyRepository")
 */
class Supply
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
     * @var SupplyCategory
     *
     * @ORM\ManyToOne(targetEntity="SupplyCategory", inversedBy="supplies")
     */
    private $supplyCategory;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", mappedBy="supply")
     */
    private $medias;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Exercise", inversedBy="supplies")
     */
    private $exercises;

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
     * @return Supply
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
     * @return Supply
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return SupplyCategory
     */
    public function getSupplyCategory()
    {
        return $this->supplyCategory;
    }

    /**
     * @param SupplyCategory $supplyCategory
     *
     * @return Supply
     */
    public function setSupplyCategory($supplyCategory)
    {
        $this->supplyCategory = $supplyCategory;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param ArrayCollection $medias
     *
     * @return Supply
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * @param ArrayCollection $exercises
     *
     * @return Supply
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;

        return $this;
    }
}

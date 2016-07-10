<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractContent;
use NCBundle\Entity\Technique\Exercise;

/**
 * Supply
 *
 * @ORM\Table(name="supply")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\SupplyRepository")
 */
class Supply extends AbstractContent
{
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
     * @ORM\ManyToMany(targetEntity="Exercise", inversedBy="supplies")
     */
    private $exercises;

    public function __construct()
    {
        parent::__construct();
        $this->exercises = new ArrayCollection();
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

    /**
     * @param Exercise $exercise
     *
     * @return $this
     */
    public function addExercise(Exercise $exercise)
    {
        if(!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
        }

        return $this;
    }
}

<?php

namespace NCBundle\Entity\Technique;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Supply
 *
 * @ORM\Table(name="`supply`")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\SupplyRepository")
 */
class Supply extends AbstractEditorial
{
    /**
     * @var Collection
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Collection")
     */
    private $collection;
    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToMany(targetEntity="Exercise", mappedBy="supplies")
     */
    private $exercises;

    public function __construct()
    {
        parent::__construct();
        $this->exercises = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param Collection $collection
     *
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

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
     * @return $this
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
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
        }

        if (!$exercise->getSupplies()->contains($this)) {
            $exercise->addSupply($this);
        }

        return $this;
    }
}

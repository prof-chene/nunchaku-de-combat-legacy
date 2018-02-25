<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;
use NCBundle\Entity\Event\TrainingCourse;

/**
 * Exercise
 *
 * @ORM\Table(name="exercise")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\ExerciseRepository")
 */
class Exercise extends AbstractEditorial
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TechniqueExecution", mappedBy="exercise", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $techniqueExecutions;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="RankRequirement", mappedBy="exercise")
     */
    private $rankRequirements;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Supply", inversedBy="exercises")
     */
    private $supplies;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\Event\TrainingCourse", mappedBy="exercises")
     */
    private $trainingCourses;

    public function __construct()
    {
        parent::__construct();
        $this->techniqueExecutions = new ArrayCollection();
        $this->rankRequirements = new ArrayCollection();
        $this->supplies = new ArrayCollection();
        $this->trainingCourses = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTechniqueExecutions()
    {
        return $this->techniqueExecutions;
    }

    /**
     * @param ArrayCollection $techniqueExecutions
     *
     * @return $this
     */
    public function setTechniqueExecutions($techniqueExecutions)
    {
        $this->techniqueExecutions = $techniqueExecutions;

        return $this;
    }

    /**
     * @param TechniqueExecution $techniqueExecution
     *
     * @return $this
     */
    public function addTechniqueExecution(TechniqueExecution $techniqueExecution)
    {
        $techniqueExecution->setExercise($this);

        if (!$this->techniqueExecutions->contains($techniqueExecution)) {
            $this->techniqueExecutions->add($techniqueExecution);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRankRequirements()
    {
        return $this->rankRequirements;
    }

    /**
     * @param ArrayCollection $rankRequirements
     *
     * @return $this
     */
    public function setRankRequirements($rankRequirements)
    {
        $this->rankRequirements = $rankRequirements;

        return $this;
    }

    /**
     * @param RankRequirement $rankRequirement
     *
     * @return $this
     */
    public function addRankRequirement(RankRequirement $rankRequirement)
    {
        $rankRequirement->setExercise($this);

        if (!$this->rankRequirements->contains($rankRequirement)) {
            $this->rankRequirements->add($rankRequirement);
        }

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
     * @return $this
     */
    public function setSupplies($supplies)
    {
        $this->supplies = $supplies;

        return $this;
    }

    /**
     * @param Supply $supply
     *
     * @return $this
     */
    public function addSupply(Supply $supply)
    {
        if (!$this->supplies->contains($supply)) {
            $this->supplies->add($supply);
        }

        if (!$supply->getExercises()->contains($this)) {
            $supply->addExercise($this);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTrainingCourses()
    {
        return $this->trainingCourses;
    }

    /**
     * @param ArrayCollection $trainingCourses
     *
     * @return $this
     */
    public function setTrainingCourses($trainingCourses)
    {
        $this->trainingCourses = $trainingCourses;

        return $this;
    }

    /**
     * @param TrainingCourse $trainingCourse
     *
     * @return $this
     */
    public function addTrainingCourse(TrainingCourse $trainingCourse)
    {
        if (!$this->trainingCourses->contains($trainingCourse)) {
            $this->trainingCourses->add($trainingCourse);
        }

        if (!$trainingCourse->getExercises()->contains($this)) {
            $trainingCourse->addExercise($this);
        }

        return $this;
    }
}

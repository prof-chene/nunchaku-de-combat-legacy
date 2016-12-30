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
     * @ORM\OneToMany(targetEntity="TechniqueExecution", mappedBy="exercise")
     */
    private $techniqueExecutions;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SyllabusRequirement", mappedBy="exercise")
     */
    private $syllabusRequirements;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Supply", mappedBy="exercises")
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
        $this->syllabusRequirements = new ArrayCollection();
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
        if (!$this->techniqueExecutions->contains($techniqueExecution)) {
            $this->techniqueExecutions->add($techniqueExecution);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSyllabusRequirements()
    {
        return $this->syllabusRequirements;
    }

    /**
     * @param ArrayCollection $syllabusRequirements
     *
     * @return $this
     */
    public function setSyllabusRequirements($syllabusRequirements)
    {
        $this->syllabusRequirements = $syllabusRequirements;

        return $this;
    }

    /**
     * @param SyllabusRequirement $syllabusRequirement
     *
     * @return $this
     */
    public function addSyllabusRequirement(SyllabusRequirement $syllabusRequirement)
    {
        if (!$this->syllabusRequirements->contains($syllabusRequirement)) {
            $this->syllabusRequirements->add($syllabusRequirement);
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

        return $this;
    }
}

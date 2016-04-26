<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise
 *
 * @ORM\Table(name="exercise")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\ExerciseRepository")
 */
class Exercise
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
     * @ORM\OneToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", mappedBy="exercise")
     */
    private $medias;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ExerciseCategory", inversedBy="exercises")
     */
    private $exerciseCategories;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="EventTrainingCourse", mappedBy="exercises")
     */
    private $eventTrainingCourses;

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
     * @return Exercise
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
     * @return Exercise
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @return Exercise
     */
    public function setTechniqueExecutions($techniqueExecutions)
    {
        $this->techniqueExecutions = $techniqueExecutions;

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
     * @return Exercise
     */
    public function setSyllabusRequirements($syllabusRequirements)
    {
        $this->syllabusRequirements = $syllabusRequirements;

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
     * @return Exercise
     */
    public function setSupplies($supplies)
    {
        $this->supplies = $supplies;

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
     * @return Technique
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getExerciseCategories()
    {
        return $this->exerciseCategories;
    }

    /**
     * @param ArrayCollection $exerciseCategories
     *
     * @return Exercise
     */
    public function setExerciseCategories($exerciseCategories)
    {
        $this->exerciseCategories = $exerciseCategories;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEventTrainingCourses()
    {
        return $this->eventTrainingCourses;
    }

    /**
     * @param ArrayCollection $eventTrainingCourses
     *
     * @return Exercise
     */
    public function setEventTrainingCourses($eventTrainingCourses)
    {
        $this->eventTrainingCourses = $eventTrainingCourses;

        return $this;
    }
}

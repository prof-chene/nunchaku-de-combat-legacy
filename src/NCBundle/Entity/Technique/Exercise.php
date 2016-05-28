<?php

namespace NCBundle\Entity\Technique;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\Event\EventTrainingCourse;
use NCBundle\Entity\Technique\Supply;

/**
 * Exercise
 *
 * @ORM\Table(name="exercise")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\ExerciseRepository")
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category", inversedBy="exercises")
     */
    private $category;
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
     * @ORM\OneToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", mappedBy="exercise")
     */
    private $medias;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Supply", mappedBy="exercises")
     */
    private $supplies;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\Event\EventTrainingCourse", mappedBy="exercises")
     */
    private $eventTrainingCourses;

    public function __construct()
    {
        $this->techniqueExecutions = new ArrayCollection();
        $this->syllabusRequirements = new ArrayCollection();
        $this->supplies = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->eventTrainingCourses = new ArrayCollection();
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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return Exercise
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

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
     * @param TechniqueExecution $techniqueExecution
     *
     * @return $this
     */
    public function addTechniqueExecution(TechniqueExecution $techniqueExecution)
    {
        if(!$this->techniqueExecutions->contains($techniqueExecution)) {
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
     * @return Exercise
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
        if(!$this->syllabusRequirements->contains($syllabusRequirement)) {
            $this->syllabusRequirements->add($syllabusRequirement);
        }

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
     * @param Media $media
     *
     * @return $this
     */
    public function addMedia(Media $media)
    {
        if(!$this->medias->contains($media)) {
            $this->medias->add($media);
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
     * @return Exercise
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
        if(!$this->supplies->contains($supply)) {
            $this->supplies->add($supply);
        }

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

    /**
     * @param EventTrainingCourse $eventTrainingCourse
     *
     * @return $this
     */
    public function addEventTrainingCourse(EventTrainingCourse $eventTrainingCourse)
    {
        if(!$this->eventTrainingCourses->contains($eventTrainingCourse)) {
            $this->eventTrainingCourses->add($eventTrainingCourse);
        }

        return $this;
    }
}

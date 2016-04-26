<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseCategory
 *
 * @ORM\Table(name="exercise_category")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\ExerciseCategoryRepository")
 */
class ExerciseCategory
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
     * @ORM\ManyToMany(targetEntity="Exercise", mappedBy="exerciseCategories")
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
     * @return ExerciseCategory
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
     * @return ExerciseCategory
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
     * @return ExerciseCategory
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;

        return $this;
    }
}

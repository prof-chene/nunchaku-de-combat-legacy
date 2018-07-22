<?php

namespace NCBundle\Entity\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\Technique\Exercise;

/**
 * TrainingCourse
 *
 * @ORM\Table(name="training_course")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\TrainingCourseRepository")
 */
class TrainingCourse extends AbstractEvent
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\Technique\Exercise", inversedBy="trainingCourses")
     * )
     */
    private $exercises;

    public function __construct()
    {
        parent::__construct();
        $this->exercises = new ArrayCollection();
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

        if(!$exercise->getTrainingCourses()->contains($this)) {
            $exercise->addTrainingCourse($this);
        }

        return $this;
    }
}

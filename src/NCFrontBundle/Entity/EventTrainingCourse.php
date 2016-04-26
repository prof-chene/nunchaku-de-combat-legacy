<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventTrainingCourse
 *
 * @ORM\Table(name="event_training_course")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\EventTrainingCourseRepository")
 */
class EventTrainingCourse extends Event
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Participant", inversedBy="eventTrainingCourses")
     */
    private $trainers;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Exercise", inversedBy="eventTrainingCourses")
     */
    private $exercises;

    /**
     * @return ArrayCollection
     */
    public function getTrainers()
    {
        return $this->trainers;
    }

    /**
     * @param ArrayCollection $trainers
     *
     * @return EventTrainingCourse
     */
    public function setTrainers($trainers)
    {
        $this->trainers = $trainers;

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
     * @return EventTrainingCourse
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
        return $this;
    }
}

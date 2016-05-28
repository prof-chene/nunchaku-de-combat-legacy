<?php

namespace NCBundle\Entity\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\Technique\Exercise;

/**
 * EventTrainingCourse
 *
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\EventTrainingCourseRepository")
 */
class EventTrainingCourse extends Event
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Participant", inversedBy="eventTrainingCourses")
     * @ORM\JoinTable(name="event_trainer",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="participant_id", referencedColumnName="id")}
     *      )
     */
    private $trainers;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\Technique\Exercise", inversedBy="eventTrainingCourses")
     * @ORM\JoinTable(name="event_exercise",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="exercise_id", referencedColumnName="id")}
     *      )
     */
    private $exercises;

    public function __construct()
    {
        parent::__construct();
        $this->trainers = new ArrayCollection();
        $this->exercises = new ArrayCollection();
    }

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
     * @param Participant $trainer
     *
     * @return $this
     */
    public function addTrainer(Participant $trainer)
    {
        if(!$this->trainers->contains($trainer)) {
            $this->trainers->add($trainer);
        }

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

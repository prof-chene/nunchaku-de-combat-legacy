<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventCompetition
 *
 * @ORM\Table(name="event_competition")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\EventCompetitionRepository")
 */
class EventCompetition extends Event
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Trial", mappedBy="eventCompetition")
     */
    private $trials;

    /**
     * @return ArrayCollection
     */
    public function getTrials()
    {
        return $this->trials;
    }

    /**
     * @param ArrayCollection $trials
     *
     * @return EventCompetition
     */
    public function setTrials($trials)
    {
        $this->trials = $trials;

        return $this;
    }
}

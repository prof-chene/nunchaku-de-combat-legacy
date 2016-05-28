<?php

namespace NCBundle\Entity\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EventCompetition
 *
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\EventCompetitionRepository")
 */
class EventCompetition extends Event
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Trial", mappedBy="eventCompetition")
     */
    private $trials;

    public function __construct()
    {
        parent::__construct();
        $this->trials = new ArrayCollection();
    }

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

    /**
     * @param Trial $trial
     *
     * @return $this
     */
    public function addTrial(Trial $trial)
    {
        if(!$this->trials->contains($trial)) {
            $this->trials->add($trial);
        }

        return $this;
    }
}

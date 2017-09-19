<?php

namespace NCBundle\Entity\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Competition
 *
 * @ORM\Table(name="competition")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\CompetitionRepository")
 */
class Competition extends AbstractEvent
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Trial", mappedBy="competition", cascade={"persist", "remove"})
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
     * @return $this
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
        if (!$this->trials->contains($trial)) {
            $this->trials->add($trial);
        }

        return $this;
    }
}

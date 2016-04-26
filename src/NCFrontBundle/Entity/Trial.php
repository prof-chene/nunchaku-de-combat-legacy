<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trial
 *
 * @ORM\Table(name="trial")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\TrialRepository")
 */
class Trial
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
     * @ORM\Column(name="name", type="string", length=1500)
     */
    private $rules;
    /**
     * @var EventCompetition
     *
     * @ORM\ManyToOne(targetEntity="EventCompetition", inversedBy="trials")
     */
    private $eventCompetition;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TrialResult", mappedBy="trial")
     */
    private $trialResults;

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
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $rules
     *
     * @return Trial
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @return EventCompetition
     */
    public function getEventCompetition()
    {
        return $this->eventCompetition;
    }

    /**
     * @param EventCompetition $eventCompetition
     *
     * @return Trial
     */
    public function setEventCompetition($eventCompetition)
    {
        $this->eventCompetition = $eventCompetition;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTrialResults()
    {
        return $this->trialResults;
    }

    /**
     * @param ArrayCollection $trialResults
     *
     * @return Trial
     */
    public function setTrialResults($trialResults)
    {
        $this->trialResults = $trialResults;

        return $this;
    }
}

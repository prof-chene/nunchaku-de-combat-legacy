<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrialResult
 *
 * @ORM\Table(name="trial_result")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\TrialResultRepository")
 */
class TrialResult
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
     * @var int
     *
     * @ORM\Column(name="place", type="integer", length=5)
     */
    private $place;
    /**
     * @var Trial
     *
     * @ORM\ManyToOne(targetEntity="Trial", inversedBy="trialResults")
     */
    private $trial;
    /**
     * @var Trial
     *
     * @ORM\ManyToOne(targetEntity="Participant", inversedBy="trialResults")
     */
    private $participant;

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
     * @return int
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param int $place
     *
     * @return TrialResult
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Trial
     */
    public function getTrial()
    {
        return $this->trial;
    }

    /**
     * @param Trial $trial
     *
     * @return TrialResult
     */
    public function setTrial($trial)
    {
        $this->trial = $trial;

        return $this;
    }

    /**
     * @return Trial
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param Trial $participant
     *
     * @return TrialResult
     */
    public function setParticipant($participant)
    {
        $this->participant = $participant;

        return $this;
    }
}

<?php

namespace NCBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * TrialResult
 *
 * @UniqueEntity(
 *     fields={"trial", "place"},
 *     errorPath="place",
 *     message="place.unique"
 * )
 *
 * @ORM\Table(name="`trial_result`", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_trial_place", columns={"trial_id", "place"})
 * })
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\TrialResultRepository")
 */
class TrialResult
{
    /**
     * @var Trial
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Trial", inversedBy="trialResults")
     */
    private $trial;
    /**
     * @var Participant
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Participant", inversedBy="trialResults")
     */
    private $participant;
    /**
     * @var int
     *
     * @Assert\Range(max=99999)
     *
     * @ORM\Column(name="place", type="integer", length=5, nullable=true)
     */
    private $place;

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
     * @return $this
     */
    public function setTrial($trial)
    {
        $this->trial = $trial;

        return $this;
    }

    /**
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param Participant $participant
     *
     * @return $this
     */
    public function setParticipant(Participant $participant)
    {
        $this->participant = $participant;

        return $this;
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
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getParticipant()->getEvent() != $this->getTrial()->getCompetition()) {
            $context->buildViolation('trial_result.competition.mismatch')->addViolation();
        }
    }
}

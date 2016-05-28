<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Technique\Rank;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * Class User
 * @package Application\Sonata\UserBundle\Entity
 */
class User extends BaseUser
{
    /**
     * @var int $id
     */
    protected $id;
    /**
     * @var Rank
     */
    protected $rank;
    /**
     * @var ArrayCollection
     */
    protected $participants;

    public function __construct()
    {
        parent::__construct();
        $this->participants = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param Rank $rank
     *
     * @return User
     */
    public function setRank(Rank $rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param ArrayCollection $participants
     *
     * @return User
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }

    /**
     * @param Participant $participant
     *
     * @return $this
     */
    public function addParticipant(Participant $participant)
    {
        if(!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }
}

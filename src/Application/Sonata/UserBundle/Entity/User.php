<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use NCFrontBundle\Entity\Rank;
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
}

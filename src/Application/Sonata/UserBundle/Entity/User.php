<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Technique\Rank;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;

/**
 * Class User
 * @package Application\Sonata\UserBundle\Entity
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class User extends BaseUser
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var Rank
     *
     * @ORM\ManyToOne(targetEntity="NCBundle\Entity\Technique\Rank", inversedBy="users")
     */
    protected $rank;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NCBundle\Entity\Event\Participant", mappedBy="user")
     */
    protected $participants;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="user_role_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

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

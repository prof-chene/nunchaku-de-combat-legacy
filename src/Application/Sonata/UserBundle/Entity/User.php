<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Technique\Rank;
use NCBundle\Entity\Technique\RankHolder;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package Application\Sonata\UserBundle\Entity
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 *
 * @UniqueEntity(
 *     fields={"username"},
 *     message="fos_user.username.already_used"
 * )
 * @UniqueEntity(
 *     fields={"usernameCanonical"},
 *     message="fos_user.username.already_used"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="fos_user.email.already_used"
 * )
 * @UniqueEntity(
 *     fields={"emailCanonical"},
 *     message="fos_user.email.already_used"
 * )
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
     * @var string
     *
     * @Assert\Email
     */
    protected $email;
    /**
     * @var string
     *
     * @Assert\Email
     */
    protected $emailCanonical;
    /**
     * @var Rank
     *
     * @ORM\OneToMany(targetEntity="NCBundle\Entity\Technique\RankHolder", mappedBy="holder")
     */
    protected $ranks;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NCBundle\Entity\Event\Participant", mappedBy="user")
     */
    protected $participants;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NCBundle\Entity\Event\Participant", mappedBy="registrant")
     */
    protected $registrants;

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
        $this->ranks = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->registrants = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getRanks()
    {
        return $this->rank;
    }

    /**
     * @param ArrayCollection $ranks
     *
     * @return User
     */
    public function setRanks($ranks)
    {
        $this->ranks = $ranks;

        return $this;
    }

    /**
     * @param RankHolder $rank
     *
     * @return $this
     */
    public function addRank(RankHolder $rank)
    {
        if(!$this->ranks->contains($rank)) {
            $this->ranks->add($rank);
        }

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

    /**
     * @return ArrayCollection
     */
    public function getRegistrants()
    {
        return $this->registrants;
    }

    /**
     * @param ArrayCollection $registrants
     *
     * @return User
     */
    public function setRegistrants($registrants)
    {
        $this->registrants = $registrants;

        return $this;
    }

    /**
     * @param Participant $registrant
     *
     * @return $this
     */
    public function addRegistrant(Participant $registrant)
    {
        if(!$this->registrants->contains($registrant)) {
            $this->registrants->add($registrant);
        }

        return $this;
    }
}

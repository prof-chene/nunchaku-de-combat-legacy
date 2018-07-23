<?php

namespace NCBundle\Entity\Event;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\ParticipantRepository")
 */
class Participant
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
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    private $firstname;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    private $lastname;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100, nullable=true)
     */
    private $phone;
    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     *
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    private $dateOfBirth;
    /**
     * @var string
     *
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;
    /**
     * @var bool
     *
     * @ORM\Column(name="host", type="boolean", nullable=true)
     */
    private $host;
    /**
     * @var bool
     *
     * @ORM\Column(name="trainer", type="boolean", nullable=true)
     */
    private $trainer;
    /**
     * @var bool
     *
     * @ORM\Column(name="referee", type="boolean", nullable=true)
     */
    private $referee;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="participants")
     */
    private $user;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="registrants")
     */
    private $registrant;
    /**
     * @var AbstractEvent
     *
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="AbstractEvent", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TrialResult", mappedBy="participant", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $trialResults;

    public function __construct()
    {
        $this->trialResults = new ArrayCollection();
    }

    public function __toString()
    {
        return '('.$this->getEvent().') '.$this->getFullName();
    }

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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     *
     * @return $this
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHost()
    {
        return $this->host;
    }

    /**
     * @param boolean $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isTrainer()
    {
        return $this->trainer;
    }

    /**
     * @param boolean $trainer
     */
    public function setTrainer($trainer)
    {
        $this->trainer = $trainer;
    }

    /**
     * @return boolean
     */
    public function isReferee()
    {
        return $this->referee;
    }

    /**
     * @param boolean $referee
     */
    public function setReferee($referee)
    {
        $this->referee = $referee;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getRegistrant()
    {
        return $this->registrant;
    }

    /**
     * @param User $registrant
     *
     * @return $this
     */
    public function setRegistrant(User $registrant)
    {
        $this->registrant = $registrant;

        return $this;
    }

    /**
     * @return AbstractEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param AbstractEvent $event
     *
     * @return $this
     */
    public function setEvent(AbstractEvent $event)
    {
        $this->event = $event;

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
     * @return $this
     */
    public function setTrialResults($trialResults)
    {
        $this->trialResults = $trialResults;

        return $this;
    }

    /**
     * @param TrialResult $trialResult
     *
     * @return $this
     */
    public function addTrialResult(TrialResult $trialResult)
    {
        $trialResult->setParticipant($this);

        if (!$this->trialResults->contains($trialResult)) {
            $this->trialResults->add($trialResult);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname().' '.$this->getLastname();
    }
}

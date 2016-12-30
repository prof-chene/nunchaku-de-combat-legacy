<?php

namespace NCBundle\Entity\Event;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    private $firstname;
    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    private $lastname;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100)
     */
    private $phone;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="datetime")
     */
    private $dateOfBirth;
    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TrialResult", mappedBy="participant")
     */
    private $trialResults;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="AbstractEvent", inversedBy="participants")
     */
    private $event;

    public function __construct()
    {
        $this->trialResults = new ArrayCollection();
        $this->events = new ArrayCollection();
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
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

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
    public function setUser(User $user)
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
        if (!$this->trialResults->contains($trialResult)) {
            $this->trialResults->add($trialResult);
        }

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
}

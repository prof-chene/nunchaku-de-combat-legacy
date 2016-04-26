<?php

namespace NCFrontBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\ParticipantRepository")
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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="participants")
     */
    private $events;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="EventTrainingCourse", mappedBy="trainers")
     */
    private $eventTrainingCourses;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TrialResult", mappedBy="participant")
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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return Participant
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
     * @return Participant
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
     * @return Participant
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
     * @return Participant
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
     * @return Participant
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
     * @return Participant
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
     * @return Participant
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection $events
     *
     * @return Participant
     */
    public function setEvents($events)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEventTrainingCourses()
    {
        return $this->eventTrainingCourses;
    }

    /**
     * @param ArrayCollection $eventTrainingCourses
     *
     * @return Participant
     */
    public function setEventTrainingCourses($eventTrainingCourses)
    {
        $this->eventTrainingCourses = $eventTrainingCourses;

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
     * @return Participant
     */
    public function setTrialResults($trialResults)
    {
        $this->trialResults = $trialResults;

        return $this;
    }
}

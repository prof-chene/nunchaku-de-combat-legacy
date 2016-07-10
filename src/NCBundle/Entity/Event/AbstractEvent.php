<?php

namespace NCBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractContent;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
abstract class AbstractEvent extends AbstractContent
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=500)
     */
    private $address;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Participant", inversedBy="events")
     * @ORM\JoinTable(name="event_participant",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="participant_id", referencedColumnName="id")}
     *  )
     */
    private $participants;

    public function __construct()
    {
        parent::__construct();
        $this->participants = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

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
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

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
     * @return Event
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

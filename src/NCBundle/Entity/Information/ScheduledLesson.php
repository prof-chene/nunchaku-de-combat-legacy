<?php

namespace NCBundle\Entity\Information;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ScheduledLesson
 *
 * @ORM\Table(name="scheduled_lesson")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Information\ScheduledLessonRepository")
 */
class ScheduledLesson
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
     * @Assert\NotBlank()
     * @Assert\Range(
     *     min = 1,
     *     max = 7,
     * )
     *
     * @ORM\Column(name="day_of_the_week", type="integer", length=1)
     */
    private $dayOfTheWeek;
    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @Assert\Time()
     *
     * @ORM\Column(name="start_time", type="time")
     */
    private $startTime;
    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @Assert\Time()
     *
     * @ORM\Column(name="end_time", type="time")
     */
    private $endTime;
    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=100, nullable=true)
     */
    private $details;
    /**
     * @var Club
     *
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="scheduledLessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDayOfTheWeek()
    {
        return $this->dayOfTheWeek;
    }

    /**
     * @param string $dayOfTheWeek
     *
     * @return $this
     */
    public function setDayOfTheWeek($dayOfTheWeek)
    {
        $this->dayOfTheWeek = $dayOfTheWeek;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     *
     * @return $this
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     *
     * @return $this
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     *
     * @return $this
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param Club $club
     *
     * @return $this
     */
    public function setClub($club)
    {
        $this->club = $club;

        return $this;
    }
}

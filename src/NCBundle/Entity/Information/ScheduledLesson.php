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
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice({"monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"})
     *
     * @ORM\Column(name="day_of_the_week", type="string", length=9)
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
     * @var Club
     *
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="scheduledLessons")
     */
    private $club;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDayOfTheWeek(): string
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
    public function getStartTime(): \DateTime
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
    public function getEndTime(): \DateTime
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
     * @return Club
     */
    public function getClub(): Club
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

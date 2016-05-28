<?php

namespace NCBundle\Entity\Technique;

use Doctrine\ORM\Mapping as ORM;

/**
 * SyllabusRequirement
 *
 * @ORM\Table(name="syllabus_requirement")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\SyllabusRequirementRepository")
 */
class SyllabusRequirement
{
    /**
     * @var Exercise
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="syllabusRequirements")
     */
    private $exercise;
    /**
     * @var Syllabus
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Syllabus", inversedBy="syllabusRequirements")
     */
    private $syllabus;
    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=1500)
     */
    private $detail;
    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer", length=5)
     */
    private $points;

    /**
     * @return Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     *
     * @return SyllabusRequirement
     */
    public function setExercise($exercise)
    {
        $this->exercise = $exercise;

        return $this;
    }

    /**
     * @return Syllabus
     */
    public function getSyllabus()
    {
        return $this->syllabus;
    }

    /**
     * @param Syllabus $syllabus
     *
     * @return SyllabusRequirement
     */
    public function setSyllabus($syllabus)
    {
        $this->syllabus = $syllabus;

        return $this;
    }

    /**
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     *
     * @return SyllabusRequirement
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     *
     * @return SyllabusRequirement
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }
}

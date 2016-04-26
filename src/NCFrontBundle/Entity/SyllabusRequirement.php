<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SyllabusRequirement
 *
 * @ORM\Table(name="syllabus_requirement")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\SyllabusRequirementRepository")
 */
class SyllabusRequirement
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
     * @var Exercise
     *
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="syllabusRequirements")
     */
    private $exercise;
    /**
     * @var Syllabus
     *
     * @ORM\ManyToOne(targetEntity="Syllabus", inversedBy="syllabusRequirements")
     */
    private $syllabus;

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
}

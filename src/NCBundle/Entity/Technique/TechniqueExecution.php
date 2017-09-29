<?php

namespace NCBundle\Entity\Technique;

use Doctrine\ORM\Mapping as ORM;

/**
 * TechniqueExecution
 *
 * @ORM\Table(name="technique_execution")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\TechniqueExecutionRepository")
 */
class TechniqueExecution
{
    /**
     * @var Technique
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Technique", inversedBy="techniqueExecutions")
     */
    private $technique;
    /**
     * @var Exercise
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="techniqueExecutions")
     */
    private $exercise;
    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=500, nullable=true)
     */
    private $detail;

    /**
     * @return string
     */
    public function __toString()
    {
        $toString = (string)$this->getTechnique()->getTitle();
        if (!empty($this->getDetail())) {
            $toString .= " : ".(string)$this->getDetail();
        }

        return $toString;
    }

    /**
     * @return Technique
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * @param Technique $technique
     *
     * @return $this
     */
    public function setTechnique($technique)
    {
        $this->technique = $technique;

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
     * @return $this
     */
    public function setExercise($exercise)
    {
        $this->exercise = $exercise;

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
     * @return $this
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }
}

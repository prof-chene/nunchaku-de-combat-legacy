<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TechniqueExecution
 *
 * @ORM\Table(name="technique_execution")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\TechniqueExecutionRepository")
 */
class TechniqueExecution
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
     * @ORM\Column(name="detail", type="string", length=500)
     */
    private $detail;
    /**
     * @var int
     *
     * @ORM\Column(name="order", type="integer", length=5)
     */
    private $order;
    /**
     * @var Technique
     *
     * @ORM\ManyToOne(targetEntity="Technique", inversedBy="techniqueExecutions")
     */
    private $technique;
    /**
     * @var Exercise
     *
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="techniqueExecutions")
     */
    private $exercise;

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
     * @return TechniqueExecution
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     *
     * @return TechniqueExecution
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
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
     * @return TechniqueExecution
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
     * @return TechniqueExecution
     */
    public function setExercise($exercise)
    {
        $this->exercise = $exercise;

        return $this;
    }
}

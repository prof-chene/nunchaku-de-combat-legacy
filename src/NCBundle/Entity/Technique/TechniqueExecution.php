<?php

namespace NCBundle\Entity\Technique;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TechniqueExecution
 *
 * @ORM\Table(name="technique_execution")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\TechniqueExecutionRepository")
 */
class TechniqueExecution implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @ORM\Column(name="detail", type="string", length=500, nullable=true)
     */
    private $detail;
    /**
     * @var string
     *
     * @Gedmo\Locale
     */
    private $locale;
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
     * @return int
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
     * @return $this
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;

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
}

<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;

/**
 * Technique
 *
 * @ORM\Table(name="technique")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\TechniqueRepository")
 */
class Technique extends AbstractEditorial
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TechniqueExecution", mappedBy="technique")
     */
    private $techniqueExecutions;

    public function __construct()
    {
        parent::__construct();
        $this->techniqueExecutions = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTechniqueExecutions()
    {
        return $this->techniqueExecutions;
    }

    /**
     * @param ArrayCollection $techniqueExecutions
     *
     * @return $this
     */
    public function setTechniqueExecutions($techniqueExecutions)
    {
        $this->techniqueExecutions = $techniqueExecutions;

        return $this;
    }

    /**
     * @param TechniqueExecution $techniqueExecution
     *
     * @return $this
     */
    public function addTechniqueExecution(TechniqueExecution $techniqueExecution)
    {
        if (!$this->techniqueExecutions->contains($techniqueExecution)) {
            $this->techniqueExecutions->add($techniqueExecution);
        }

        return $this;
    }
}

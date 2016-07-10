<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractContent;

/**
 * Technique
 *
 * @ORM\Table(name="technique")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\TechniqueRepository")
 */
class Technique extends AbstractContent
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
     * @ORM\Column(name="description", type="string", length=1500)
     */
    private $description;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Technique
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
     * @return Technique
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @return Technique
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
        if(!$this->techniqueExecutions->contains($techniqueExecution)) {
            $this->techniqueExecutions->add($techniqueExecution);
        }

        return $this;
    }
}

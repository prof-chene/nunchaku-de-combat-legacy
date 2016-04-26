<?php

namespace NCFrontBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Technique
 *
 * @ORM\Table(name="technique")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\TechniqueRepository")
 */
class Technique
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
     * @var TechniqueCategory
     *
     * @ORM\ManyToOne(targetEntity="TechniqueCategory", inversedBy="techniques")
     */
    private $techniqueCategory;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TechniqueExecution", mappedBy="technique")
     */
    private $techniqueExecutions;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", mappedBy="technique")
     */
    private $medias;

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
     * @return mixed
     */
    public function getTechniqueCategory()
    {
        return $this->techniqueCategory;
    }

    /**
     * @param mixed $techniqueCategory
     *
     * @return Technique
     */
    public function setTechniqueCategory($techniqueCategory)
    {
        $this->techniqueCategory = $techniqueCategory;

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
     * @return ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param ArrayCollection $medias
     *
     * @return Technique
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;

        return $this;
    }
}

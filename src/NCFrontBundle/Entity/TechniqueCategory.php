<?php

namespace NCFrontBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TechniqueCategory
 *
 * @ORM\Table(name="technique_category")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\TechniqueCategoryRepository")
 */
class TechniqueCategory
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
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    /**
     * @ORM\OneToMany(targetEntity="Technique", mappedBy="techniqueCategory")
     */
    private $techniques;

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
     * @return TechniqueCategory
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
     * @return TechniqueCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * @param ArrayCollection $techniques
     *
     * @return TechniqueCategory
     */
    public function setTechniques($techniques)
    {
        $this->techniques = $techniques;

        return $this;
    }
}

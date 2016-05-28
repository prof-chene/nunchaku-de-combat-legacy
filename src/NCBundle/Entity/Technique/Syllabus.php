<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Syllabus
 *
 * @ORM\Table(name="syllabus")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\SyllabusRepository")
 */
class Syllabus
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
     * @var Rank
     *
     * @ORM\ManyToOne(targetEntity="Rank", inversedBy="syllabuses")
     */
    private $rank;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SyllabusRequirement", mappedBy="syllabus")
     */
    private $syllabusRequirements;

    public function __construct()
    {
        $this->syllabusRequirements = new ArrayCollection();
    }

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
     * @return Syllabus
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
     * @return Syllabus
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param Rank $rank
     * @return Syllabus
     */
    public function setRank(Rank $rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSyllabusRequirements()
    {
        return $this->syllabusRequirements;
    }

    /**
     * @param ArrayCollection $syllabusRequirements
     *
     * @return Syllabus
     */
    public function setSyllabusRequirements($syllabusRequirements)
    {
        $this->syllabusRequirements = $syllabusRequirements;

        return $this;
    }

    /**
     * @param SyllabusRequirement $syllabusRequirement
     *
     * @return $this
     */
    public function addSyllabusRequirement(SyllabusRequirement $syllabusRequirement)
    {
        if(!$this->syllabusRequirements->contains($syllabusRequirement)) {
            $this->syllabusRequirements->add($syllabusRequirement);
        }

        return $this;
    }
}

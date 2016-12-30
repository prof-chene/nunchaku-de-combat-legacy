<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;

/**
 * Syllabus
 *
 * @ORM\Table(name="syllabus")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\SyllabusRepository")
 */
class Syllabus extends AbstractEditorial
{
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
        parent::__construct();
        $this->syllabusRequirements = new ArrayCollection();
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
     *
     * @return $this
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
     * @return $this
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
        if (!$this->syllabusRequirements->contains($syllabusRequirement)) {
            $this->syllabusRequirements->add($syllabusRequirement);
        }

        return $this;
    }
}

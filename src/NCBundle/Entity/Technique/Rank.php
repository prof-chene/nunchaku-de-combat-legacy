<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;

/**
 * Rank
 *
 * @ORM\Table(name="rank")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\RankRepository")
 */
class Rank extends AbstractEditorial
{
    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", length=5)
     */
    private $level;
    /**
     * @var Style
     *
     * @ORM\ManyToOne(targetEntity="Style", inversedBy="ranks")
     */
    private $style;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Syllabus", mappedBy="rank")
     */
    private $syllabuses;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="RankHolder", mappedBy="rank")
     */
    private $holders;

    public function __construct()
    {
        parent::__construct();
        $this->syllabuses = new ArrayCollection();
        $this->holders = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param Style $style
     *
     * @return $this
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSyllabuses()
    {
        return $this->syllabuses;
    }

    /**
     * @param ArrayCollection $syllabuses
     *
     * @return $this
     */
    public function setSyllabuses($syllabuses)
    {
        $this->syllabuses = $syllabuses;

        return $this;
    }

    /**
     * @param Syllabus $syllabus
     *
     * @return $this
     */
    public function addSyllabus(Syllabus $syllabus)
    {
        if (!$this->syllabuses->contains($syllabus)) {
            $this->syllabuses->add($syllabus);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getHolders()
    {
        return $this->holders;
    }

    /**
     * @param ArrayCollection $holders
     *
     * @return $this
     */
    public function setHolders($holders)
    {
        $this->holders = $holders;

        return $this;
    }

    /**
     * @param RankHolder $holder
     *
     * @return $this
     */
    public function addHolder(RankHolder $holder)
    {
        if (!$this->holders->contains($holder)) {
            $this->holders->add($holder);
        }

        return $this;
    }
}

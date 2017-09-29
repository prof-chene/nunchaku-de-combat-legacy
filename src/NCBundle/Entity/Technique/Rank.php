<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Rank
 *
 * @ORM\Table(name="rank")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\RankRepository")
 *
 * @UniqueEntity(
 *     fields={"level", "style"},
 *     message="rank_level.already_exists"
 * )
 */
class Rank extends AbstractEditorial
{
    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", length=5, nullable=true)
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
     * @ORM\OneToMany(targetEntity="RankRequirement", mappedBy="rank")
     */
    private $rankRequirements;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="RankHolder", mappedBy="rank")
     */
    private $holders;

    public function __construct()
    {
        parent::__construct();
        $this->rankRequirements = new ArrayCollection();
        $this->holders = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $toString = (string)$this->getTitle();
        if (!empty($this->getStyle())) {
            $toString .= " ".(string)$this->getStyle()->getTitle();
        }

        return $toString;
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
    public function getRankRequirements()
    {
        return $this->rankRequirements;
    }

    /**
     * @param ArrayCollection $rankRequirements
     *
     * @return $this
     */
    public function setRankRequirements($rankRequirements)
    {
        $this->rankRequirements = $rankRequirements;

        return $this;
    }

    /**
     * @param RankRequirement $rankRequirement
     *
     * @return $this
     */
    public function addRankRequirement(RankRequirement $rankRequirement)
    {
        $rankRequirement->setRank($this);

        if (!$this->rankRequirements->contains($rankRequirement)) {
            $this->rankRequirements->add($rankRequirement);
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
        $holder->setRank($this);

        if (!$this->holders->contains($holder)) {
            $this->holders->add($holder);
        }

        return $this;
    }
}

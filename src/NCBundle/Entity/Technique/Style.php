<?php

namespace NCBundle\Entity\Technique;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;

/**
 * Style
 *
 * @ORM\Table(name="style")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\StyleRepository")
 */
class Style extends AbstractEditorial
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Rank", mappedBy="style")
     * @Orm\OrderBy({"level" = "ASC"})
     */
    private $ranks;

    public function __construct()
    {
        parent::__construct();
        $this->ranks = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getRanks()
    {
        return $this->ranks;
    }

    /**
     * @param ArrayCollection $ranks
     *
     * @return $this
     */
    public function setRanks($ranks)
    {
        $this->ranks = $ranks;

        return $this;
    }

    /**
     * @param Rank $rank
     *
     * @return $this
     */
    public function addRank(Rank $rank)
    {
        $rank->setStyle($this);

        if (!$this->ranks->contains($rank)) {
            $this->ranks->add($rank);
        }

        return $this;
    }
}

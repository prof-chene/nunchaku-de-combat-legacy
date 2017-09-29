<?php

namespace NCBundle\Entity\Technique;

use Doctrine\ORM\Mapping as ORM;

/**
 * RankRequirement
 *
 * @ORM\Table(name="rank_requirement")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\RankRequirementRepository")
 */
class RankRequirement
{
    /**
     * @var Exercise
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="rankRequirements")
     */
    private $exercise;
    /**
     * @var Rank
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Rank", inversedBy="rankRequirements")
     */
    private $rank;
    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="string", length=1500)
     */
    private $detail;
    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer", length=5)
     */
    private $points;

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
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
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
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     *
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }
}

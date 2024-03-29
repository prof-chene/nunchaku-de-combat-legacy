<?php

namespace NCBundle\Entity\Technique;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RankRequirement
 *
 * @ORM\Table(name="`rank_requirement`")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\RankRequirementRepository")
 */
class RankRequirement implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="detail", type="string", length=1500)
     */
    private $detail;
    /**
     * @var int
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="points", type="integer", length=5)
     */
    private $points;
    /**
     * @var string
     *
     * @Gedmo\Locale
     */
    private $locale;
    /**
     * @var Exercise
     *
     * @Assert\NotBlank()
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Exercise", inversedBy="rankRequirements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercise;
    /**
     * @var Rank
     *
     * @Assert\NotBlank()
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Rank", inversedBy="rankRequirements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rank;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

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
}

<?php

namespace NCBundle\Entity\Technique;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rank
 *
 * @ORM\Table(name="rank_holder")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Technique\RankHolderRepository")
 */
class RankHolder
{
    /**
     * @var Rank
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Rank", inversedBy="holders")
     */
    private $rank;
    /**
     * @var User
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="ranks")
     */
    private $holder;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="promoted_at", type="datetime")
     */
    private $promotedAt;
    /**
     * @var string
     *
     * @ORM\Column(name="jury", type="text")
     */
    private $jury;

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
     * @return User
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * @param User $holder
     *
     * @return $this
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPromotedAt()
    {
        return $this->promotedAt;
    }

    /**
     * @param \DateTime $promotedAt
     *
     * @return $this
     */
    public function setPromotedAt($promotedAt)
    {
        $this->promotedAt = $promotedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getJury()
    {
        return $this->jury;
    }

    /**
     * @param string $jury
     *
     * @return $this
     */
    public function setJury($jury)
    {
        $this->jury = $jury;

        return $this;
    }
}

<?php

namespace NCBundle\Repository\Technique;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use NCBundle\Entity\Technique\Rank;

/**
 * Class RankRepository
 */
class RankRepository extends ServiceEntityRepository
{
    /**
     * @inheritdoc
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rank::class);
    }
}

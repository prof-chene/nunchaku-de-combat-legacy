<?php

namespace NCBundle\Repository\Event;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use NCBundle\Entity\Event\Trial;

/**
 * Class TrialRepository
 */
class TrialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trial::class);
    }
}

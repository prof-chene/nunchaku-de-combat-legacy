<?php

namespace NCBundle\Repository\Technique;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use NCBundle\Entity\Technique\Style;

/**
 * Class StyleRepository
 */
class StyleRepository extends ServiceEntityRepository
{
    /**
     * @inheritdoc
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Style::class);
    }
}

<?php

namespace NCBundle\Repository\Event;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use NCBundle\Entity\Event\TrainingCourse;

/**
 * Class TrainingCourseRepository
 */
class TrainingCourseRepository extends ServiceEntityRepository
{
    /**
     * @inheritdoc
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingCourse::class);
    }

    /**
     * @param int|User|null $user
     * @param string|null   $slug
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createRegistrationQueryBuilder($user = null, $slug = null)
    {
        $qb = $this->createQueryBuilder('trainingCourse')
            ->addSelect('case when trainingCourse.startDate <= CURRENT_TIMESTAMP() then true else false end as finished')
            ->andWhere('trainingCourse.enabled = true')
            ->andWhere('trainingCourse.publicationDateStart < CURRENT_TIMESTAMP()');
        // Check if current user is already registered
        if (!empty($user)) {
            $qb
                ->leftJoin(
                    'trainingCourse.participants',
                    'participant', Join::WITH,
                    'participant.user = :user'
                )
                ->setParameter('user', $user)
                ->groupBy('trainingCourse')
                ->addSelect('case when count(participant.id) > 0 then true else false end as registered');
        } else {
            $qb->addSelect('(false) as registered');
        }
        if(!empty($slug)) {
            $qb
                ->andWhere('trainingCourse.slug = :slug')
                ->setParameter('slug', $slug);
        }

        return $qb;
    }
}

<?php

namespace NCBundle\Repository\Event;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Sonata\UserBundle\Model\User;

/**
 * Class ShowRepository
 */
class ShowRepository extends EntityRepository
{
    /**
     * @param int|User|null $user
     * @param string|null   $slug
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createRegistrationQueryBuilder($user = null, $slug = null)
    {
        $qb = $this->createQueryBuilder('show')
            ->addSelect('case when show.startDate <= CURRENT_TIMESTAMP() then true else false end as finished')
            ->andWhere('show.enabled = true')
            ->andWhere('show.publicationDateStart < CURRENT_TIMESTAMP()');
        // Check if current user is already registered
        if (!empty($user)) {
            $qb
                ->leftJoin(
                    'show.participants',
                    'participant', Join::WITH,
                    'participant.user = :user'
                )
                ->setParameter('user', $user)
                ->groupBy('show')
                ->addSelect('case when count(participant.id) > 0 then true else false end as registered');
        } else {
            $qb->addSelect('(false) as registered');
        }
        if(!empty($slug)) {
            $qb
                ->andWhere('show.slug = :slug')
                ->setParameter('slug', $slug);
        }

        return $qb;
    }
}

<?php

namespace NCBundle\Repository\Event;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Sonata\UserBundle\Model\User;

/**
 * Class CompetitionRepository
 * @package NCBundle\Repository\Event
 */
class CompetitionRepository extends EntityRepository
{
    /**
     * @param int|User|null $user
     * @param string|null   $slug
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createRegistrationQueryBuilder($user = null, $slug = null)
    {
        $qb = $this->createQueryBuilder('competition')
            ->addSelect('case when competition.startDate <= CURRENT_TIMESTAMP() then true else false end as finished')
            ->andWhere('competition.enabled = true')
            ->andWhere('competition.publicationDateStart < CURRENT_TIMESTAMP()');
        // Check if current user is already registered
        if (!empty($user)) {
            $qb
                ->leftJoin(
                    'competition.participants',
                    'participant', Join::WITH,
                    'participant.user = :user'
                )
                ->setParameter('user', $user)
                ->groupBy('competition')
                ->addSelect('case when count(participant.id) > 0 then true else false end as registered');
        } else {
            $qb->addSelect('(false) as registered');
        }
        if(!empty($slug)) {
            $qb
                ->andWhere('competition.slug = :slug')
                ->setParameter('slug', $slug);
        }

        return $qb;
    }
}

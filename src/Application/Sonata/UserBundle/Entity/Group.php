<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * Class Group
 *
 * @ORM\Table(name="role_group")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Group extends BaseGroup
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}

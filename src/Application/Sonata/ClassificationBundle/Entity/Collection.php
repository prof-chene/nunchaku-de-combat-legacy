<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCollection as BaseCollection;

/**
 * Class Collection
 *
 * @package Application\Sonata\ClassificationBundle\Entity
 *
 * @ORM\Table(name="collection")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Collection extends BaseCollection
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
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}

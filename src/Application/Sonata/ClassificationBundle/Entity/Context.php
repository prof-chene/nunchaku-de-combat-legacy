<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseContext as BaseContext;

/**
 * Class Context
 *
 * @package Application\Sonata\ClassificationBundle\Entity
 *
 * @ORM\Table(name="context")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Context extends BaseContext
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

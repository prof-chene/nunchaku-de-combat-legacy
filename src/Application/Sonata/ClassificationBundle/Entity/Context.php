<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseContext as BaseContext;

/**
 * Class Context
 *
 * @ORM\Table(name="`context`")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Context extends BaseContext
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     */
    protected $id;

    /**
     * Get id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }
}

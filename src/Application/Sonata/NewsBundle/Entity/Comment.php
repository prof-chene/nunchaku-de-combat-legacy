<?php

namespace Application\Sonata\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\NewsBundle\Entity\BaseComment as BaseComment;

/**
 * Class Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Comment extends BaseComment
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

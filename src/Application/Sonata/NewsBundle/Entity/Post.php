<?php

namespace Application\Sonata\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\NewsBundle\Entity\BasePost as BasePost;

/**
 * Class Post
 *
 * @package Application\Sonata\NewsBundle\Entity
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Application\Sonata\NewsBundle\Entity\Repository\PostRepository")
 */
class Post extends BasePost
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
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    protected $tags;

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

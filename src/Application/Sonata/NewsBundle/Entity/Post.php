<?php

namespace Application\Sonata\NewsBundle\Entity;

use Application\Sonata\ClassificationBundle\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;
use Sonata\NewsBundle\Entity\BasePost as BasePost;

/**
 * Class Post
 *
 * @package Application\Sonata\NewsBundle\Entity
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Application\Sonata\NewsBundle\Repository\PostRepository")
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
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }
}

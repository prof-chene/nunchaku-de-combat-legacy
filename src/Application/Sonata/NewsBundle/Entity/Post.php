<?php

namespace Application\Sonata\NewsBundle\Entity;

use Application\Sonata\ClassificationBundle\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Sonata\NewsBundle\Entity\BasePost as BasePost;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Post
 *
 * @ORM\Table(name="`post`")
 * @ORM\Entity(repositoryClass="Application\Sonata\NewsBundle\Repository\PostRepository")
 */
class Post extends BasePost implements Translatable
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
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $title;
    /**
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $slug;
    /**
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $abstract;
    /**
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $content;
    /**
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $rawContent;

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

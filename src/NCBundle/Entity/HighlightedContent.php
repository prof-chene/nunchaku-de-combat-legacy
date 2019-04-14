<?php

namespace NCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractContent
 *
 * @UniqueEntity(
 *     fields={"position"},
 *     message="position.unique"
 * )
 *
 * @ORM\Table(name="`highlighted_content`", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_position", columns={"position"})
 * })
 * @ORM\Entity
 */
class HighlightedContent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\Range(min=1, max=100)
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    /**
     * @Gedmo\Translatable
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @ORM\Column(name="abstract", type="text", nullable=true)
     */
    private $abstract;
    /**
     * @var AbstractContent
     *
     * @Assert\NotBlank()
     *
     * @ORM\OnetoOne(targetEntity="NCBundle\Entity\AbstractContent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $content;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param string $abstract
     *
     * @return $this
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * @return AbstractContent
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param AbstractContent $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}

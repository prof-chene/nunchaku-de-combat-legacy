<?php

namespace NCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractEditorial
 */
abstract class AbstractEditorial extends AbstractContent
{
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    protected $title;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    protected $rawContent;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @ORM\Column(name="content_formatter", type="string", length=50)
     */
    protected $contentFormatter;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return AbstractEditorial
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($title);

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return AbstractEditorial
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     *
     * @return AbstractEditorial
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param string $contentFormatter
     *
     * @return $this
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }
}

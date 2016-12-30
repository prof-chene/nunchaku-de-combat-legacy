<?php

namespace NCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractEditorial
 *
 * @package NCBundle\Entity
 *
 * @ORM\Table(name="editorial")
 * @ORM\Entity
 */
abstract class AbstractEditorial extends AbstractContent
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    protected $title;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    protected $content;
    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    protected $rawContent;

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
}

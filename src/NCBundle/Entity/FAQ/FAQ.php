<?php

namespace NCBundle\Entity\FAQ;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractContent;

/**
 * FAQ
 *
 * @ORM\Table(name="faq")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\FAQ\FAQRepository")
 */
class FAQ extends AbstractContent
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="faq", cascade={"persist", "remove"})
     */
    private $questions;

    public function __construct()
    {
        parent::__construct();
        $this->questions = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param ArrayCollection $questions
     *
     * @return $this
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * @param Question $question
     *
     * @return $this
     */
    public function addQuestion(Question $question)
    {
        if(!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }
}

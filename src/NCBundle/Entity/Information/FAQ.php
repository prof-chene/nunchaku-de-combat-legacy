<?php

namespace NCBundle\Entity\Information;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractEditorial;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FAQ
 *
 * @ORM\Table(name="faq")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Information\FAQRepository")
 */
class FAQ extends AbstractEditorial
{
    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="faq", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $questions;

    public function __construct()
    {
        parent::__construct();
        $this->questions = new ArrayCollection();
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
        $question->setFaq($this);

        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }
}

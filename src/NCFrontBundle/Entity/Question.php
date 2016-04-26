<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\QuestionRepository")
 */
class Question
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $question;
    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=255)
     */
    private $answer;
    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", length=5)
     */
    private $position;
    /**
     * @var QuestionCategory
     *
     * @ORM\ManyToOne(targetEntity="QuestionCategory", inversedBy="questions")
     */
    private $questionCategory;
    /**
     * @var FAQ
     *
     * @ORM\ManyToOne(targetEntity="FAQ", inversedBy="questions")
     */
    private $faq;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     *
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     *
     * @return Question
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
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
     * @return Question
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return QuestionCategory
     */
    public function getQuestionCategory()
    {
        return $this->questionCategory;
    }

    /**
     * @param QuestionCategory $questionCategory
     *
     * @return Question
     */
    public function setQuestionCategory($questionCategory)
    {
        $this->questionCategory = $questionCategory;

        return $this;
    }

    /**
     * @return FAQ
     */
    public function getFaq()
    {
        return $this->faq;
    }

    /**
     * @param FAQ $faq
     *
     * @return Question
     */
    public function setFaq($faq)
    {
        $this->faq = $faq;

        return $this;
    }
}

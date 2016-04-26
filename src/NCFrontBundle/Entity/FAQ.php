<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FAQ
 *
 * @ORM\Table(name="f_a_q")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\FAQRepository")
 */
class FAQ
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="faq")
     */
    private $questions;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return QuestionCategory
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
     * @return QuestionCategory
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }
}

<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use NCBundle\Entity\FAQ\Question;
use NCBundle\Entity\Technique\Exercise;
use NCBundle\Entity\Technique\Supply;
use NCBundle\Entity\Technique\Technique;
use Sonata\ClassificationBundle\Entity\BaseCategory as BaseCategory;

/**
 * Class Category
 * @package Application\Sonata\ClassificationBundle\Entity
 */
class Category extends BaseCategory
{
    /**
     * @var int $id
     */
    protected $id;
    /**
     * @var ArrayCollection
     */
    protected $exercises;
    /**
     * @var ArrayCollection
     */
    protected $questions;
    /**
     * @var ArrayCollection
     */
    protected $techniques;
    /**
     * @var ArrayCollection
     */
    protected $supplies;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * @param ArrayCollection $exercises
     *
     * @return Category
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;

        return $this;
    }

    /**
     * @param Exercise $exercise
     *
     * @return $this
     */
    public function addExercise(Exercise $exercise)
    {
        if(!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
        }

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
     * @return Category
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

    /**
     * @return ArrayCollection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * @param ArrayCollection $techniques
     *
     * @return Category
     */
    public function setTechniques($techniques)
    {
        $this->techniques = $techniques;

        return $this;
    }

    /**
     * @param Technique $technique
     *
     * @return $this
     */
    public function addTechnique(Technique $technique)
    {
        if(!$this->techniques->contains($technique)) {
            $this->techniques->add($technique);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSupplies()
    {
        return $this->supplies;
    }

    /**
     * @param ArrayCollection $supplies
     *
     * @return Category
     */
    public function setSupplies($supplies)
    {
        $this->supplies = $supplies;

        return $this;
    }

    /**
     * @param Supply $supply
     *
     * @return $this
     */
    public function addSupply(Supply $supply)
    {
        if(!$this->supplies->contains($supply)) {
            $this->supplies->add($supply);
        }

        return $this;
    }
}

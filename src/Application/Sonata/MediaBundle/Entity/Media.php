<?php

namespace Application\Sonata\MediaBundle\Entity;

use NCBundle\Entity\Event\Event;
use NCBundle\Entity\Technique\Exercise;
use NCBundle\Entity\Technique\Supply;
use NCBundle\Entity\Technique\Technique;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

/**
 * Class Media
 * @package Application\Sonata\MediaBundle\Entity
 */
class Media extends BaseMedia
{
    /**
     * @var int $id
     */
    protected $id;
    /**
     * @var Technique
     */
    protected $technique;
    /**
     * @var Supply
     */
    protected $supply;
    /**
     * @var Event
     */
    protected $event;
    /**
     * @var Exercise
     */
    protected $exercise;

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
     * @return Technique
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * @param Technique $technique
     *
     * @return Media
     */
    public function setTechnique(Technique$technique)
    {
        $this->technique = $technique;

        return $this;
    }

    /**
     * @return Supply
     */
    public function getSupply()
    {
        return $this->supply;
    }

    /**
     * @param Supply $supply
     *
     * @return Media
     */
    public function setSupply($supply)
    {
        $this->supply = $supply;

        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     *
     * @return Media
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     *
     * @return Media
     */
    public function setExercise($exercise)
    {
        $this->exercise = $exercise;

        return $this;
    }
}

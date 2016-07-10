<?php

namespace NCBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventShow
 *
 * @ORM\Table(name="show")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\EventShowRepository")
 */
class EventShow extends AbstractEvent
{
}

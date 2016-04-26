<?php

namespace NCFrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventShow
 *
 * @ORM\Table(name="event_show")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\EventShowRepository")
 */
class EventShow extends Event
{
}

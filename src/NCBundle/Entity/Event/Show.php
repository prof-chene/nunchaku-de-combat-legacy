<?php

namespace NCBundle\Entity\Event;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Show
 *
 * @package NCBundle\Entity\Event
 *
 * @ORM\Table(name="show")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\ShowRepository")
 */
class Show extends AbstractEvent
{
}

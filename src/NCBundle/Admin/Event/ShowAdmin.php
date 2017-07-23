<?php

namespace NCBundle\Admin\Event;

/**
 * Class ShowAdmin
 *
 * @package NCBundle\Admin\Event
 */
class ShowAdmin extends AbstractEventAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_show';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'show';
}

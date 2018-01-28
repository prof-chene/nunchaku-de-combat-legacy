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
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_show';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'show';
}

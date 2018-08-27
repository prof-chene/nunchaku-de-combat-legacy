<?php

namespace NCBundle\Admin\Event;

/**
 * Class ShowAdmin
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

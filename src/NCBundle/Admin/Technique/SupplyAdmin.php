<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ExerciseAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class SupplyAdmin extends AbstractEditorialAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_supply';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'supply';
}

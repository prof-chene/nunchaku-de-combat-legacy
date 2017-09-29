<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TechniqueAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class TechniqueAdmin extends AbstractEditorialAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_technique';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'technique';
}

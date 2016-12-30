<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TechniqueExecutionAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class TechniqueExecutionAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_technique_execution';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'technique/execution';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('detail', 'textarea')
            ->add('order')
            ->add('technique', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Technique\Technique',
                'property' => 'name',
                'required' => true,
            ));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('detail')
            ->add('order')
            ->add('technique.name')
            ->add('exercise.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description', 'textarea')
            ->add('technique', null, array(
                'associated_property' => 'name',
            ))
            ->add('exercise', null, array(
                'associated_property' => 'name',
            ));
    }
}

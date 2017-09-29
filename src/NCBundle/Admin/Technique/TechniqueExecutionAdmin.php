<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TechniqueExecutionAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class TechniqueExecutionAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected  $translationDomain = 'admin';
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
            ->add('technique', 'sonata_type_model')
            ->add('detail', 'textarea');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('detail')
            ->add('technique.title')
            ->add('exercise.title');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('technique', null, array(
                'associated_property' => 'title',
            ))
            ->add('detail', 'textarea')
            ->add('exercise', null, array(
                'associated_property' => 'title',
            ));
    }
}

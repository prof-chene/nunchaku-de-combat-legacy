<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ExerciseAdmin
 * @package NCBundle\Admin\Technique
 */
class ExerciseAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_exercise';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'exercise';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('category', 'sonata_type_model', array(
                'class' => 'Application\Sonata\ClassificationBundle\Entity\Category',
                'property' => 'name',
                'required' => false,
            ))
            ->add('techniqueExecutions',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Technique\TechniqueExecution',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->add('supplies',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Supply\Supply',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->add('medias',
                'sonata_type_collection',
                array(
                    'type' => 'sonata_type_model_list',
                    'type_options' => array(
                        'sonata_field_description' => array(
                            'link_parameters' => array(
                                'context'      => 'technique',
                                'hide_context' => true,
                            )
                        )
                    ),
                    'required' => false,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
            ->add('category.name')
            ->add('techniqueExecutions.technique.name')
            ->add('supplies.name')
            ->add('medias.name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description', 'textarea')
            ->add('category', null, array(
                'associated_property' => 'name',
            ))
            ->add('techniqueExecutions', null, array(
                'associated_property' => 'technique.name',
            ))
            ->add('supplies', null, array(
                'associated_property' => 'name',
            ))
            ->add('medias', null, array(
                'associated_property' => 'name',
            ))
        ;
    }
}

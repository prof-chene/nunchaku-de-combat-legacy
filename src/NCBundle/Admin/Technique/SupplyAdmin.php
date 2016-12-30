<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ExerciseAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class SupplyAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_supply';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'supply';

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
                'required' => true,
            ))
            ->add('medias',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'Application\Sonata\MediaBundle\Entity\Media',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            );
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
            ->add('medias.name');
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
            ->add('medias', null, array(
                'associated_property' => 'name',
            ));
    }
}

<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class StyleAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class StyleAdmin extends AbstractEditorialAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_style';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'style';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('ranks',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'class' => 'NCBundle\Entity\Technique\Rank',
                        'property' => 'name'
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
            ->add('ranks.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', 'text', array(
                'editable' => true
            ))
            ->add('description', 'textarea', array(
                'editable' => true
            ))
            ->add('ranks', null, array(
                'associated_property' => 'name',
            ));
    }
}

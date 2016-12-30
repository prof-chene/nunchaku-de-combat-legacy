<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class RankAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class RankAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_rank';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'rank';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('level')
            ->add('style', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Technique\Style',
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
            ->add('name')
            ->add('description')
            ->add('level')
            ->add('style.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description', 'textarea')
            ->add('level')
            ->add('style', null, array(
                'associated_property' => 'name',
            ));
    }
}

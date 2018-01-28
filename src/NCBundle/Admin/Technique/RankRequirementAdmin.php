<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RankRequirementAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected  $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_rank_requirement';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'rank/requirement';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('exercise', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Technique\Exercise',
                'property' => 'title',
                'required' => true,
            ))
            ->add('detail', 'textarea')
            ->add('points', 'integer');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercise.title')
            ->add('rank.title')
            ->add('detail');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('exercise', null, array(
                'associated_property' => 'title',
            ))
            ->add('rank', null, array(
                'associated_property' => 'title',
            ))
            ->add('detail', 'textarea');
    }
}

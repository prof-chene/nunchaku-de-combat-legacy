<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SyllabusRequirementAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_syllabus_requirement';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'syllabus/requirement';
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('exercise', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Technique\Exercise',
                'property' => 'name',
                'required' => true,
            ))
            ->add('syllabus', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Technique\Syllabus',
                'property' => 'name',
                'required' => true,
            ))
            ->add('detail', 'textarea')
            ->add('points', 'integer')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercise.name')
            ->add('syllabus.name')
            ->add('detail')
            ->add('points')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('exercise', null, array(
                'associated_property' => 'name',
            ))
            ->add('syllabus', null, array(
                'associated_property' => 'name',
            ))
            ->add('detail', 'textarea')
            ->add('points', 'integer')
        ;
    }
}

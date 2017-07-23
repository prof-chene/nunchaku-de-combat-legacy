<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class SyllabusAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class SyllabusAdmin extends AbstractEditorialAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_syllabus';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'syllabus';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('rank', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Technique\Rank',
                'property' => 'name',
                'required' => true,
            ))
            ->add('syllabusRequirements',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'class' => 'NCBundle\Entity\Technique\SyllabusRequirements',
                        'property' => 'exercise.name'
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
            ->add('rank.name')
            ->add('syllabusRequirements.exercise.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description', 'textarea')
            ->add('rank', null, array(
                'associated_property' => 'name',
            ))
            ->add('syllabusRequirements', null, array(
                'associated_property' => 'exercise.name',
            ));
    }
}

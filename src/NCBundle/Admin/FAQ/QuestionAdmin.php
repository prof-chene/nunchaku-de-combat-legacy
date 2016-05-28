<?php

namespace NCBundle\Admin\FAQ;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class QuestionAdmin
 * @package NCBundle\Admin\FAQ
 */
class QuestionAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_question';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'question';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('question', 'textarea')
            ->add('answer', 'textarea')
            ->add('position')
            ->add('category', 'sonata_type_model', array(
                'class' => 'Application\Sonata\ClassificationBundle\Entity\Category',
                'property' => 'name',
                'required' => false,
            ))
            ->add('faq', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\FAQ\FAQ',
                'property' => 'name',
                'required' => false,
            ))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('question')
            ->add('answer')
            ->add('position')
            ->add('category.name')
            ->add('faq.name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('question', 'textarea', array(
                'editable' => true
            ))
            ->add('answer', 'textarea', array(
                'editable' => true
            ))
            ->add('position', null, array(
                'editable' => true
            ))
            ->add('category', null, array(
                'associated_property' => 'name',
            ))
            ->add('faq', null, array(
                'associated_property' => 'name',
            ))
        ;
    }
}

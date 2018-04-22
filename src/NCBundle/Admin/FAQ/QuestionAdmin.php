<?php

namespace NCBundle\Admin\Information;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class QuestionAdmin
 *
 * @package NCBundle\Admin\Information
 */
class QuestionAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected  $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_question';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'question';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('question', TextareaType::class)
            ->add('answer', TextareaType::class)
            ->add('position');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('question')
            ->add('answer')
            ->add('position')
            ->add('faq.title');
    }

    /**
     * {@inheritdoc}
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
            ->add('faq', null, array(
                'associated_property' => 'title',
            ));
    }
}

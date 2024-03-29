<?php

namespace NCBundle\Admin\Information;

use NCBundle\Entity\Information\Question;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class QuestionAdmin
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
     * @param Question $subject
     */
    public function setSubject($subject)
    {
        $subject->setLocale($this->getRequest()->getLocale());
        parent::setSubject($subject);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('question', TextareaType::class)
            ->add('answer', TextareaType::class)
            ->add('position', HiddenType::class);
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

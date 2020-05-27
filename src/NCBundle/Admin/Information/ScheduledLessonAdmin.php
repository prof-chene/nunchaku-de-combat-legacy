<?php

namespace NCBundle\Admin\Information;

use NCBundle\Entity\Information\ScheduledLesson;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

/**
 * Class ScheduledLessonAdmin
 */
class ScheduledLessonAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_scheduled_lesson';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'scheduled_lesson';

    /**
     * @param ScheduledLesson $subject
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
            ->add('dayOfTheWeek', ChoiceType::class, [
                'choices' => [
                    'day1' => 1,
                    'day2' => 2,
                    'day3' => 3,
                    'day4' => 4,
                    'day5' => 5,
                    'day6' => 6,
                    'day7' => 7,
                ]
            ])
            ->add('startTime', TimeType::class)
            ->add('endTime', TimeType::class)
            ->add('details', TextareaType::class, [
                'required' => false,
                'attr'     => [
                    'maxlength' => 100,
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dayOfTheWeek')
            ->add('startTime')
            ->add('endTime')
            ->add('details')
            ->add('club.name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('dayOfTheWeek')
            ->add('startTime')
            ->add('endTime')
            ->add('details')
            ->add('club', null, [
                'associated_property' => 'name',
            ]);
    }
}

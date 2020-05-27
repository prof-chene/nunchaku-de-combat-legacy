<?php

namespace NCBundle\Admin\Information;

use NCBundle\Entity\Information\Trainer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

/**
 * Class ScheduledLessonAdmin
 */
class TrainerAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_trainer';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'trainer';

    /**
     * @param Trainer $subject
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
            ->add('firstname')
            ->add('lastname')
            ->add('cv')
            ->add('user', ModelAutocompleteType::class, [
                'placeholder' => 'choose_user',
                'class' => 'Application\Sonata\UserBundle\Entity\User',
                'property' => ['firstname', 'lastname', 'username'],
                'required' => false,
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
                'to_string_callback' => function($entity, $property) {
                    return $entity->getFullname().' (@'.$entity->getUsername().')';
                },
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname')
            ->add('lastname')
            ->add('club.name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('firstname')
            ->addIdentifier('lastname')
            ->add('cv')
            ->add('club', null, [
                'associated_property' => 'name',
            ]);
    }
}

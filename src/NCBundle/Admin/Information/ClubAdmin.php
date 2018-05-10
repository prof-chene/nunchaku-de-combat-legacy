<?php

namespace NCBundle\Admin\Information;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\MediaBundle\Form\Type\MediaType;

/**
 * Class ClubAdmin
 */
class ClubAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_club';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'club';

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getScheduledLessons() as $scheduledLesson) {
            $scheduledLesson->setClub($object);
        }
        foreach($object->getTrainers() as $trainer) {
            $trainer->setClub($object);
        }
        foreach($object->getSocialMediaAccounts() as $socialMediaAccount) {
            $socialMediaAccount->setClub($object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getScheduledLessons() as $scheduledLesson) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($scheduledLesson)) {
                $scheduledLesson->setClub($object);
            }
        }
        foreach($object->getTrainers() as $trainer) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($trainer)) {
                $trainer->setClub($object);
            }
        }
        foreach($object->getSocialMediaAccounts() as $socialMediaAccount) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($socialMediaAccount)) {
                $socialMediaAccount->setClub($object);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('tab_informations')
            ->with('group_content', [
                'class' => 'col-md-8',
            ])
            ->add('name')
            ->add('image', MediaType::class, [
                'context' => 'event',
                'provider' => 'sonata.media.provider.image',
                'required' => false,
            ])
            ->add('address')
            ->add('latitude')
            ->add('longitude')
            ->add('phone')
            ->add('websiteUrl')
            ->end()
            ->with('group_status', [
                'class' => 'col-md-4',
            ])
            ->add('tags', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('publicationDateStart', DateTimePickerType::class, [
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ])
            ->add('enabled')
            ->end()
            ->end()
            ->tab('tab_schedule')
            ->with('')
            ->add('scheduledLessons', CollectionType::class, [], [
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => ['hide_context' => true,]
            ])
            ->end()
            ->end()
            ->tab('tab_styles')
            ->with('')
            ->add('styles', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->end()
            ->end()
            ->tab('tab_trainers')
            ->with('')
            ->add('trainers', CollectionType::class, [], [
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => ['hide_context' => true,]
            ])
            ->end()
            ->end()
            ->tab('tab_social_networks')
            ->with('')
            ->add('socialMediaAccounts', CollectionType::class, [], [
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => ['hide_context' => true,]
            ])
            ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('address')
            ->add('phone')
            ->add('websiteUrl')
            ->add('publicationDateStart', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',))
            ->add('tags', null, array(
                'field_options' => array('expanded' => true, 'multiple' => true),
            ))
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('address')
            ->add('phone')
            ->add('websiteUrl')
            ->add('publicationDateStart')
            ->add('tags')
            ->add('enabled');
    }
}

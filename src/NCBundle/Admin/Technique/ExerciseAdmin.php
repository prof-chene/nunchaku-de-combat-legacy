<?php

namespace NCBundle\Admin\Technique;

use Application\Sonata\ClassificationBundle\Entity\Context;
use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DateTimePickerType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\MediaBundle\Form\Type\MediaType;

/**
 * Class ExerciseAdmin
 */
class ExerciseAdmin extends AbstractEditorialAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_exercise';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'exercise';

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getTechniqueExecutions() as $techniqueExecution) {
            $techniqueExecution->setExercise($object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getTechniqueExecutions() as $techniqueExecution) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($techniqueExecution)) {
                $techniqueExecution->setExercise($object);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = $this->getConfigurationPool()->getOption('form_type') == 'horizontal';

        $formMapper
            ->tab('tab_informations')
            ->with('group_content', array(
                'class' => 'col-md-8',
            ))
            ->add('title')
            ->add('image', MediaType::class, array(
                'context'  => Context::EXERCISE_CONTEXT,
                'provider' => 'sonata.media.provider.image',
                'required' => false,
            ))
            ->add('content', FormatterType::class, array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'contentFormatter',
                'source_field' => 'rawContent',
                'source_field_options' => array(
                    'horizontal_input_wrapper_class' => $isHorizontal ? 'col-lg-12' : '',
                    'attr' => array('class' => $isHorizontal ? 'span10 col-sm-10 col-md-10' : '', 'rows' => 20),
                ),
                'ckeditor_context' => 'exercise',
                'target_field' => 'content',
                'listener' => true,
            ))
            ->end()
            ->with('group_status', array(
                'class' => 'col-md-4',
            ))
            ->add('collection', ModelAutocompleteType::class, array(
                'class' => 'Application\Sonata\ClassificationBundle\Entity\Collection',
                'property' => 'name',
                'required' => true,
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
                'callback' => function ($admin, $property, $value) {
                    $queryBuilder = $admin->getDatagrid()->getQuery();
                    $queryBuilder
                        ->andWhere($queryBuilder->getRootAlias() . '.context = :context')
                        ->andWhere($queryBuilder->getRootAlias() . '.'.$property.' like :searchValue')
                        ->setParameter('searchValue', '%'.$value.'%')
                    ;
                },
            ))
            ->add('tags', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('publicationDateStart', DateTimePickerType::class, array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->add('enabled')
            ->end()
            ->end()
            ->tab('tab_techniques')
            ->with('')
            ->add('techniqueExecutions', CollectionType::class, array(
                'required' => false,
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => array(
                    'hide_context' => true,
                )
            ))
            ->end()
            ->end()
            ->tab('tab_supplies')
            ->with('')
            ->add('supplies', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('collection')
            ->add('techniqueExecutions')
            ->add('supplies');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        parent::configureListFields($listMapper);
        $listMapper
            ->add('collection')
            ->add('techniqueExecutions')
            ->add('supplies');
    }
}

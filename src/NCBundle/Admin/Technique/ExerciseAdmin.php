<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

/**
 * Class ExerciseAdmin
 *
 * @package NCBundle\Admin\Technique
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
        $formMapper->tab('tab_informations');
        parent::configureFormFields($formMapper);
        $formMapper
            ->end()
            ->tab('tab_techniques')
            ->with('')
            ->add('techniqueExecutions', 'sonata_type_collection', array(
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
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('techniqueExecutions')
            ->add('supplies');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('techniqueExecutions')
            ->add('supplies');
    }
}

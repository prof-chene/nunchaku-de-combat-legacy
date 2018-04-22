<?php

namespace NCBundle\Admin\Information;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;

/**
 * Class FAQAdmin
 *
 * @package NCBundle\Admin\Information
 */
class FAQAdmin extends AbstractEditorialAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_faq';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'faq';

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getQuestions() as $question) {
            $question->setFaq($object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getQuestions() as $question) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($question)) {
                $question->setFaq($object);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->with('group_questions', [
                'class' => 'col-md-12',
            ])
            ->add('questions', CollectionType::class, ['required' => true,], [
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => ['hide_context' => true,]
            ])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper->add('questions.question');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper->add('questions', null, ['associated_property' => 'question',]);
    }
}

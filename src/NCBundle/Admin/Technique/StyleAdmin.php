<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;

/**
 * Class StyleAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class StyleAdmin extends AbstractEditorialAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_style';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'style';

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getRanks() as $rank) {
            $rank->setContent($this->formatterPool->transform($rank->getContentFormatter(), $rank->getRawContent()));
            $rank->setStyle($object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getRanks() as $rank) {
            $rank->setContent($this->formatterPool->transform($rank->getContentFormatter(), $rank->getRawContent()));
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($rank)) {
                $rank->setStyle($object);
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
            ->tab('tab_ranks')
            ->with('')
            ->add('ranks', CollectionType::class, [], [
                'edit' => 'inline',
                'sortable' => 'level',
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
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        parent::configureListFields($listMapper);
    }
}

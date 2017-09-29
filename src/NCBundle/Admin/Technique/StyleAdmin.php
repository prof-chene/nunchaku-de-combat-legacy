<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class StyleAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class StyleAdmin extends AbstractEditorialAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_style';
    /**
     * @var string
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
            $rank->setStyle($object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
//        dump($object);
//        exit;
        parent::preUpdate($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getRanks() as $rank) {
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
            ->add('ranks', 'sonata_type_collection', array(), array(
                'required' => false,
                'edit' => 'inline',
                'sortable' => 'level',
            ))
            ->end()
            ->end();
    }
}

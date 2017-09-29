<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class RankAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class RankAdmin extends AbstractEditorialAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_rank';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'rank';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->with('tab_syllabus')
            ->add('level', 'hidden')
            ->add('rankRequirements', 'sonata_type_collection', array(), array(
                'required' => false,
                'edit' => 'inline',
            ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('style.title');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('style', null, array(
                'associated_property' => 'title',
            ));
    }
}

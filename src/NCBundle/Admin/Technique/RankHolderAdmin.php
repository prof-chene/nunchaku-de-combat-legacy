<?php

namespace NCBundle\Admin\Technique;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;

/**
 * Class RankHolderAdmin
 *
 * @package NCBundle\Admin\Technique
 */
class RankHolderAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_rank_holder';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'rank/holder';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('rank')
            ->add('promotedAt', DateTimePickerType::class, [
                'datepicker_use_button' => false,
                'dp_default_date'       => new \DateTime(),
            ])
            ->add('jury');
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

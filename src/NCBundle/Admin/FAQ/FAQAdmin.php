<?php

namespace NCBundle\Admin\FAQ;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class FAQAdmin
 *
 * @package NCBundle\Admin\FAQ
 */
class FAQAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_faq';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'faq';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('questions',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\FAQ\Question',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('questions.question');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('questions', null, array(
                'associated_property' => 'question',
            ));
    }
}

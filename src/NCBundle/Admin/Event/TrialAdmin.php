<?php

namespace NCBundle\Admin\Event;

use NCBundle\Entity\Event\TrialResult;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TrialAdmin
 *
 * @package NCBundle\Admin\Event
 */
class TrialAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_trial';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'trial';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = $this->getConfigurationPool()->getOption('form_type') == 'horizontal';
        $formMapper
            ->add('name', 'text')
            ->add('rules', 'sonata_formatter_type', array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'rulesFormatter',
                'source_field' => 'rawRules',
                'source_field_options' => array(
                    'horizontal_input_wrapper_class' => $isHorizontal ? 'col-lg-12' : '',
                    'attr' => array('class' => $isHorizontal ? 'span10 col-sm-10 col-md-10' : '', 'rows' => 20),
                ),
                'ckeditor_context' => 'event',
                'target_field' => 'rules',
                'listener' => true,
            ));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('rules')
            ->add('competition.title');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('rules')
            ->add('competition', null, array(
                'associated_property' => 'title',
            ));
    }
}

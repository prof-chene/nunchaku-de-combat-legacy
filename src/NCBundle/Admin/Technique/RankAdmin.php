<?php

namespace NCBundle\Admin\Technique;

use Application\Sonata\ClassificationBundle\Entity\Context;
use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Class RankAdmin
 */
class RankAdmin extends AbstractEditorialAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_rank';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'rank';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = $this->getConfigurationPool()->getOption('form_type') == 'horizontal';
        $formMapper
            ->with('group_content', array(
                'class' => 'col-md-8',
            ))
            ->add('title')
            ->add('image', 'sonata_media_type', array(
                'context'  => Context::TECHNIQUE_CONTEXT,
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
                'ckeditor_context' => 'event',
                'target_field' => 'content',
                'listener' => true,
            ))
            ->end()
            ->with('group_status', array(
                'class' => 'col-md-4',
            ))
            ->add('tags', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('publicationDateStart', 'sonata_type_datetime_picker', array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->add('enabled')
            ->add('level', HiddenType::class)
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
            ->add('style', null, ['associated_property' => 'title',]);
    }
}

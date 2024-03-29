<?php

namespace Application\Sonata\ClassificationBundle\Admin;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Form\Type\MediaType;
use Sonata\MediaBundle\Model\MediaInterface;

class CollectionAdmin extends \Sonata\ClassificationBundle\Admin\CollectionAdmin
{
    /**
     * @param Collection $subject
     */
    public function setSubject($subject)
    {
        $subject->setLocale($this->getRequest()->getLocale());
        parent::setSubject($subject);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        if (interface_exists(MediaInterface::class)) {
            $formMapper->add('media', MediaType::class, [
                'context'  => Context::DEFAULT_CONTEXT,
                'provider' => 'sonata.media.provider.image',
                'required' => false,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper->add('id');
        parent::configureDatagridFilters($filterMapper);
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

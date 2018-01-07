<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LogInType
 * @package Application\Sonata\Form
 */
class LogInType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label'     => 'username',
                'required'  => true,
            ))
            ->add('password', 'password', array(
                'label'     => 'password',
                'required'  => true,
            ))
            ->add('remember_me', 'checkbox', array(
                'value'     => 'on',
                'label'     => 'remember_me',
                'required'  => false,
            ))
            ->add('submit', 'submit', array(
                'label'     => 'log_in'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'intention' => 'login',
        ));
    }
}

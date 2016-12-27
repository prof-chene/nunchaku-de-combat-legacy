<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Validator\Constraints\UserExists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ResetPasswordType
 *
 * @package Application\Sonata\UserBundle\Form\Type
 */
class ResetPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username_email', 'text', array(
                'label'     => 'username_email',
                'required'  => true,
                'constraints' => new UserExists(),
            ))
            ->add('submit', 'submit', array(
                'label'     => 'reset_password.request'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'reset_password',
        ));
    }
}

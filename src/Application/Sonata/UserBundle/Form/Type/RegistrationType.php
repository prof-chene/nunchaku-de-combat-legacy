<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegistrationType
 */
class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label'      => 'username',
                'label_attr' => [
                    'data-toggle'    => 'tooltip',
                    'data-placement' => 'right auto',
                    'title'          => 'username.tooltip',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => 'password',
                'invalid_message' => 'password.mismatch',
                'first_options' => array(
                    'label' => 'password',
                    'label_attr' => [
                        'data-toggle'    => 'tooltip',
                        'data-placement' => 'right auto',
                        'title'          => 'password.tooltip',
                    ]
                ),
                'second_options' => array(
                    'label' => 'password_confirmation',
                ),
            ))
            ->add('submit', 'submit', [
                'label' => 'registration.submit',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace AppBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, [
                'label' => 'form.firstName', 
                'translation_domain' => 'messages',
                'attr' => ['placeholder' => 'form.firstName'],
            ])
            ->add('lastName', null, [
                'label' => 'form.lastName', 
                'translation_domain' => 'messages',
                'attr' => ['placeholder' => 'form.lastName'],
            ])
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => 'form.email', 
                'translation_domain' => 'messages',
                'attr' => ['placeholder' => 'form.email'],
            ))
            ->add('username', HiddenType::class, [
                'data' => 'xxx',
                /*'label' => 'form.username', 
                'translation_domain' => 'messages',
                'attr' => ['placeholder' => 'form.username'],*/
            ])
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'messages'),
                'first_options' => array(
                    'label' => 'form.password',
                    'attr' => ['placeholder' => 'form.password'],
                ),
                'second_options' => array(
                    'label' => 'form.password_confirmation',
                    'attr' => ['placeholder' => 'form.password_confirmation'],
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'csrf_token_id' => 'registration',
            // BC for SF < 2.8
            'intention' => 'registration',
        ));
    }

    // BC for SF < 3.0
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fos_user_registration';
    }
}

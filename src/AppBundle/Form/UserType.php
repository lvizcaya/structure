<?php

namespace AppBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'user.firstName.label',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'user.lastName.label',
            ])
            ->add('phone', TextType::class, [
                'label' => 'user.phone.label',
                'required' => false,
                'attr' => [
                    'data-intype' => 'phone',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'user.email.label',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'user.enabled.label',
                'required' => false,
            ])
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('avatarFile', VichImageType::class, [
                'label' => 'user.avatarFile.label',
                'required' => false,
                'allow_delete' => false,
                'download_link' => false,
                'attr' => [
                    'class' => "btn btn-primary btn-file btn-flat",
                    'data-intype' => 'imagePreview',
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}

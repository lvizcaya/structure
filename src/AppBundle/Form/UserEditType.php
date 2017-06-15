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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['data'];
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
        ;

        $builder->add('roles', ChoiceType::class, array(
            'label' => 'user.roles.label',
            'choices' => [
                'Administrador' => 'ROLE_ADMIN'
            ],
            'required' => true,
            'multiple' => true,
            'expanded' => true,
        ));

        $builder
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

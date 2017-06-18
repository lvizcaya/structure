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
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraintsOptions = array(
            'message' => 'fos_user.current_password.invalid',
        );

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
            ->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
                'label' => 'form.current_password',
                'mapped' => false,
                'constraints' => new UserPassword($constraintsOptions),
            ))
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

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}

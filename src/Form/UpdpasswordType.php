<?php

namespace App\Form;

use App\Entity\SigesUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdpasswordType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add(
                'oldpwd',
                PasswordType::class

            )
            ->add(
                'newpwd',
                PasswordType::class

            )
            ->add(
                'confirmpwd',
                PasswordType::class

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}

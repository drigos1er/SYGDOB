<?php

namespace App\Form;


use App\Entity\SygdobUser;
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

class UpdprofileType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('gender',choiceType::class,array('label'=>'Genre : ', 'choices' => array(
                '--selectionner le genre--' => '','M' => 'M','F'=>'F'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))





            ->add('phone', TextType::class)


            ->add('email', EmailType::class)



            ->add('picture', FileType::class, [
                'required'=>false,
                'label'=>'Image au format("jpg", "JPG","jpeg", "JPEG")',
                'data_class' => null ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SygdobUser::class,
        ]);
    }
}

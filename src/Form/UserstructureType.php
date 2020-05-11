<?php

namespace App\Form;

use App\Entity\Locality;
use App\Entity\Student;
use App\Entity\SygdobUser;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserstructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {




        $builder







            ->add('structure',choiceType::class,array('label'=>'Structure : ', 'choices' => array(
                '--selectionner une direction--' => '','DOB' => 'DOB','DEEP'=>'DEEP'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}

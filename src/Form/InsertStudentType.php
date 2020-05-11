<?php

namespace App\Form;

use App\Entity\Locality;
use App\Entity\Student;
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


class InsertStudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {





        $builder


            ->add('id',TextType::class)
            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)

            ->add('kind',choiceType::class,array('label'=>'Genre : ', 'choices' => array(
                '--selectionner le genre--' => '','M' => 'M','F'=>'F'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))



            ->add('birthdate', DateType::class,array('label'=>'Date de naissance  : ','constraints' => array(
                new NotBlank(),
            ),'widget'=>'single_text','input'=>'datetime','format' => 'dd/MM/yyyy','attr' => [
                'class' => 'form-control input-inline datepicker',
                'data-provide' => 'datepicker',
                'placeholder' => 'Ex: 10/10/2010',

                'data-date-format' => 'dd/mm/yyyy'
            ]
            ))


            ->add('placeofbirth',TextType::class,[
            'required'=>false])

            ->add('nationality',choiceType::class,array('label'=>'Nationalité : ', 'choices' => array(
                '--selectionner la nationalité--' => '','IVOIRIENNE' => 'IV','E'=>'E'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))




            -> add('school',TextType::class)




            -> add('iepp',EntityType::class,

                array(

                    'class' => 'App\Entity\Iepp',
                    'query_builder' => function(EntityRepository $er)      {
                        return $er->createQueryBuilder('i')
                            // ->join('p.iepp','i')






                            ;
                    },
                    'choice_label' => 'ieppname',
                    "label"=>"           ",
                    'placeholder' => 'Saisir IEPP',











                ))


            -> add('dren',EntityType::class,

                array(

                    'class' => 'App\Entity\Drenddn',
                    'query_builder' => function(EntityRepository $er)      {
                        return $er->createQueryBuilder('d')
                            // ->join('p.iepp','i')






                            ;
                    },
                    'choice_label' => 'drenname',
                    "label"=>"           ",
                    'placeholder' => 'Saisir DRENETFP',











                ))







        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,

        ]);

    }
}

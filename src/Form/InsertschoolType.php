<?php

namespace App\Form;

use App\Entity\SecondarySchool;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class InsertschoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',TextType::class)
            ->add('schoolname',TextType::class)
            ->add('schoolkind',choiceType::class,array('label'=>'Genre : ', 'choices' => array(
                '--selectionner le genre--' => '','MIXTE' => 'MIXTE','M' => 'M','F'=>'F'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))


            ->add('schooltype',choiceType::class,array('label'=>'Type : ', 'choices' => array(
                '--selectionner le type--' => '','PRIVE' => 'PRIVE','PUBLIC' => 'PUBLIC'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))



            ->add('town',TextType::class,[
        'required'=>false])
            -> add('drenddn',EntityType::class,

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
            'data_class' => SecondarySchool::class,
        ]);
    }
}

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


class StudenthdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $id = $options['id'];


        $builder




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




            -> add('localities',EntityType::class,

                array(

                    'class' => 'App\Entity\Locality',
                    'query_builder' => function(EntityRepository $er)   use ($id)  {
                        return $er->createQueryBuilder('l')
                            // ->join('p.iepp','i')

                           ->where('l.drenddn = :id ')
                           ->setParameter('id', $id)




                            ;
                    },
                    'choice_label' => 'localityname',
                    "label"=>"           ",
                    'placeholder' => 'Saisir une localité',











                ))




            ->add('residence',TextType::class)



            ->add('fathername',TextType::class,[
            'required'=>false])
            ->add('fathercontact',TextType::class,[
            'required'=>false])

            -> add('fatherjob',EntityType::class,

                array(

                    'class' => 'App\Entity\SocialConditions',
                    'query_builder' => function(EntityRepository $er)  use ($id)   {
                        return $er->createQueryBuilder('s')
                            /* ->join('p.iepp','i')

                            ->where('l.drenddn = :id ')
                            ->setParameter('id', $id)*/




                            ;
                    },
                    'choice_label' => 'name',
                    "label"=>"           ",
                    'placeholder' => 'Catégorie socio-professionnelle',
                    'required' => false









                ))



            ->add('mothername',TextType::class,[
            'required'=>false])
            ->add('mothercontact',TextType::class,[
            'required'=>false])
            -> add('motherjob',EntityType::class,

                array(

                    'class' => 'App\Entity\SocialConditions',
                    'query_builder' => function(EntityRepository $er)  use ($id)   {
                        return $er->createQueryBuilder('s')
                            /* ->join('p.iepp','i')

                            ->where('l.drenddn = :id ')
                            ->setParameter('id', $id)*/




                            ;
                    },
                    'choice_label' => 'name',
                    "label"=>"           ",
                    'placeholder' => 'Catégorie socio-professionnelle',
                    'required' => false









                ))
            ->add('tutorname',TextType::class,[
                'required'=>false])
            ->add('tutorcontact',TextType::class,[
                'required'=>false])






            ->add('typeofidoc',choiceType::class,array('placeholder' => 'Type de Pièce d\'identité du requérant','label'=>' : ', 'choices' => array(
                'CNI' => 'CNI','Passport'=>'Passport','Permis de conduire'=>'Permis de conduire','Carte Professionnelle'=>'Carte Professionnelle','Autre'=>'Autre'),
                'attr' => array(
                    'class' =>'form-control'),
                'required' => false))




            ->add('numofidoc',TextType::class,[
                'required'=>false])



            -> add('wish1',EntityType::class,

                array(

                    'class' => 'App\Entity\SecondarySchool',
                    'query_builder' => function(EntityRepository $er)     {
                        return $er->createQueryBuilder('s')
                            // ->join('p.iepp','i')

                          //  ->where('s.drenddn = :id ')
                           // ->setParameter('id', $id)




                            ;
                    },
                    'choice_label' => 'schoolname',
                    "label"=>"           ",
                    'placeholder' => 'Saisir un Etablissement'









                ))

            -> add('wish2',EntityType::class,

                array(

                    'class' => 'App\Entity\SecondarySchool',
                    'query_builder' => function(EntityRepository $er)     {
                        return $er->createQueryBuilder('s')
                            // ->join('p.iepp','i')

                          //  ->where('s.drenddn = :id ')
                          //  ->setParameter('id', $id)




                            ;
                    },
                    'choice_label' => 'schoolname',
                    "label"=>"           ",
                    'placeholder' => 'Saisir un Etablissement'









                ))

            -> add('wish3',EntityType::class,

                array(

                    'class' => 'App\Entity\SecondarySchool',
                    'query_builder' => function(EntityRepository $er)     {
                        return $er->createQueryBuilder('s')
                            // ->join('p.iepp','i')

                           // ->where('s.drenddn = :id ')
                           // ->setParameter('id', $id)




                            ;
                    },
                    'choice_label' => 'schoolname',
                    "label"=>"           ",
                    'placeholder' => 'Saisir un Etablissement',
                    'required' => false









                ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
            'id' => null
        ]);
    }
}

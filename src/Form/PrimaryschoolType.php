<?php

namespace App\Form;

use App\Entity\PrimarySchool;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PrimaryschoolType extends AbstractType
{






    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $id = $options['id'];



        $builder






        -> add('schoolname',EntityType::class,

        array(

            'class' => 'App\Entity\PrimarySchool',
            'query_builder' => function(EntityRepository $er)  use ($id)   {
                return $er->createQueryBuilder('p')
                   // ->join('p.iepp','i')

                    ->where('p.iepp = :id ')
                    ->setParameter('id', $id)




                    ;
            },
            'choice_label' => 'schoolname',
            "label"=>"           ",
            'placeholder' => '---------Sélectionner une école-------'









        ))       ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PrimarySchool::class,
            'id' => null,
        ]);
    }
}

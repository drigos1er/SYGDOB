<?php

namespace App\Form;

use App\Entity\Iepp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class IeppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('ieppname',EntityType::class,

                array(

                    'class' => 'App\Entity\Iepp',
                    'query_builder' => function(EntityRepository $er)      {
                        return $er->createQueryBuilder('i')
                            // ->join('p.iepp','i')






                            ;
                    },
                    'choice_label' => 'ieppname',
                    "label"=>"           ",
                    'placeholder' => '--------------------Saisir IEPP---------------',











                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Iepp::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Drenddn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DrenddnType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            -> add('drenname',EntityType::class,

                array(

                    'class' => 'App\Entity\Drenddn',
                    'query_builder' => function(EntityRepository $er)      {
                        return $er->createQueryBuilder('d')
                            // ->join('p.iepp','i')






                            ;
                    },
                    'choice_label' => 'drenname',
                    "label"=>"           ",
                    'placeholder' => '----------Saisir DRENETFP-----------',











                ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Drenddn::class,
        ]);
    }
}

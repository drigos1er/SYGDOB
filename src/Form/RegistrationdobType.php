<?php

namespace App\Form;

use App\Entity\SygdobUser;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationdobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class)
            ->add('firstname',TextType::class,[
                'required'=>false])
            ->add('lastname', TextType::class,[
            'required'=>false])
            ->add('gender',choiceType::class,array('label'=>'Genre : ', 'required'=>false,'choices' => array(
                '--selectionner le genre--' => '','M' => 'M','F'=>'F')

                ))
            ->add('phone',TextType::class,[
            'required'=>false])
            ->add('email',EmailType::class,[
                'required'=>false])
            ->add('picture', FileType::class,[
                'required'=>false])




            ->add('userrole',choiceType::class,array('label'=>'Rôle : ', 'choices' => array(
                '--selectionner le rôle--' => '','Informaticien DOB' => '4','Secrétariat DOB'=>'9','Utilisateur DEEP'=>'7','Utilisateur POSTCNO'=>'8','Administrateur'=>'5'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))




            ->add('userstructure',choiceType::class,array('label'=>'Structure : ', 'choices' => array(
                '--selectionner la structure--' => '','DOB' => 'DOB','DEEP'=>'DEEP'),
                'attr' => array(
                    'class' =>'form-control'),'constraints' => array(
                    new NotBlank(),
                )))






        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SygdobUser::class,
        ]);
    }
}

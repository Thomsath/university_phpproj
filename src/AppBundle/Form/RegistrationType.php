<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('nom', TextType::class, [
            'attr' => [
                'placeholder' => 'Votre nom'
            ]
        ])

         ->add('date_naissance', TextType::class, [
            'attr' => [
                'placeholder' => 'Votre date de naissance'
            ]
        ])

         ->add('sexe', ChoiceType::class, [
            'attr' => [
                'placeholder' => 'Votre sexe'
            ],
            'choices' => array('M' => 'true', 'F' => 'false'),
            'mapped' => false, 
        ]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->getBlockPrefix();
    }

    /**
     * Get date_naissance
     *
     * @return DateTime
     */
    public function getDateNaissance()
    {
        return $this->getBlockPrefix();;
    }

     /**
     * Get sexe
     *
     * @return boolean
     */
    public function getSexe()
    {
        return $this->getBlockPrefix();
    }

}
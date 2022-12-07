<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;




class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                            'minMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 35,
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                            'minMessage' => 'votre prenom doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 35,
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                    'attr' => [
                        'placeholder' => 'exemple: 1 rue du faubourg',
                    ],
                    'constraints' => [
                        new Length([
                            'min' => 1,
                                'minMessage' => 'votre adresse doit contenir au moins {{ limit }} caractères',
                                // max length allowed by Symfony for security reasons
                                'max' => 100,
                        ])
                    ]
                ])
            ->add('cp', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 5,
                            'minMessage' => 'votre CP doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 50,
                    ])
                ]
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                            'minMessage' => 'votre ville doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 50,
                    ])
                ]
            ])
            ->add('pays', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 1,
                            'minMessage' => 'votre pays doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 50,
                    ])
                ]
            ])              
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Length([
                        'min' => 6,
                            'minMessage' => ' votre email doit contenir au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 180,
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'entrez un mot de passe svp',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'le mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,  
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez acceptez les conditions',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

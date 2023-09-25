<?php

namespace App\Form;
use App\Entity\User; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {
       
        $builder
            ->add('name', TextType::class, [
                'label' => 'Your name',
                'attr' => [
                    'placeholder' => 'Enter your name',
                    'class' => 'custom-css-class',
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email address',
            ])

            // ->add('password', PasswordType::class, [
            //     'label' => 'Password',
            // ]);

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'User' => 0, // Map 'User' to 0
                    'Admin' => 1, // Map 'Admin' to 1
                ],
                'expanded' => true, // Display as radio buttons or checkboxes
                'multiple' => false, // Allow selecting only one role
            ]);

            // ->add('password', RepeatedType::class, [
            //     'type' => PasswordType::class,
            //     'first_options' => [
            //         'label' => 'Password',
            //     ],
            //     'second_options' => [
            //         'label' => 'Confirm password',
            //     ],
            //     'constraints' => [
            //         new NotBlank(),
            //         new EqualTo('password', message: 'The passwords must match.'),
            //         new Length([
            //             'min' => 8,
            //         ]),
            //         new Regex([
            //             'pattern' => '/[a-zA-Z]{6}[0-9]{1}[#?!@$%^&*-]{1}/',
            //         ]),
            //     ],
            // ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

   
}

?>

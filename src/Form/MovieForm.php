<?php
namespace App\Form;

use App\Entity\Movie; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Director;
use App\Entity\Category;

class MovieForm extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $directors = $this->entityManager->getRepository(Director::class)->findAll();
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        $directorChoices = ['-Select-' => ''];
        $categoryChoices = ['-Select-' => ''];

        $directorChoices['Other'] = '001';
        $categoryChoices['Other'] = '001';

        foreach ($directors as $director) {
            $directorChoices[$director->getDirectorName()] = $director->getDirectorId();
        }

        foreach ($categories as $category) {
            $categoryChoices[$category->getCategoryName()] = $category->getCategoryId();
        }

        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'placeholder' => 'Enter Movie Title',
                ],
            ])
            ->add('director_id', ChoiceType::class, [
                'choices' => $directorChoices,
                'label' => 'Director',
                'required' => false,
            ])
            ->add('category_id', ChoiceType::class, [
                'choices' => $categoryChoices,
                'label' => 'Movie Category',
                'required' => false,
            ])
            ->add('director_other', TextType::class, [
                'label' => 'Other Director',
                'required' => false,
                'mapped' => false,
            ])
            ->add('category_other', TextType::class, [
                'label' => 'Other Category',
                'required' => false,
                'mapped' => false,
            ])
            ->add('budget', IntegerType::class, [
                'required' => false,
                'label' => 'Budget',
                'attr' => [
                    'placeholder' => 'Enter Movie Budget',
                ],
            ])
            ->add('descript', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Enter Movie Description',
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}

// namespace App\Form;

// use App\Entity\Movie; 
// // use App\Entity\MovieMedia; 
// use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\IntegerType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\FileType;
// use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
// use Symfony\Component\OptionsResolver\OptionsResolver;
// use Doctrine\ORM\EntityManagerInterface; // Import EntityManagerInterface
// use App\Entity\Director; // Import Director entity
// use App\Entity\Category; // Import Category entity

// class MovieForm extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options): void
//     {

//         private $entityManager;

//         public function __construct(EntityManagerInterface $entityManager)
//         {
//             $this->entityManager = $entityManager;
//         }

//         $directors = $this->entityManager->getRepository(Director::class)->findAll();
//         $categories = $this->entityManager->getRepository(Category::class)->findAll();

//         // Create arrays to hold the choices
//         $directorChoices = ['-Select-' => ''];
//         $categoryChoices = ['-Select-' => ''];

//         foreach ($directors as $director) {
//             $directorChoices[$director->getDirectorName()] = $director->getDirectorId();
//         }

//         foreach ($categories as $category) {
//             $categoryChoices[$category->getCategoryName()] = $category->getCategoryId();
//         }


//         $builder
//         ->add('title', TextType::class, [
//             'label' => 'Title',
//             'attr' => [
//                 'placeholder' => 'Enter Movie Title',
//             ],
//         ])
//         // ->add('director_id', ChoiceType::class, [
//         //     'choices' => [
//         //         '-Select-' => '',
//         //         'Mahesh Bhatt' => 1,
//         //         'Rohit Shetty' => 2,
//         //         'Other' => 4,
//         //     ],
//         //     'label' => 'Director',
//         //     'required' => false,
//         // ])
//         // ->add('category_id', ChoiceType::class, [
//         //     'choices' => [
//         //         '-Select-' => '',
//         //         'Bollywood' => 1,
//         //         'Hollywood' => 2,
//         //         'Other' => 4,
//         //     ],
//         //     'label' => 'Movie Category',
//         //     'required' => false,
//         // ])
//         ->add('director_id', ChoiceType::class, [
//             'choices' => $directorChoices,
//             'label' => 'Director',
//             'required' => false,
//         ])
//         ->add('category_id', ChoiceType::class, [
//             'choices' => $categoryChoices,
//             'label' => 'Movie Category',
//             'required' => false,
//         ])
//         ->add('director_other', TextType::class, [
//             'label' => 'Other Director',
//             'required' => false,
//             'mapped' => false,
//         ])
//         ->add('category_other', TextType::class, [
//             'label' => 'Other Category',
//             'required' => false,
//             'mapped' => false, // This field is not mapped to the entity
//         ])
//         ->add('budget', IntegerType::class, [
//             'required' => false,
//             'label' => 'Budget',
//             'attr' => [
//                 'placeholder' => 'Enter Movie Budget',
//             ],
//         ])
//         ->add('image_name', FileType::class, [
//             'label' => 'Images',
//             'multiple' => true, // Allow multiple file uploads
//             'required' => false, // Make it optional
//             'mapped' => false, // This field is not mapped to the entity
//         ])
//         ->add('descript', TextareaType::class, [
//             'required' => false,
//             'label' => 'Description',
//             'attr' => [
//                 'placeholder' => 'Enter Movie Description',
//             ],
//         ]);
//     }

//     public function configureOptions(OptionsResolver $resolver)
//     {
//         $resolver->setDefaults([
//             'data_class' => Movie::class,
//         ]);
//     }
// }


?>
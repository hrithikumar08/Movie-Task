<?php
namespace App\Form;

use App\Entity\Movie; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Crew;

class CrewForm extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();

        $movieChoices = ['-Select-' => ''];
        foreach ($movies as $movie) {
            $movieChoices[$movie->getTitle()] = $movie->getMovieId();
        }

        $builder
            ->add('crew_name', TextType::class, [
                'label' => 'Crew Name',
                'attr' => [
                    'placeholder' => 'Enter Crew Name',
                ],
            ])
            ->add('crew_role', TextType::class, [
                'label' => 'Crew Role',
                'attr' => [
                    'placeholder' => 'Enter Crew Role',
                ],
            ])
            ->add('movie_id', ChoiceType::class, [
                'choices' => $movieChoices,
                'label' => 'Movies',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Crew::class,
        ]);
    }
}

?>
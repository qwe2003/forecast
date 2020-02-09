<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $postions = $this->em->getRepository(Position::class)->findAll();
        $choices = [];
        foreach ($postions as $postion) {
            $choices[$postion->getTitle()] = $postion->getId();
        }

        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('position', CollectionType::class, ['entry_type' => PositionType::class])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}

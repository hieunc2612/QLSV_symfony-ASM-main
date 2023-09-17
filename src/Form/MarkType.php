<?php

namespace App\Form;

use App\Entity\Mark;
use App\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Student;

class MarkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ASM1')
            ->add('ASM2')
            ->add('Average')
            ->add('Status')
            ->add('Student', EntityType::class, ['class' => Student::class, 'choice_label' => 'Name'])
            ->add('Subject', EntityType::class, ['class' => Subject::class, 'choice_label' => 'Name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mark::class,
        ]);
    }
}

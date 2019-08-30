<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('score')
            ->add('commentary')
            ->add('movie', EntityType::class, array(
                'class' => Movie::class,
                'choice_label' => 'originalTitle'
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
            'translation_domain' => 'forms'
        ]);
    }
}

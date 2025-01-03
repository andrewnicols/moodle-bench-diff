<?php

namespace App\Form;

use App\Model\Dataset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatasetComparisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datasets', ChoiceType::class, [
                'label' => 'Datasets',
                'choices' => array_reduce(
                    $options['datasets'],
                    function (array $carry, Dataset $dataset): array {
                        $carry[$dataset->getTitle()] = $dataset->getName();

                        return $carry;
                    },
                    [],
                ),
                'required' => true,
                'multiple' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Compare',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'datasets' => [],
        ]);

        $resolver->setAllowedTypes('datasets', 'iterable');
    }
}

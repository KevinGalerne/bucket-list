<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Idea;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ["attr"=>["placeholder"=>"Find my treasure"]])

            ->add('description',
                TextareaType::class,
                ["attr"=>["class"=>"textarea","placeholder"=>"I buried it in a sandy shore on a small island, but i forgot wich one it was"]])
            ->add('author', null, ["attr"=>["placeholder"=>"Red Rackham"]])
            ->add('category', EntityType::class, ["class"=>"App\Entity\Category", "choice_label"=>"name"])

            ->add("Arrh", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
        ]);
    }
}

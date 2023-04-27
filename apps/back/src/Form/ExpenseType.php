<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;

class ExpenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre : '
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date : ',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'data' => new \DateTimeImmutable()
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant : ',
                'divisor' => 100,
                'constraints' => [new GreaterThan(0)]
            ])
            ->add('payer', EntityType::class, [
                'class' => User::class,
                'label' => 'Payée par : '
            ])
            ->add('participants', EntityType::class, [
                'class' => User::class,
                'label' => 'Pour qui : ',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('group', EntityType::class, [
                'class' => Group::class,
                'label' => 'Groupe : '
            ])
            // ->add('addExpense', SubmitType::class, [
            //     'label' => 'Ajouter'
            // ])
            ;
    }
}

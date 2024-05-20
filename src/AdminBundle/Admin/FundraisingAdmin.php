<?php

declare(strict_types=1);

namespace App\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FundraisingAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with($this->getClassnameLabel(), [
                'auto_created' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ])
            ->add('name', TextType::class, [
                'label' => 'Название',
                'required' => true,
            ])
            ->add('amount', MoneyType::class, [
                'currency' => 'RUB',
                'label' => 'Целевая сумма',
                'required' => true,
            ])
            ->add('participants', ModelType::class, [
                'label' => 'Участники',
                'multiple' => true,
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', IntegerType::class, [
                'label' => '№'
            ])
            ->add('name', TextType::class, [
                'label' => 'Название'
            ])
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Целевая сумма',
                'currency' => '₽',
            ])
            ->add('totalContributionsAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма взносов',
                'currency' => '₽',
            ])
            ->add('contributionsAmountPerParticipant', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Сумма взносов на 1 участника',
                'currency' => '₽',
            ])
            ->add('totalExpendituresAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма расходов',
                'currency' => '₽',
            ])
            ->add('expendituresAmountPerParticipant', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Сумма расходов на 1 участника',
                'currency' => '₽',
            ])
            ->add('totalRemainingAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общий остаток',
                'currency' => '₽',
            ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->with($this->getClassnameLabel(), [
                'auto_created' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ])
            ->add('id', IntegerType::class, [
                'label' => '№'
            ])
            ->add('name', TextType::class, [
                'label' => 'Название'
            ])
            ->add('participants', FieldDescriptionInterface::TYPE_MANY_TO_MANY, [
                'label' => 'Участники'
            ])
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Целевая сумма',
                'currency' => '₽',
            ])
            ->add('totalContributionsAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма взносов',
                'currency' => '₽',
            ])
            ->add('contributionsAmountPerParticipant', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Сумма взносов на 1 участника',
                'currency' => '₽',
            ])
            ->add('totalExpendituresAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма расходов',
                'currency' => '₽',
            ])
            ->add('expendituresAmountPerParticipant', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Сумма расходов на 1 участника',
                'currency' => '₽',
            ])
            ->add('totalRemainingAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общий остаток',
                'currency' => '₽',
            ]);
    }
}

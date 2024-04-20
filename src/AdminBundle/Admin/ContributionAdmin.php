<?php

declare(strict_types=1);

namespace App\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContributionAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with($this->getClassnameLabel(), [
                'auto_created' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ])
            ->add('fundraising', ModelType::class, [
                'required' => true,
            ])
            ->add('student', ModelType::class, [
                'required' => true,
            ])
            ->add('created_at', DatePickerType::class, [
                'label' => 'Дата взноса',
                'input' => 'datetime_immutable',
                'format' => 'dd.MM.yyyy',
                'required' => true,
            ])
            ->add('amount', MoneyType::class, [
                'currency' => 'RUB',
                'label' => 'Сумма',
                'required' => true,
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', IntegerType::class, [
                'label' => '№'
            ])
            ->add('fundraising', FieldDescriptionInterface::TYPE_MANY_TO_ONE, [
                'label' => 'Сбор'
            ])
            ->add('student', FieldDescriptionInterface::TYPE_MANY_TO_ONE, [
                'label' => 'Ученик'
            ])
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'Дата взноса',
                'format' => 'd.m.Y'
            ])
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Сумма',
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
            ->add('fundraising', FieldDescriptionInterface::TYPE_MANY_TO_ONE, [
                'label' => 'Сбор'
            ])
            ->add('student', FieldDescriptionInterface::TYPE_MANY_TO_ONE, [
                'label' => 'Ученик'
            ])
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'Дата взноса',
                'format' => 'd.m.Y'
            ])
            ->add('amount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Сумма',
                'currency' => '₽',
            ]);
    }
}

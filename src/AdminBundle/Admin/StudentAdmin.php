<?php

declare(strict_types=1);

namespace App\AdminBundle\Admin;

use App\Entity\Student;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/** @extends AbstractAdmin<Student> */
class StudentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with($this->getClassnameLabel(), [
                'auto_created' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Фамилия',
                'required' => true,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Имя',
                'required' => true,
            ])
            ->add('birthdate', DatePickerType::class, [
                'label' => 'Дата рождения',
                'required' => true,
                'input' => 'datetime_immutable',
                'format' => 'dd.MM.yyyy'
            ])
            ->add('createdAt', DatePickerType::class, [
                'label' => 'Дата поступления в класс',
                'required' => true,
                'input' => 'datetime_immutable',
                'format' => 'dd.MM.yyyy'
            ])
            ->add('deletedAt', DatePickerType::class, [
                'label' => 'Дата ухода из класса',
                'required' => false,
                'input' => 'datetime_immutable',
                'format' => 'dd.MM.yyyy'
            ]);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id', IntegerType::class, [
                'label' => '№'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Фамилия'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Имя'
            ])
            ->add('totalFundraisingsAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма сборов',
                'currency' => '₽',
            ])
            ->add('totalContributionsAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма взносов',
                'currency' => '₽',
            ])
            ->add('totalDebtAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма задолженности',
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
            ->add('lastname', TextType::class, [
                'label' => 'Фамилия'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Имя'
            ])
            ->add('birthdate', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'Дата рождения',
                'format' => 'd.m.Y'
            ])
            ->add('createdAt', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'Дата поступления в класс',
                'format' => 'd.m.Y'
            ])
            ->add('deletedAt', FieldDescriptionInterface::TYPE_DATE, [
                'label' => 'Дата ухода из класса',
                'format' => 'd.m.Y'
            ])
            ->add('totalFundraisingsAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма сборов',
                'currency' => '₽',
            ])
            ->add('totalContributionsAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма взносов',
                'currency' => '₽',
            ])
            ->add('totalDebtAmount', FieldDescriptionInterface::TYPE_CURRENCY, [
                'label' => 'Общая сумма задолженности',
                'currency' => '₽',
            ]);
    }
}

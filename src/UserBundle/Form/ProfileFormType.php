<?php

namespace UserBundle\Form;

use AppBundle\Entity\MemberStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use UserBundle\Entity\User;

/**
 * ProfileFormType for users to update their profile
 */
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, ['label' => 'app.profile.firstname']);
        $builder->add('lastName', TextType::class, ['label' => 'app.profile.lastname']);
        $builder->add('address', TextareaType::class, ['label' => 'app.profile.address']);
        $builder->add(
            'gender',
            ChoiceType::class,
            [
                'label' => 'app.profile.gender',
                'choices' => [
                    'app.members.sex.undefined' => null,
                    'app.members.sex.male' => User::SEX_MALE,
                    'app.members.sex.female' => User::SEX_FEMALE,
                ],
                'choices_as_values' => true,
            ]
        );
        $builder->add(
            'memberStatuses',
            EntityType::class,
            [
                'class' => MemberStatus::class,
                'label' => 'app.profile.memberStatuses',
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'translate.mixedName',
            ]
        );
        $builder->remove('username');
        $builder->remove('current_password');
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'app_user_profile';
    }
}

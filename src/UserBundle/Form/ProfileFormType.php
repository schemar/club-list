<?php

namespace UserBundle\Form;

use AppBundle\Entity\MemberStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * ProfileFormType for users to update their profile
 */
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class);
        $builder->add('lastName', TextType::class);
        $builder->add('address', TextareaType::class);
        $builder->add(
            'memberStatuses',
            EntityType::class,
            [
                'class' => MemberStatus::class,
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

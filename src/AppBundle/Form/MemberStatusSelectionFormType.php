<?php

namespace AppBundle\Form;

use AppBundle\Entity\MemberStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * MemberStatusSelectionFormType to select certain member statuses
 */
class MemberStatusSelectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'memberStatuses',
            EntityType::class,
            [
                'class' => MemberStatus::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'translate.mixedName',
            ]
        )
            ->add('save', SubmitType::class, ['label' => 'app.members.filter']);
    }

    public function getName()
    {
        return 'app_member_status_selection';
    }
}

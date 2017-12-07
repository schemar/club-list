<?php

namespace AppBundle\Form;

use AppBundle\Entity\MemberStatus;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'label' => 'app.members.memberStatusesFilter',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('status')
                        ->orderBy('status.priority', 'DESC');
                },
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'translate.mixedName',
            ]
        )
            ->add('save', SubmitType::class, ['label' => 'app.members.filter']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}

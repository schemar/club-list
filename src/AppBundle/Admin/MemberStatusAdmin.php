<?php

namespace AppBundle\Admin;

use AppBundle\Entity\MemberStatus;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * MemberStatusAdmin
 */
class MemberStatusAdmin extends AbstractAdmin
{
    /**
     * @param MemberStatus $memberStatus
     */
    public function prePersist($memberStatus)
    {
        $memberStatus->mergeNewTranslations();
    }

    /**
     * @param MemberStatus $memberStatus
     */
    public function preUpdate($memberStatus)
    {
        $memberStatus->mergeNewTranslations();
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', ['class' => 'col-md-4'])
                ->add(
                    'priority',
                    IntegerType::class,
                    [
                        'help' => 'Statuses with a higher priority are listed before statuses with a lower priority.',
                    ]
                )
            ->end()
            ->with('English', ['class' => 'col-md-4'])
                ->add('englishName', TextType::class)
                ->add('englishDescription', TextType::class)
            ->end()
            ->with('German', ['class' => 'col-md-4'])
                ->add('germanMaleName', TextType::class)
                ->add('germanMaleDescription', TextType::class)
                ->add('germanFemaleName', TextType::class, ['required' => false])
                ->add('germanFemaleDescription', TextType::class, ['required' => false])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('priority')
            ->addIdentifier('englishName')
            ->addIdentifier('germanMaleName');
    }
}

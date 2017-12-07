<?php

namespace AppBundle\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use UserBundle\Entity\User;

/**
 * UserAdmin
 */
class UserAdmin extends AbstractAdmin
{
    /** @var UserManagerInterface */
    private $userManager;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    /**
     * @param User $user
     */
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
    }

    /**
     * Create a random password for a new user
     *
     * User must use "password reset".
     *
     * @param User $user
     */
    public function prePersist($user)
    {
        $randomPassword = openssl_random_pseudo_bytes(30);
        $user->setPlainPassword($randomPassword);
    }

    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getUserManager()
    {
        return $this->userManager;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('email', TextType::class)
                ->add('firstName', TextType::class, ['required' => false])
                ->add('lastName', TextType::class, ['required' => false])
                ->add('address', TextareaType::class, ['required' => false])
                ->add('memberStatuses')
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('email');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('email');
        $listMapper->addIdentifier('firstName');
        $listMapper->addIdentifier('lastName');
    }
}

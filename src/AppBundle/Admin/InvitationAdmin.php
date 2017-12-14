<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Invitation;
use AppBundle\Mailer\Mail;
use AppBundle\Mailer\Mailer;
use AppBundle\Mailer\Recipient;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\User;

/**
 * InvitationAdmin
 */
class InvitationAdmin extends AbstractAdmin
{
    /** @var Mailer */
    private $mailer;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var RouterInterface */
    private $router;

    /**
     * @param Mailer $mailer
     */
    public function setMailer(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
    }

    /**
     * Sends the welcome email to the invitee.
     *
     * @param Invitation $invitation
     */
    public function prePersist($invitation)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $inviter = $user->getFirstName() ?: $user->getEmail();

        $subject = $this->trans(
            'app.registration.invitationEmail.subject',
            [
                '%invitee%' => $invitation->getEmail(),
            ],
            null,
            $invitation->getLocale()
        );
        $body = $this->trans(
            'app.registration.invitationEmail.body',
            [
                '%invitee%' => $invitation->getEmail(),
                '%code%' => $invitation->getCode(),
                '%inviter%' => $inviter,
                '%registrationUrl%' => $this->router->generate('fos_user_registration_register', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ],
            null,
            $invitation->getLocale()
        );

        $recipient = new Recipient($invitation->getEmail(), $invitation->getEmail());

        $mail = new Mail([$recipient], $subject, $body);
        $wasSuccess = $this->mailer->send($mail);

        if ($wasSuccess) {
            $invitation->send();
        }
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('email', TextType::class);
        $formMapper->add(
            'locale',
            ChoiceType::class,
            [
                'choices' => ['en' => 'en', 'de' => 'de'],
            ]
        );
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('code');
        $show->add('email');
        $show->add('sent');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('email');
        $datagridMapper->add('code');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('code');
        $listMapper->addIdentifier('email');
        $listMapper->add('sent');
    }
}

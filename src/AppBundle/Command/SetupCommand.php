<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * SetupCommand creates the super admin user
 */
class SetupCommand extends ContainerAwareCommand
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('app:setup')
            ->setDescription('Creates a super admin user.')
            ->setHelp('This command creates the super admin that is required for first login to this application.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Setup');

        if($this->itRanBefore($io)) {
            return 1;
        }

        $email = $this->getEmail($io);
        $password = $this->getPassword($io);
        $this->createUser($email, $password);

        return 0;
    }

    /**
     * @param SymfonyStyle $io
     * @return string
     */
    private function getEmail(SymfonyStyle $io)
    {
        return $io->ask('What is the admin\'s email?', null, function ($email) {
            if (empty($email)) {
                throw new \RuntimeException('Email cannot be empty.');
            }

            $emailConstraint = new EmailConstraint();

            /** @var ValidatorInterface $validator */
            $validator = $this->getContainer()->get('validator');
            $errors = $validator->validate(
                $email,
                $emailConstraint
            );

            if ($errors->count()) {
                throw new \RuntimeException($errors->get(0)->getMessage());
            }

            return $email;
        });
    }

    /**
     * @param SymfonyStyle $io
     * @return string
     */
    private function getPassword(SymfonyStyle $io)
    {
        return $io->askHidden('What is the admin\'s password?', function ($password) {
            if (empty($password)) {
                throw new \RuntimeException('Password cannot be empty.');
            }

            return $password;
        });
    }

    /**
     * @param string $email
     * @param string $password
     */
    private function createUser($email, $password)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->addRole('ROLE_SUPER_ADMIN');
        $user->setEnabled(true);
        $userManager->updateUser($user);
    }

    /**
     * Returns true if the command has been run before.
     *
     * @param SymfonyStyle $io
     * @return bool
     */
    private function itRanBefore(SymfonyStyle $io)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        if (count($users)) {
            $io->error('This command has been run before. You cannot run it again.');

            return true;
        }

        return false;
    }
}

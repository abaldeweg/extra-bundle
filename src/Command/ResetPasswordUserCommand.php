<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordUserCommand extends Command
{
    private EntityManagerInterface $em;
    private UserPasswordEncoderInterface $encoder;
    private ParameterBagInterface $params;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder,
        ParameterBagInterface $params
    ) {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->params = $params;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('user:reset-password')
            ->setDescription('Resets the password of a user.')
            ->setHelp('This command resets the password of a user.')
            ->addArgument('id', InputArgument::REQUIRED, 'The id of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = $this->em->getRepository(
            $this->params->get('baldeweg_extra.userclass')
        )->find(
            $input->getArgument('id')
        );
        $pass = bin2hex(random_bytes(6));
        $user->setPassword(
            $this->encoder->encodePassword($user, $pass)
        );
        $this->em->flush();

        $io->success('Passwort: ' . $pass);

        return Command::SUCCESS;
    }
}

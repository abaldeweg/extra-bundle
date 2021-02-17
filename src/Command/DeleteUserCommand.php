<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DeleteUserCommand extends Command
{
    private EntityManagerInterface $em;
    private ParameterBagInterface $params;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params)
    {
        parent::__construct();
        $this->em = $em;
        $this->params = $params;
    }

    protected function configure(): void
    {
        $this
            ->setName('user:delete')
            ->setDescription('Deletes a user')
            ->setHelp('This command deletes a user.')
            ->addArgument('id', InputArgument::REQUIRED, 'The id of the user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->em->remove(
            $this->em->getRepository(
                $this->params->get('baldeweg_extra.userclass')
            )->find(
                $input->getArgument('id')
            )
        );
        $this->em->flush();

        $io->success('The user was deleted!');

        return Command::SUCCESS;
    }
}

<?php

namespace Baldeweg\Bundle\ExtraBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

final class MakeDoc extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:extra:doc';
    }

    public static function getCommandDescription(): string
    {
        return 'Generates some important files for the framework.';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        if (!is_file('README.md')) {
            copy(__DIR__ . '/../Resources/templates/README.md', 'README.md');
        }
    }
}

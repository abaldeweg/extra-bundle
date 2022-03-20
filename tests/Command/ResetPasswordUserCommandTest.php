<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use Baldeweg\Bundle\ExtraBundle\Command\ResetPasswordUserCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordUserCommandTest extends TestCase
{
    public function testExecute()
    {
        $em = $this->getMockBuilder('\\Doctrine\\ORM\\EntityManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $encoder = $this->getMockBuilder(UserPasswordHasherInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $params = $this->getMockBuilder('\\Symfony\\Component\\DependencyInjection\\ParameterBag\\ParameterBagInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new ResetPasswordUserCommand($em, $encoder, $params));
        $command = $application->find('user:reset-password');

        $this->assertEquals(
            'user:reset-password',
            $command->getName(),
            'ResetPasswordUserCommandTest user:reset-password'
        );
    }
}

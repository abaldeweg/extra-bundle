<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use Baldeweg\Bundle\ExtraBundle\Command\NewUserCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

class NewUserCommandTest extends TestCase
{
    public function testExecute()
    {
        $em = $this->getMockBuilder('\\Doctrine\\ORM\\EntityManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $encoder = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\Encoder\\UserPasswordEncoderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $params = $this->getMockBuilder('\\Symfony\\Component\\DependencyInjection\\ParameterBag\\ParameterBagInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new NewUserCommand($em, $encoder, $params));
        $command = $application->find('user:new');

        $this->assertEquals(
            'user:new',
            $command->getName(),
            'NewUserCommandTest user:new'
        );
    }
}

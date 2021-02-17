<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use Baldeweg\Bundle\ExtraBundle\Command\ListUserCommand;
use Symfony\Component\Console\Application;

class ListUserCommandTest extends TestCase
{
    public function testExecute()
    {
        $em = $this->getMockBuilder('\\Doctrine\\ORM\\EntityManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $params = $this->getMockBuilder('\\Symfony\\Component\\DependencyInjection\\ParameterBag\\ParameterBagInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $application = new Application();
        $application->add(new ListUserCommand($em, $params));
        $command = $application->find('user:list');

        $this->assertEquals(
            'user:list',
            $command->getName(),
            'ListUserCommandTest user:list'
        );
    }
}

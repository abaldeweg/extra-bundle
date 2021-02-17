<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests\Command;

use Baldeweg\Bundle\ExtraBundle\Command\ShowUserCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

class ShowUserCommandTest extends TestCase
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
        $application->add(new ShowUserCommand($em, $params));
        $command = $application->find('user:show');

        $this->assertEquals(
            'user:show',
            $command->getName(),
            'ShowUserCommandTest user:show'
        );
    }
}

<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests;

use Baldeweg\Bundle\ExtraBundle\Service\MeUser;
use PHPUnit\Framework\TestCase;

class MeUserTest extends TestCase
{
    public function testMeUser()
    {
        $user = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\User\\UserInterface')
            ->setMethods(['getId', 'getRoles', 'getPassword', 'getSalt', 'getUsername', 'eraseCredentials'])
            ->disableOriginalConstructor()
            ->getMock();
        $user->method('getId')
            ->willReturn('1');
        $user->method('getUsername')
            ->willReturn('admin');
        $user->method('getRoles')
            ->willReturn('ROLE_USER');

        $token = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\TokenInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $token->method('getUser')
            ->willReturn($user);

        $tokenStorage = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\Authentication\\Token\\Storage\\TokenStorageInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenStorage->method('getToken')
            ->willReturn($token);

        $auth = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\Authorization\\AuthorizationCheckerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $auth->method('isGranted')
            ->willReturn(true);

        $me = new MeUser($tokenStorage, $auth);

        $response = json_decode($me->me()->getContent());

        $this->assertIsObject($response);
        $this->assertIsString($response->id);
        $this->assertIsString($response->username);
        $this->assertIsString($response->roles);
        $this->assertIsBool($response->isUser);
        $this->assertIsBool($response->isAdmin);
    }
}

<?php

namespace Baldeweg\Bundle\ExtraBundle\Tests;

use Baldeweg\Bundle\ExtraBundle\Service\PasswordUser;
use PHPUnit\Framework\TestCase;

class PasswordUserTest extends TestCase
{
    public function testPasswordUser()
    {
        $user = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\User\\UserInterface')
            ->setMethods(['getId', 'setPassword', 'getRoles', 'getPassword', 'getSalt', 'getUsername', 'eraseCredentials'])
            ->disableOriginalConstructor()
            ->getMock();
        $user->method('getPassword')
            ->willReturn('password');

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

        $encoder = $this->getMockBuilder('\\Symfony\\Component\\Security\\Core\\Encoder\\UserPasswordEncoderInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $encoder->method('encodePassword')
            ->willReturn('password');

        $object = $this->getMockBuilder('\\Doctrine\\Persistence\\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->getMockBuilder('\\Doctrine\\Persistence\\ManagerRegistry')
            ->disableOriginalConstructor()
            ->getMock();
        $manager->method('getManager')
            ->willReturn($object);

        $formInterface = $this->getMockBuilder('\\Symfony\\Component\\Form\\FormInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $formInterface->method('isSubmitted')
            ->willReturn(true);
        $formInterface->method('isValid')
            ->willReturn(true);

        $form = $this->getMockBuilder('\\Symfony\\Component\\Form\\FormFactoryInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $form->method('create')
            ->willReturn($formInterface);

        $request = $this->getMockBuilder('\\Symfony\\Component\\HttpFoundation\\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $password = new PasswordUser($tokenStorage, $auth, $encoder, $manager, $form);

        $response = json_decode($password->password($request)->getContent());

        $this->assertIsObject($response);
    }
}
